<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\CRUDPenggunaController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KameraController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    //return view('welcome');
    return redirect()->to('/dashboard');
})->middleware('auth');

Route::post('/absensi-masuk', [AbsensiController::class, 'absensiMasuk']);

// Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');

// Register
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'store'])->name('auth.store');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');


Route::get('/aktivitas', function () {
    return view('aktivitas');
});

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

Route::get('/pengaturan', function () {
    return view('pengaturan');
});

// Route::get('/profile', function () {
//     return view('profile');
// });

use App\Http\Controllers\ProfileController;

// Route for displaying the profile edit form
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

// Route for handling the profile update
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');


Route::get('/webcam', function () {
    return view('webcam');
});

Route::get('/test', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function () {
    Route::middleware(['isAdmin'])->group(function () {
        Route::get('/models/{id}', [CRUDPenggunaController::class, 'index'])->name('models.index');
        Route::get('/models/{id}/create', [CRUDPenggunaController::class, 'create'])->name('models.create');
        Route::post('/models/store', [CRUDPenggunaController::class, 'store'])->name('models.store');
        Route::get('/models/edit/{models}', [CRUDPenggunaController::class, 'edit'])->name('models.edit');
        Route::put('/models/update/{models}', [CRUDPenggunaController::class, 'update'])->name('models.update');
        Route::delete('/models/delete/{models}', [CRUDPenggunaController::class, 'destroy'])->name('models.destroy');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/update/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/delete/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
        Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::get('/jadwal/edit/{jadwal}', [JadwalController::class, 'edit'])->name('jadwal.edit');
        Route::put('/jadwal/update/{jadwal}', [JadwalController::class, 'update'])->name('jadwal.update');
        Route::delete('/jadwal/delete/{jadwal}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

        Route::get('/kamera', [KameraController::class, 'index'])->name('kamera.index');
        Route::get('/kamera/create', [KameraController::class, 'create'])->name('kamera.create');
        Route::post('/kamera/store', [KameraController::class, 'store'])->name('kamera.store');
        Route::get('/kamera/edit/{kamera}', [KameraController::class, 'edit'])->name('kamera.edit');
        Route::put('/kamera/update/{kamera}', [KameraController::class, 'update'])->name('kamera.update');
        Route::delete('/kamera/delete/{kamera}', [KameraController::class, 'destroy'])->name('kamera.destroy');
    });

    Route::get('/dashboard', [AbsensiController::class, 'dashboard'])->name('dashboard');
});
