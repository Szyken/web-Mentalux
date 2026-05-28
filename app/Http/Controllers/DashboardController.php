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

        // Ambil konsultasi dari database (bukan dummy lagi!)
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

            $appointments[] = [
                'id' => $consult->id,
                'client' => $patient->username ?? 'Unknown',
                'time' => \Carbon\Carbon::parse($consult->created_at)->format('h:i A'),
                'date' => \Carbon\Carbon::parse($consult->created_at)->isToday() 
                    ? 'Today' 
                    : (\Carbon\Carbon::parse($consult->created_at)->isTomorrow() 
                        ? 'Tomorrow' 
                        : \Carbon\Carbon::parse($consult->created_at)->format('d M Y')),
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