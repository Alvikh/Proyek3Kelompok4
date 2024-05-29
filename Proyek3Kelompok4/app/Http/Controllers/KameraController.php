<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamera;
use Illuminate\Validation\Rule;

class KameraController extends Controller
{
    public function index()
    {
        $kameras = Kamera::all();
        return view('kamera.index', compact('kameras'));
    }

    public function create()
    {
        return view('kamera.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_ruang' => 'required',
            'nama_kamera' => 'required',
            'sumber' => 'required',
            'status' => 'required|in:aktif,nonaktif',
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
            'nama_ruang' => 'required',
            'nama_kamera' => 'required',
            'sumber' => 'required',
            'status' => 'required|in:aktif,nonaktif',
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
