<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Psychologist; // Model Psikolog
use App\Models\User;         // Model User
// use App\Models\Booking;   // Kalau nanti mau hitung booking, buka ini
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private function authorizeAdmin()
    {
        if (!auth()->check() || strtolower(auth()->user()->role) !== 'admin') {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Administrator.');
        }
    }

    public function index()
    {
        $this->authorizeAdmin();

        // 1. Hitung Total Psikolog (Real dari Database)
        $totalPsychologists = Psychologist::count();

        // 2. Hitung Total User
        try {
            $totalUsers = User::count();
        } catch (\Exception $e) {
            $totalUsers = 0; // Fallback kalau tabel user bermasalah
        }

        // 3. Hitung Total Sesi (Dummy dulu kalau belum ada tabel booking)
        $totalSessions = 150; // Angka pura-pura dulu

        // Kirim semua variabel ke View 'admin_dashboard'
        return view('admin_dashboard', compact('totalPsychologists', 'totalUsers', 'totalSessions'));
    }

    public function verifications()
    {
        $this->authorizeAdmin();

        // Ambil data sertifikat join sama data user (biar tau siapa yg upload)
        $certificates = DB::table('psychologist_certificates')
            ->join('account', 'psychologist_certificates.psychologist_id', '=', 'account.id')
            ->select('psychologist_certificates.*', 'account.username as psychologist_name', 'account.email')
            ->orderBy('uploaded_at', 'desc')
            ->get();

        return view('admin_verification', compact('certificates'));
    }

    // 2. Proses Approve
    public function approve($id)
    {
        $this->authorizeAdmin();

        DB::table('psychologist_certificates')
            ->where('id', $id)
            ->update(['status' => 'approved', 'reject_reason' => null]);

        return back()->with('success', 'Sertifikat berhasil disetujui! Psikolog sekarang terverifikasi.');
    }

    // 3. Proses Reject
    public function reject(Request $request, $id)
    {
        $this->authorizeAdmin();

        $reason = $request->input('reason'); 

        if (!$reason) {
            $reason = 'Dokumen tidak memenuhi syarat verifikasi.';
        }

        // 3. Simpan ke Database
        DB::table('psychologist_certificates')
            ->where('id', $id)
            ->update([
                'status' => 'rejected',
                'reject_reason' => $reason
            ]);

        return back()->with('success', 'Sertifikat ditolak dengan alasan: ' . $reason);
    }

    // 4. Proses Cabut Verifikasi (Revoke)
    public function revoke($id)
    {
        $this->authorizeAdmin();

        DB::table('psychologist_certificates')
            ->where('id', $id)
            ->update([
                'status' => 'rejected',
                'reject_reason' => 'Verifikasi dicabut oleh Administrator.'
            ]);

        return back()->with('success', 'Verifikasi berhasil dicabut! Status sertifikat sekarang Ditolak.');
    }

    // 5. Hapus Data Verifikasi Permanen
    public function deleteVerification($id)
    {
        $this->authorizeAdmin();

        $cert = DB::table('psychologist_certificates')->where('id', $id)->first();
        if ($cert) {
            // Hapus file fisik dari public/uploads/certificates jika ada
            $filePath = public_path('uploads/certificates/' . $cert->certificate_path);
            if (\Illuminate\Support\Facades\File::exists($filePath)) {
                \Illuminate\Support\Facades\File::delete($filePath);
            }

            // Hapus dari DB
            DB::table('psychologist_certificates')->where('id', $id)->delete();

            return back()->with('success', 'Data verifikasi sertifikat berhasil dihapus secara permanen!');
        }

        return back()->with('error', 'Gagal menghapus! Data verifikasi tidak ditemukan.');
    }

    // --- FITUR KELOLA AKUN ---

    public function accounts(Request $request)
    {
        $this->authorizeAdmin();

        $search = $request->input('search');
        $roleFilter = $request->input('role');

        $query = User::query();

        // Filter Pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter Role Kategori
        if ($roleFilter && in_array(strtolower($roleFilter), ['psychologist', 'customer', 'admin'])) {
            $query->whereRaw('LOWER(role) = ?', [strtolower($roleFilter)]);
        }

        $users = $query->paginate(10)->withQueryString();

        return view('admin_accounts', compact('users', 'search', 'roleFilter'));
    }

    public function storeAccount(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'username' => 'required|min:3|max:255',
            'email'    => 'required|email|unique:account,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:Admin,Customer,Psychologist,CUSTOMER'
        ]);

        User::create([
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role'     => $validated['role']
        ]);

        return back()->with('success', 'Akun baru berhasil dibuat!');
    }

    public function updateAccount(Request $request, $id)
    {
        $this->authorizeAdmin();

        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|min:3|max:255',
            'email'    => 'required|email|unique:account,email,' . $id,
            'password' => 'nullable|min:6',
            'role'     => 'required|in:Admin,Customer,Psychologist,CUSTOMER'
        ]);

        $data = [
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'role'     => $validated['role']
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->update($data);

        return back()->with('success', 'Akun berhasil diperbarui!');
    }

    public function deleteAccount($id)
    {
        $this->authorizeAdmin();

        $user = User::findOrFail($id);
        
        // Cegah menghapus diri sendiri
        if ($user->id === auth()->user()->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();

        return back()->with('success', 'Akun berhasil dihapus!');
    }

    // --- FITUR KELOLA ARTIKEL / EDUKASI ---

    public function articles(Request $request)
    {
        $this->authorizeAdmin();

        $search = $request->input('search');

        $query = DB::table('articles');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin_articles', compact('articles', 'search'));
    }

    public function storeArticle(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'category'   => 'required|string|max:255',
            'image_url'  => 'nullable|string|max:2000',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'summary'    => 'required|string',
            'content'    => 'required|string',
        ]);

        $imageUrl = $validated['image_url'] ?? '';

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $file->getClientOriginalName());
            
            // Buat folder public/uploads/articles jika belum ada
            $destinationPath = public_path('uploads/articles');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $imageUrl = asset('uploads/articles/' . $filename);
        }

        if (empty($imageUrl)) {
            return back()->withErrors(['image_url' => 'Anda harus mengunggah file gambar atau memasukkan URL gambar.'])->withInput();
        }

        DB::table('articles')->insert([
            'title'      => $validated['title'],
            'category'   => $validated['category'],
            'image_url'  => $imageUrl,
            'summary'    => $validated['summary'],
            'content'    => $validated['content'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Artikel baru berhasil diterbitkan!');
    }

    public function updateArticle(Request $request, $id)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'category'   => 'required|string|max:255',
            'image_url'  => 'nullable|string|max:2000',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'summary'    => 'required|string',
            'content'    => 'required|string',
        ]);

        $currentArticle = DB::table('articles')->where('id', $id)->first();
        $imageUrl = $validated['image_url'] ?? ($currentArticle->image_url ?? '');

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $file->getClientOriginalName());
            
            $destinationPath = public_path('uploads/articles');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $imageUrl = asset('uploads/articles/' . $filename);
        }

        DB::table('articles')
            ->where('id', $id)
            ->update([
                'title'      => $validated['title'],
                'category'   => $validated['category'],
                'image_url'  => $imageUrl,
                'summary'    => $validated['summary'],
                'content'    => $validated['content'],
                'updated_at' => now(),
            ]);

        return back()->with('success', 'Artikel berhasil diperbarui!');
    }

    public function deleteArticle($id)
    {
        $this->authorizeAdmin();

        DB::table('articles')->where('id', $id)->delete();

        return back()->with('success', 'Artikel berhasil dihapus!');
    }
}