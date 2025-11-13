<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\JadwalPeriksaController;
use App\Http\Controllers\Pasien\PoliController as PasienPoliController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    // Tampilkan form login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
    // Proses login
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    // Tampilkan form register
    Route::get('/register', [AuthController::class, 'showRegister']);
    // Proses registrasi
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function() {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::resource('polis', PoliController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('obat', ObatController::class);
    Route::resource('jadwal-periksa', JadwalPeriksaController::class);
});

Route::middleware(['auth', 'role:admin|dokter'])->prefix('dokter')->group(function() {
    Route::get('/dashboard', [DokterController::class, 'index'])->name('dokter.dashboard');
    Route::get('/jadwal', [JadwalPeriksaController::class, 'index'])->name('jadwal.index');
    // Tambahkan resource di sini agar dokter juga bisa CRUD
    Route::resource('dokter', DokterController::class);
    Route::resource('jadwal-periksa', JadwalPeriksaController::class);
});

Route::middleware(['auth', 'role:admin|pasien'])->prefix('pasien')->group(function(){
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');
    Route::get('/daftar', [PasienPoliController::class,'get'])->name('pasien.daftar.index');
    Route::post('/daftar', [PasienPoliController::class,'submit'])->name('pasien.daftar.submit');
});
