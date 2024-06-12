<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Kamera;
use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    function dashboard()
    {
        $users = User::where('role', '!=', 'admin')->get();
        $jumlahPegawai = User::where('role', '!=', 'admin')->count();
        $jumlahPegawaiMasukHariIni = Absensi::whereDate('waktu_masuk', '=', Carbon::today())->count();
        $jadwal = Jadwal::where('nama_hari', Carbon::now()->locale('id')->dayName)->first();

        $labels = [];

        foreach ($users as $user) {
            $path = public_path('assets/img/labeled_images/' . $user->name);
            if (File::isDirectory($path) && count(File::files($path)) > 0) {
                $labels[] = $user->name;
            }
        }

        $kamera = Kamera::where('status', '!=', 'nonaktif')->get();

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

        return view('dashboard', compact('jumlahPegawai', 'jumlahPegawaiMasukHariIni', 'jadwal', 'labels', 'absensi', 'kamera'));
    }

    function riwayat(){
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

            return view('riwayat', compact('absensi'));
    }

    private function ambilJadwal()
    {
        $hariIni = Carbon::now()->locale('id')->dayName;
        return DB::table('jadwal')->where('nama_hari', $hariIni)->first();
    }

    function absensiMasuk(Request $request)
    {
        $request->validate([
            'nama_person' => 'required',
        ]);

        $nama_person = $request->nama_person;
        $data = User::where('name', $nama_person)->firstOrFail();
        $userId = $data->id;

        $jadwalHariIni = $this->ambilJadwal();
        $waktuSekarang = Carbon::now()->format('H:i:s');

        if (!$jadwalHariIni) {
            return response()->json(['error' => 'Jadwal tidak ditemukan untuk hari ini'], 404);
        }

        // Periksa apakah waktu sekarang sesuai untuk absensi masuk atau keluar
        if ($waktuSekarang >= $jadwalHariIni->waktu_masuk) {
            $absenHariIni = Absensi::where('users_id', $userId)
                ->whereDate('waktu_masuk', Carbon::today())
                ->first();

            if (!$absenHariIni && $waktuSekarang >= $jadwalHariIni->waktu_masuk) {
                // Absensi Masuk
                Absensi::create([
                    'users_id' => $userId,
                    'waktu_masuk' => now()
                ]);

                return response()->json(['success' => $data->name . ' - ' . 'Absensi masuk'], 200);
            } elseif ($absenHariIni && !$absenHariIni->waktu_keluar && $waktuSekarang >= $jadwalHariIni->waktu_keluar) {
                // Absensi Keluar
                $absenHariIni->update([
                    'waktu_keluar' => now()
                ]);

                return response()->json(['success' => $data->name . ' - ' . 'Absensi keluar'], 200);
            } else {
                return response()->json(['message' => $data->name . ' - ' . 'Sudah melakukan absensi atau belum waktunya absensi keluar'], 200);
            }
        } else {
            return response()->json(['error' => 'Tidak sesuai dengan waktu absensi'], 400);
        }
    }
    
}
