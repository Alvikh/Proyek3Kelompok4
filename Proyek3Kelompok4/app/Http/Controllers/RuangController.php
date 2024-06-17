<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruang;
use App\Models\Gedung;

class RuangController extends Controller
{
    public function index()
    {
        $ruangs = Ruang::with('gedung')->get();
        $gedungs = Gedung::all();
        return view('ruang.index', compact('ruangs', 'gedungs'));
    }

    public function create()
    {
        $gedungs = Gedung::all();
        return view('ruang.create', compact('gedungs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_ruang' => 'required',
            'gedung_id' => 'required|exists:gedung,id',
        ]);

        Ruang::create($validatedData);

        return redirect()->route('ruang.index')->with('success', 'Ruang berhasil ditambahkan');
    }

    public function edit(Ruang $ruang)
    {
        $gedungs = Gedung::all();
        return view('ruang.edit', compact('ruang', 'gedungs'));
    }

    public function update(Request $request, Ruang $ruang)
    {
        $validatedData = $request->validate([
            'nama_ruang' => 'required',
            'gedung_id' => 'required|exists:gedung,id',
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
