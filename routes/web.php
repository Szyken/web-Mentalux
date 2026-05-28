<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PsychologistController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. HALAMAN PUBLIK (Bisa diakses siapa aja)
// ==========================================

// Home Page
Route::view('/', 'index')->name('home');

// About Us
Route::view('/about', 'about')->name('about');

// Education
Route::get('/education', function() {
    $articles = \Illuminate\Support\Facades\DB::table('articles')->latest()->get();
    return view('education', compact('articles'));
})->name('education');

// List Psikolog (PENTING: Ini pake Controller biar Database & Search jalan)
Route::get('/psychologist', [PsychologistController::class, 'index'])->name('psychologist.index');

// Detail Artikel
Route::get('/article', function (\Illuminate\Http\Request $request) {
    $id = $request->query('id', 1);
    $data = \Illuminate\Support\Facades\DB::table('articles')->where('id', $id)->first();
    if (!$data) {
        $data = \Illuminate\Support\Facades\DB::table('articles')->first();
    }
    return view('article_detail', compact('data'));
})->name('article.detail');


// ==========================================
// 2. HALAMAN OTENTIKASI (Login/Register)
// ==========================================

// Login
Route::view('/login', 'login')->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Sign Up (Pake RegisterController sesuai baris bawah file lu tadi)
Route::get('/signup', [RegisterController::class, 'index'])->name('signup');
Route::post('/signup', [RegisterController::class, 'store'])->name('signup.store');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Lupa Password
Route::view('/forgot-password', 'forgotpass')->name('password.request');


// ==========================================
// 3. HALAMAN DASHBOARD & PRIVATE (Wajib Login)
// ==========================================

Route::middleware(['auth'])->group(function () {
    
    // --- DASHBOARD ---
    // Dashboard Customer (Pake DashboardController)
    Route::get('/dashboard/customer', [DashboardController::class, 'customer'])->name('dashboard.customer');

    // Dashboard Admin (Pake AdminController - Biar angkanya Real Time)
    Route::get('/dashboard/admin', [AdminController::class, 'index'])->name('dashboard.admin');

    // Dashboard Psikolog (Pake DashboardController)
    Route::get('/dashboard/psychologist', [DashboardController::class, 'psychologist'])->name('dashboard.psychologist');

    // --- FITUR PSIKOLOG (UPLOAD SERTIFIKAT) ---
    // (Digabung disini biar aman harus login dulu)
    Route::get('/dashboard/psychologist/upload', [PsychologistController::class, 'showUploadForm'])->name('psychologist.upload');
    Route::post('/dashboard/psychologist/upload', [PsychologistController::class, 'handleUpload'])->name('psychologist.upload.post');
    Route::delete('/dashboard/psychologist/upload/delete', [PsychologistController::class, 'deleteCertificate'])->name('psychologist.upload.delete');

    // --- BOOKING SYSTEM ---
    // Route ini yang bikin error "Route not defined" kalau ga dikasih nama
    Route::get('/booking/{psikolog}', [BookingController::class, 'show'])->name('booking.show'); 
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

    // --- PAYMENT ---
    Route::get('/payment', [BookingController::class, 'payment']); // Pastikan method payment ada di Controller

    // --- CHAT (REAL-TIME 2 ARAH) ---
    // Route lama: buat konsultasi baru lalu redirect ke chat room
    Route::get('/chat', [BookingController::class, 'chat'])->name('chat');

    // Chat Room (Pasien & Psikolog masuk ke room yang sama)
    Route::get('/chat/room/{consultation}', [ChatController::class, 'show'])->name('chat.room');

    // API Chat (untuk AJAX polling)
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/messages/{consultation}', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::get('/chat/unread-count', [ChatController::class, 'getUnreadCount'])->name('chat.unread');

    // Akhiri sesi konsultasi
    Route::post('/chat/end/{consultation}', [ChatController::class, 'endSession'])->name('chat.end');

    // Halaman List Verifikasi
    Route::get('/dashboard/admin/verifications', [AdminController::class, 'verifications'])->name('admin.verifications');

    // Action Tombol
    Route::post('/dashboard/admin/verifications/{id}/approve', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/dashboard/admin/verifications/{id}/reject', [AdminController::class, 'reject'])->name('admin.reject');

    // Kelola Akun Admin
    Route::get('/dashboard/admin/accounts', [AdminController::class, 'accounts'])->name('admin.accounts');
    Route::post('/dashboard/admin/accounts', [AdminController::class, 'storeAccount'])->name('admin.accounts.store');
    Route::put('/dashboard/admin/accounts/{id}', [AdminController::class, 'updateAccount'])->name('admin.accounts.update');
    Route::delete('/dashboard/admin/accounts/{id}', [AdminController::class, 'deleteAccount'])->name('admin.accounts.delete');

    // Kelola Artikel/Edukasi Admin
    Route::get('/dashboard/admin/articles', [AdminController::class, 'articles'])->name('admin.articles');
    Route::post('/dashboard/admin/articles', [AdminController::class, 'storeArticle'])->name('admin.articles.store');
    Route::put('/dashboard/admin/articles/{id}', [AdminController::class, 'updateArticle'])->name('admin.articles.update');
    Route::delete('/dashboard/admin/articles/{id}', [AdminController::class, 'deleteArticle'])->name('admin.articles.delete');

    // Update Profil Customer
    Route::put('/dashboard/customer/profile', [DashboardController::class, 'updateProfile'])->name('customer.profile.update');

    // Kelola Permintaan Akhiri Sesi Chat
    Route::post('/chat/request-end/{consultation}', [ChatController::class, 'requestEndSession'])->name('chat.request.end');
    Route::post('/chat/reject-end/{consultation}', [ChatController::class, 'rejectEndSession'])->name('chat.reject.end');
});