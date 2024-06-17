<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamera;
use App\Models\Gedung;
use App\Models\Ruang;
use Illuminate\Validation\Rule;

class KameraController extends Controller
{
    public function index()
    {
        $kameras = Kamera::with(['gedung', 'ruang'])->get();
        $gedungs = Gedung::all();
        $ruangs = Ruang::all();

        return view('kamera.index', compact('kameras', 'gedungs', 'ruangs'));
    }

    public function create()
    {
        return view('kamera.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'gedung_id' => 'required|exists:gedung,id',
            'ruang_id' => 'required|exists:ruang,id',
            'nama_kamera' => 'required|string|max:255',
            'sumber' => 'required|string|max:255',
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        Kamera::create($validatedData);

        return redirect()->route('kamera.index')->with('success', 'Kamera berhasil ditambahkan');
    }

    public function edit(Kamera $kamera)
    {
        return view('kamera.edit', compact('kamera'));
    }

    public function update(Request $request, Kamera $kamera)
    {
        $validatedData = $request->validate([
            'gedung_id' => 'required|exists:gedung,id',
            'ruang_id' => 'required|exists:ruang,id',
            'nama_kamera' => 'required|string|max:255',
            'sumber' => 'required|string|max:255',
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        $kamera->update($validatedData);

        return redirect()->route('kamera.index')->with('success', 'Kamera berhasil diperbarui');
    }

    public function destroy(Kamera $kamera)
    {
        $kamera->delete();

        return redirect()->route('kamera.index')->with('success', 'Kamera berhasil dihapus');
    }
}
