<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gedung;

class GedungController extends Controller
{
    public function index()
    {
        $gedungs = Gedung::all();
        return view('gedung.index', compact('gedungs'));
    }

    public function create()
    {
        return view('gedung.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_gedung' => 'required',
        ]);

        Gedung::create($validatedData);

        return redirect()->route('gedung.index')->with('success', 'Gedung berhasil ditambahkan');
    }

    public function edit(Gedung $kamera)
    {
        return view('gedung.edit', compact('gedung'));
    }

    public function update(Request $request, Gedung $gedung)
    {
        $validatedData = $request->validate([
            'nama_gedung' => 'required',
        ]);

        $gedung->update($validatedData);

        return redirect()->route('gedung.index')->with('success', 'Gedung berhasil diperbarui');
    }

    public function destroy(Gedung $gedung)
    {
        $gedung->delete();

        return redirect()->route('gedung.index')->with('success', 'Gedung berhasil dihapus');
    }
}
