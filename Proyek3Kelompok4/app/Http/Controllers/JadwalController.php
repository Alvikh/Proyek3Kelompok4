<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use Illuminate\Validation\Rule;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::all();
        return view('jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $existingDays = Jadwal::pluck('nama_hari')->toArray();
        return view('jadwal.create', compact('existingDays'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_hari' => 'required',
            'status' => 'required|in:aktif,nonaktif',
            'waktu_masuk' => 'required',
            'waktu_keluar' => [
                'required',
                'after:waktu_masuk',
                function ($attribute, $value, $fail) use ($request) {
                    $masuk = strtotime($request->waktu_masuk);
                    $keluar = strtotime($value);
                    if ($keluar <= $masuk + 3600) {
                        $fail('Waktu pulang harus setelah waktu masuk dan minimal 1 jam setelah waktu masuk.');
                    }
                },
            ],
        ], [
            'waktu_keluar.after' => 'Waktu pulang harus setelah waktu masuk dan minimal 1 jam setelah waktu masuk.',
        ]);

        Jadwal::create($validatedData);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit(Jadwal $jadwal)
    {
        return view('jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:aktif,nonaktif',
            'waktu_masuk' => 'required',
            'waktu_keluar' => [
                'required',
                'after:waktu_masuk',
                function ($attribute, $value, $fail) use ($request) {
                    $masuk = strtotime($request->waktu_masuk);
                    $keluar = strtotime($value);
                    if ($keluar <= $masuk + 3600) {
                        $fail('Waktu pulang harus setelah waktu masuk dan minimal 1 jam setelah waktu masuk.');
                    }
                },
            ],
        ]);

        $jadwal->update($validatedData);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }
}
