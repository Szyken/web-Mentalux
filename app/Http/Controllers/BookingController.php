<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{   

    public function show($psikolog_name)
    {
        // Data Jam
        $timeSlots = [
            "10.00 - 12.00 WIB",
            "13.00 - 15.00 WIB",
            "16.00 - 18.00 WIB",
            "19.00 - 21.00 WIB",
        ];

        // urldecode buat ngilangin %20 dari URL
        $name = urldecode($psikolog_name);

        // Ambil data detail psikolog dari database
        $psikolog = DB::table('psychologists')->where('name', $name)->first();

        if ($psikolog) {
            // Cari akun psychologist di tabel account
            $psychologistAccount = DB::table('account')
                ->whereRaw('LOWER(role) = ?', ['psychologist'])
                ->where(function($query) use ($name) {
                    $query->where('username', 'LIKE', '%' . $name . '%')
                          ->orWhereRaw('LOWER(?) LIKE CONCAT("%", LOWER(username), "%")', [$name]);
                })
                ->first();

            if ($psychologistAccount) {
                // CEK APAKAH USER LOGGED IN ADALAH PSIKOLOG INI SENDIRI!
                if (Auth::check() && Auth::id() === $psychologistAccount->id) {
                    return redirect()->route('psychologist.index')
                        ->with('error', 'Anda tidak dapat melakukan booking atau berkonsultasi dengan diri Anda sendiri!');
                }

                // Cek apakah ada sertifikat dengan status approved
                $isApproved = DB::table('psychologist_certificates')
                    ->where('psychologist_id', $psychologistAccount->id)
                    ->where('status', 'approved')
                    ->exists();

                if (!$isApproved) {
                    return redirect()->route('psychologist.index')
                        ->with('error', 'Maaf, psikolog ini belum terverifikasi oleh Admin dan belum bisa menerima konsultasi!');
                }
            } else {
                return redirect()->route('psychologist.index')
                    ->with('error', 'Maaf, akun login untuk psikolog ini belum terdaftar di platform!');
            }
        }

        return view('booking', compact('name', 'timeSlots', 'psikolog'));
    }

    public function store(Request $request)
    {
        // Validasi
        $data = $request->validate([
            'psikolog_name' => 'required',
            'tanggal' => 'required',
            'jam' => 'required',
        ]);

        $data['price'] = 'Rp 200.000';

        return redirect('/payment')->with('bookingData', $data);
    }


    public function payment()
    {
        // Ambil data dari session
        $booking = session('bookingData');

        if (!$booking) {
            return redirect('/');
        }

        return view('payment', compact('booking'));
    }

    public function chat(Request $request)
    {
        $user = Auth::user();

        // Ambil nama dokter dari URL (?doctor=...)
        $doctorName = $request->query('doctor');

        if (!$doctorName) {
            $booking = session('bookingData');
            $doctorName = $booking['psikolog_name'] ?? null;
        }

        // Kalau kosong, pake Default
        if (!$doctorName) {
            $doctorName = 'Dr. Dicky Oktrianda'; 
        }

        // Bersihkan format URL
        $doctorName = urldecode($doctorName);

        // Cari psychologist_id dari tabel account berdasarkan nama psikolog
        // Coba cocokkan dengan tabel psychologists dulu, lalu cari di account
        $psychologistAccount = null;
        
        // Cari di tabel account yang role-nya Psychologist
        $psychologistAccount = DB::table('account')
            ->whereRaw('LOWER(role) = ?', ['psychologist'])
            ->where(function($query) use ($doctorName) {
                $query->where('username', 'LIKE', '%' . $doctorName . '%')
                      ->orWhereRaw('LOWER(?) LIKE CONCAT("%", LOWER(username), "%")', [$doctorName]);
            })
            ->first();

        $psychologistId = $psychologistAccount->id ?? null;

        if ($psychologistId) {
            // CEK APAKAH USER LOGGED IN ADALAH PSIKOLOG INI SENDIRI!
            if ($user->id === $psychologistId) {
                return redirect()->route('psychologist.index')
                    ->with('error', 'Anda tidak dapat berkonsultasi dengan diri Anda sendiri!');
            }

            // Cek apakah ada sertifikat dengan status approved
            $isApproved = DB::table('psychologist_certificates')
                ->where('psychologist_id', $psychologistId)
                ->where('status', 'approved')
                ->exists();

            if (!$isApproved) {
                return redirect()->route('psychologist.index')
                    ->with('error', 'Gagal! Psikolog ini belum terverifikasi oleh Admin.');
            }
        } else {
            return redirect()->route('psychologist.index')
                ->with('error', 'Gagal! Akun login Psikolog tidak ditemukan atau belum aktif.');
        }

        // Cek apakah sudah ada konsultasi aktif dengan psikolog ini
        $existingConsultation = DB::table('consultations')
            ->where('patient_id', $user->id)
            ->where('psychologist_name', $doctorName)
            ->where('status', 'active')
            ->first();

        if ($existingConsultation) {
            // Kalau sudah ada, langsung masuk ke chat room yang sama
            return redirect()->route('chat.room', $existingConsultation->id);
        }

        // Buat konsultasi baru
        $consultationId = DB::table('consultations')->insertGetId([
            'patient_id' => $user->id,
            'psychologist_id' => $psychologistId,
            'psychologist_name' => $doctorName,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Buat pesan pembuka otomatis dari psikolog
        DB::table('chat_messages')->insert([
            'consultation_id' => $consultationId,
            'sender_id' => $psychologistId ?? $user->id,
            'sender_role' => 'psychologist',
            'message' => "Halo, selamat datang! 👋\nSaya {$doctorName}. Bagaimana perasaan Anda hari ini? Ada yang bisa saya bantu?",
            'is_read' => false,
            'created_at' => now(),
        ]);

        // Redirect ke chat room
        return redirect()->route('chat.room', $consultationId);
    }
}

