<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanAPIController extends Controller
{
    public function index()
    {
        $users = User::all();

        $absensi = DB::table('absensi')
            ->join('users', 'absensi.users_id', '=', 'users.id')
            ->select('absensi.*', 'users.name')
            ->latest()
            ->get();

        foreach ($absensi as $d) {
            $d->f_tanggal = Carbon::parse($d->waktu_masuk)->translatedFormat('l, d F Y');
            $d->f_waktu_masuk = Carbon::parse($d->waktu_masuk)->translatedFormat('H.i') . ' WIB';
            if ($d->waktu_keluar !== NULL) {
                $d->f_waktu_keluar = Carbon::parse($d->waktu_keluar)->translatedFormat('H.i') . ' WIB';
            } else {
                $d->f_waktu_keluar = $d->waktu_keluar;
            }
        }

        return response([
            'message' => 'absensi API',
            'data' => $absensi
        ], 200);
    }
}
