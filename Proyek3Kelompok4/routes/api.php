<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanAPIController;
use App\Http\Controllers\AbsensiController;
use App\Models\Ruang;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/laporan2', [LaporanAPIController::class, 'index'])->name('laporan2.index');

Route::get('/get-ruang/{gedungId}', [AbsensiController::class, 'getRuang']);
Route::get('/get-kamera/{ruangId}', [AbsensiController::class, 'getKamera']);
Route::get('/get-ruangs/{gedungId}', function ($gedungId) {
    $ruangs = Ruang::where('gedung_id', $gedungId)->get(['id', 'nama_ruang']);
    return response()->json($ruangs);
});