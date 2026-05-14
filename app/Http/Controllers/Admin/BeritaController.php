<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    // 🔥 LIST DATA BERITA
    public function index()
    {
        $berita = Berita::latest()->get();
        return view('admin.berita.index', compact('berita'));
    }

    // 🔥 FORM TAMBAH BERITA
    public function create()
    {
        return view('admin.berita.create');
    }

    // 🔥 SIMPAN BERITA
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'gambar' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $gambar = null;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'isi' => $request->isi,
            'gambar' => $gambar,

             'tanggal_upload' => now()
        ]);

        return redirect('/admin/berita')->with('success', 'Berita berhasil ditambahkan');
    }

    // 🔥 FORM EDIT
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita.edit', compact('berita'));
    }

    // 🔥 UPDATE BERITA
    public function update(Request $request, $id)
{
    $berita = Berita::findOrFail($id);

    $request->validate([
        'judul' => 'required',
        'isi' => 'required',
        'gambar' => 'image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $data = [
        'judul' => $request->judul,
        'slug' => Str::slug($request->judul),
        'isi' => $request->isi,
    ];

    // 🔥 kalau ada gambar baru
    if ($request->hasFile('gambar')) {
        $data['gambar'] = $request->file('gambar')->store('berita', 'public');
    }

    $berita->update($data);

    return redirect('/admin/berita')->with('success', 'Berita berhasil diupdate');
}

    // 🔥 HAPUS BERITA
    public function delete($id)
    {
        $berita = Berita::findOrFail($id);

        $berita->delete();

        return redirect('/admin/berita')->with('success', 'Berita berhasil dihapus');
    }
}
