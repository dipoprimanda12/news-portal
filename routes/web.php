<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPostController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Rute Publik (Tanpa Login)
|--------------------------------------------------------------------------
*/

// Halaman utama - daftar berita terbaru
Route::get('/', [PublicPostController::class, 'index'])->name('home');

// Detail berita berdasarkan slug
Route::get('/berita/{slug}', [PublicPostController::class, 'show'])->name('posts.show');

// Filter berita berdasarkan kategori
Route::get('/kategori/{slug}', [PublicPostController::class, 'byCategory'])->name('posts.byCategory');

// Pencarian berita
Route::get('/cari', [PublicPostController::class, 'search'])->name('posts.search');

// Kirim komentar (hanya untuk user login)
Route::post('/berita/{post}/komentar', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('comments.store');

/*
|--------------------------------------------------------------------------
| Rute Admin (Khusus User Login & Verifikasi Email)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // CRUD berita oleh admin
    Route::resource('/admin/posts', AdminPostController::class)->except('show');

    // Profil user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Debug & Auth Routes
|--------------------------------------------------------------------------
*/

// Debug: melihat semua post dan relasinya (non-produktif)
Route::get('/debug/posts', function () {
    return \App\Models\Post::with('category', 'user')->get();
});

// Rute auth Laravel Breeze/Fortify
require __DIR__.'/auth.php';
