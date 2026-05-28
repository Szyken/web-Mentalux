<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Tampilkan halaman chat room untuk konsultasi tertentu.
     * Bisa diakses oleh pasien (patient) maupun psikolog.
     */
    public function show($consultationId)
    {
        $user = Auth::user();

        // Ambil data konsultasi
        $consultation = DB::table('consultations')
            ->where('id', $consultationId)
            ->first();

        if (!$consultation) {
            return redirect('/')->with('error', 'Konsultasi tidak ditemukan.');
        }

        // Pastikan user adalah pemilik konsultasi (pasien atau psikolog)
        $isPatient = ($user->id == $consultation->patient_id);
        $isPsychologist = ($user->id == $consultation->psychologist_id);

        if (!$isPatient && !$isPsychologist) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke konsultasi ini.');
        }

        // Tentukan role user di chat ini
        $userRole = $isPatient ? 'patient' : 'psychologist';

        // Ambil nama partner chat
        if ($isPatient) {
            $partnerName = $consultation->psychologist_name;
        } else {
            $patient = DB::table('account')->where('id', $consultation->patient_id)->first();
            $partnerName = $patient->username ?? 'Pasien';
        }

        // Ambil semua pesan yang sudah ada
        $messages = DB::table('chat_messages')
            ->where('consultation_id', $consultationId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Tandai pesan dari partner sebagai sudah dibaca
        DB::table('chat_messages')
            ->where('consultation_id', $consultationId)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('chat', [
            'consultation' => $consultation,
            'messages' => $messages,
            'userRole' => $userRole,
            'userId' => $user->id,
            'partnerName' => $partnerName,
            'consultationId' => $consultationId,
        ]);
    }

    /**
     * API: Kirim pesan baru (POST, JSON)
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'consultation_id' => 'required|integer',
            'message' => 'required|string|max:5000',
        ]);

        $user = Auth::user();
        $consultationId = $request->input('consultation_id');

        // Verifikasi akses
        $consultation = DB::table('consultations')
            ->where('id', $consultationId)
            ->first();

        if (!$consultation) {
            return response()->json(['error' => 'Konsultasi tidak ditemukan'], 404);
        }

        $isPatient = ($user->id == $consultation->patient_id);
        $isPsychologist = ($user->id == $consultation->psychologist_id);

        if (!$isPatient && !$isPsychologist) {
            return response()->json(['error' => 'Akses ditolak'], 403);
        }

        $senderRole = $isPatient ? 'patient' : 'psychologist';

        // Simpan pesan ke database
        $messageId = DB::table('chat_messages')->insertGetId([
            'consultation_id' => $consultationId,
            'sender_id' => $user->id,
            'sender_role' => $senderRole,
            'message' => $request->input('message'),
            'is_read' => false,
            'created_at' => now(),
        ]);

        $newMessage = DB::table('chat_messages')->where('id', $messageId)->first();

        return response()->json([
            'success' => true,
            'message' => $newMessage,
        ]);
    }

    /**
     * API: Ambil pesan baru setelah ID tertentu (untuk polling)
     */
    public function getMessages(Request $request, $consultationId)
    {
        $user = Auth::user();
        $afterId = $request->query('after_id', 0);

        // Verifikasi akses
        $consultation = DB::table('consultations')
            ->where('id', $consultationId)
            ->first();

        if (!$consultation) {
            return response()->json(['error' => 'Konsultasi tidak ditemukan'], 404);
        }

        $isPatient = ($user->id == $consultation->patient_id);
        $isPsychologist = ($user->id == $consultation->psychologist_id);

        if (!$isPatient && !$isPsychologist) {
            return response()->json(['error' => 'Akses ditolak'], 403);
        }

        // Ambil pesan baru setelah afterId
        $messages = DB::table('chat_messages')
            ->where('consultation_id', $consultationId)
            ->where('id', '>', $afterId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Tandai pesan dari partner sebagai dibaca
        if ($messages->count() > 0) {
            DB::table('chat_messages')
                ->where('consultation_id', $consultationId)
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'consultation_status' => $consultation->status,
            'end_requested_by' => $consultation->end_requested_by,
        ]);
    }

    /**
     * API: Hitung jumlah pesan belum dibaca untuk user yang login
     */
    public function getUnreadCount()
    {
        $user = Auth::user();
        $userRole = strtolower($user->role);

        if ($userRole === 'psychologist') {
            // Untuk psikolog: hitung pesan dari pasien yang belum dibaca
            $unreadData = DB::table('chat_messages')
                ->join('consultations', 'chat_messages.consultation_id', '=', 'consultations.id')
                ->where('consultations.psychologist_id', $user->id)
                ->where('chat_messages.sender_role', 'patient')
                ->where('chat_messages.is_read', false)
                ->select(
                    'chat_messages.consultation_id',
                    DB::raw('COUNT(*) as unread_count')
                )
                ->groupBy('chat_messages.consultation_id')
                ->get();
        } else {
            // Untuk pasien: hitung pesan dari psikolog yang belum dibaca
            $unreadData = DB::table('chat_messages')
                ->join('consultations', 'chat_messages.consultation_id', '=', 'consultations.id')
                ->where('consultations.patient_id', $user->id)
                ->where('chat_messages.sender_role', 'psychologist')
                ->where('chat_messages.is_read', false)
                ->select(
                    'chat_messages.consultation_id',
                    DB::raw('COUNT(*) as unread_count')
                )
                ->groupBy('chat_messages.consultation_id')
                ->get();
        }

        $totalUnread = $unreadData->sum('unread_count');

        return response()->json([
            'success' => true,
            'total_unread' => $totalUnread,
            'per_consultation' => $unreadData,
        ]);
    }

    /**
     * Akhiri sesi konsultasi
     */
    public function endSession($consultationId)
    {
        $user = Auth::user();

        $consultation = DB::table('consultations')
            ->where('id', $consultationId)
            ->first();

        if (!$consultation) {
            return redirect('/')->with('error', 'Konsultasi tidak ditemukan.');
        }

        // Hanya pasien atau psikolog yang bisa mengakhiri
        if ($user->id != $consultation->patient_id && $user->id != $consultation->psychologist_id) {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        DB::table('consultations')
            ->where('id', $consultationId)
            ->update([
                'status' => 'ended',
                'end_requested_by' => null, // Reset
                'updated_at' => now(),
            ]);

        // Redirect sesuai role
        $userRole = strtolower($user->role);
        if ($userRole === 'psychologist') {
            return redirect()->route('dashboard.psychologist')->with('success', 'Sesi konsultasi telah diakhiri.');
        }

        return redirect()->route('dashboard.customer')->with('success', 'Sesi konsultasi telah diakhiri.');
    }

    /**
     * API: Kirim permintaan untuk mengakhiri sesi (POST, JSON)
     */
    public function requestEndSession($consultationId)
    {
        $user = Auth::user();

        DB::table('consultations')
            ->where('id', $consultationId)
            ->update([
                'end_requested_by' => $user->id,
                'updated_at' => now(),
            ]);

        return response()->json(['success' => true]);
    }

    /**
     * API: Tolak permintaan untuk mengakhiri sesi (POST, JSON)
     */
    public function rejectEndSession($consultationId)
    {
        DB::table('consultations')
            ->where('id', $consultationId)
            ->update([
                'end_requested_by' => null,
                'updated_at' => now(),
            ]);

        return response()->json(['success' => true]);
    }
}
