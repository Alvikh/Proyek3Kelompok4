<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();

        $query = DB::table('absensi')
            ->join('users', 'absensi.users_id', '=', 'users.id')
            ->select('absensi.*', 'users.name')
            ->latest();

        if ($request->has('tahun') && $request->has('bulan')) {
            $tahun = $request->input('tahun');
            $bulan = $request->input('bulan');
            $query->whereYear('waktu_masuk', $tahun)
                ->whereMonth('waktu_masuk', $bulan);
        }

        $laporan = $query->paginate(10);

        foreach ($laporan as $d) {
            $d->f_tanggal = Carbon::parse($d->waktu_masuk)->translatedFormat('l, d F Y');
            $d->f_waktu_masuk = Carbon::parse($d->waktu_masuk)->translatedFormat('H.i') . ' WIB';
            if ($d->waktu_keluar !== NULL) {
                $d->f_waktu_keluar = Carbon::parse($d->waktu_keluar)->translatedFormat('H.i') . ' WIB';
            } else {
                $d->f_waktu_keluar = $d->waktu_keluar;
            }
        }

        return view('laporan', compact('laporan'));
    }
}
