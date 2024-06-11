<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruang;

class RuangController extends Controller
{
    public function index()
    {
        $ruangs = Ruang::all();
        return view('ruang.index', compact('ruangs'));
    }

    public function create()
    {
        return view('ruang.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_ruang' => 'required',
        ]);

        Ruang::create($validatedData);

        return redirect()->route('ruang.index')->with('success', 'Ruang berhasil ditambahkan');
    }

    public function edit(Ruang $kamera)
    {
        return view('ruang.edit', compact('ruang'));
    }

    public function update(Request $request, Ruang $ruang)
    {
        $validatedData = $request->validate([
            'nama_ruang' => 'required',
        ]);

        $ruang->update($validatedData);

        return redirect()->route('ruang.index')->with('success', 'Ruang berhasil diperbarui');
    }

    public function destroy(Ruang $ruang)
    {
        $ruang->delete();

        return redirect()->route('ruang.index')->with('success', 'Ruang berhasil dihapus');
    }
}
