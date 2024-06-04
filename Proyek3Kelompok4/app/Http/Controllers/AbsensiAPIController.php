<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AbsensiAPIController extends Controller
{
    public function getAbsensiTerbaru()
    {
        $absensiMasuk = DB::table('absensi')
            ->join('users', 'absensi.users_id', '=', 'users.id')
            ->selectRaw('absensi.updated_at, absensi.id, users.name as nama_user, users.photo as profil_user, DATE_FORMAT(absensi.waktu_masuk, "%H:%i") as waktu_masuk, NULL as waktu_keluar')
            ->whereDate('absensi.waktu_masuk', DB::raw('CURDATE()'));

        $absensiKeluar = DB::table('absensi')
            ->join('users', 'absensi.users_id', '=', 'users.id')
            ->selectRaw('absensi.updated_at, absensi.id, users.name as nama_user, users.photo as profil_user, NULL as waktu_masuk, DATE_FORMAT(absensi.waktu_keluar, "%H:%i") as waktu_keluar')
            ->whereDate('absensi.waktu_keluar', DB::raw('CURDATE()'));

        $absensi = $absensiKeluar->unionAll($absensiMasuk)
            ->orderByDesc('updated_at')
            ->get();

        return response()->json($absensi);
    }

    public function getDataPegawaiTerbaru()
    {
        $jumlahPegawai = User::where('role', '!=', 'admin')->count();
        $jumlahPegawaiMasukHariIni = Absensi::whereDate('waktu_masuk', '=', Carbon::today())->count();

        return response()->json([
            'jumlahPegawai' => $jumlahPegawai,
            'jumlahPegawaiMasukHariIni' => $jumlahPegawaiMasukHariIni
        ]);
    }

}
