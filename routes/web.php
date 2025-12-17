<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;

/* ================= ROOT ================ */
Route::redirect('/', '/login');

/* ================= AUTH ================ */
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class,'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class,'login'])->name('login.post');
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');

Route::get('/register', fn()=> view('auth.register'))->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class,'register'])->name('register.post');

/* ========== RESET PASSWORD ========== */

// tampilan form input email
Route::get('/reset-password', [ResetPasswordController::class,'showForm'])->name('reset_password');

// kirim email reset
Route::post('/reset-password', [ResetPasswordController::class,'process'])->name('reset_password.process');

// form atur password baru setelah klik link email
Route::get('/reset-password/{token}', [ResetPasswordController::class,'resetPage'])->name('password.reset');

// submit password baru → redirect ke login
Route::post('/reset-password/submit', [ResetPasswordController::class,'resetSubmit'])->name('password.update');

/* =============== HOME AUTO BY ROLE =============== */
Route::middleware(['auth'])->get('/home', function(){
    return match (Auth::user()->id_role) {
        1 => redirect('/admin/home'),
        2 => redirect('/user/home'),
        3 => redirect('/auditor/home'),
        default => abort(403,'Role tidak dikenali')
    };
})->name('home'); // 🔥 FIX WAJIB


/* ============================================================
   IMPORT ROUTE PEMISAH (WAJIB ADA)
   ============================================================ */

/* ============================================================
   ROUTE USER / ADMIN / AUDITOR (JANGAN DIBUNGKUS MIDDLEWARE)
   ============================================================ */

require __DIR__.'/user.php';
require __DIR__.'/admin.php';
require __DIR__.'/auditor.php';


