<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Dashboard Customer
    public function customer()
    {
        $user = Auth::user();

        // Ambil konsultasi aktif milik customer
        $activeConsultations = DB::table('consultations')
            ->where('patient_id', $user->id)
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer_dashboard', compact('activeConsultations'));
    }

    // Dashboard Psikolog
    public function psychologist()
    {
        // Ambil data user yang login
        $user = Auth::user();

        // Ambil konsultasi dari database
        $consultationsRaw = DB::table('consultations')
            ->where('psychologist_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Format data untuk view
        $appointments = [];
        foreach ($consultationsRaw as $consult) {
            // Ambil nama pasien
            $patient = DB::table('account')->where('id', $consult->patient_id)->first();

            // Hitung pesan belum dibaca dari pasien
            $unreadCount = DB::table('chat_messages')
                ->where('consultation_id', $consult->id)
                ->where('sender_role', 'patient')
                ->where('is_read', false)
                ->count();

            // Format tanggal dan jam berbasis GMT+7 Asia/Jakarta
            $createdAt = \Carbon\Carbon::parse($consult->created_at)->timezone('Asia/Jakarta');
            
            $timeFormatted = $createdAt->format('H:i'); // 24-hour format (e.g. 14:30)

            $dateLabel = 'Lainnya';
            $dateType = 'other';

            if ($createdAt->isToday()) {
                $dateLabel = 'Hari Ini';
                $dateType = 'today';
            } elseif ($createdAt->isTomorrow()) {
                $dateLabel = 'Besok';
                $dateType = 'tomorrow';
            } else {
                $dateLabel = $createdAt->format('d M Y');
            }

            $appointments[] = [
                'id' => $consult->id,
                'client' => $patient->username ?? 'Unknown',
                'time' => $timeFormatted,
                'date' => $dateLabel,
                'date_type' => $dateType,
                'status' => ucfirst($consult->status),
                'unread' => $unreadCount,
            ];
        }

        $verification = DB::table('psychologist_certificates')
            ->where('psychologist_id', $user->id)
            ->orderBy('uploaded_at', 'desc') // Ambil yang paling baru
            ->first();

        // Hitung total unread
        $totalUnread = collect($appointments)->sum('unread');

        // Kirim data ke View
        return view('psychologist_dashboard', compact('user', 'appointments', 'verification', 'totalUnread'));
    }

    // Hapus Riwayat Konsultasi (Sesi Berakhir)
    public function deleteConsultation($id)
    {
        $user = Auth::user();

        // Pastikan sesi konsultasi ini ada dan milik psikolog yang login
        $consult = DB::table('consultations')
            ->where('id', $id)
            ->where('psychologist_id', $user->id)
            ->first();

        if ($consult) {
            // Hapus pesan chat di dalamnya terlebih dahulu (karena foreign key / database cleanup)
            DB::table('chat_messages')->where('consultation_id', $id)->delete();

            // Hapus data konsultasi
            DB::table('consultations')->where('id', $id)->delete();

            return back()->with('success', 'Riwayat konsultasi berhasil dihapus secara permanen!');
        }

        return back()->with('error', 'Gagal menghapus! Riwayat konsultasi tidak ditemukan.');
    }

    // --- CUSTOMER PROFILE UPDATE ---
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => 'required|min:3|max:255',
            'email'    => 'required|email|unique:account,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'username' => $validated['username'],
            'email'    => $validated['email'],
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        // Update the account
        DB::table('account')->where('id', $user->id)->update($data);

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}