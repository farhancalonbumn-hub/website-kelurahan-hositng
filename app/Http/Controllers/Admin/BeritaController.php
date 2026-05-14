<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    // 🔥 LIST BERITA
    public function index()
    {
        $berita = Berita::latest()->get();
        return view('admin.berita.index', compact('berita'));
    }

    // 🔥 FORM CREATE
    public function create()
    {
        return view('admin.berita.create');
    }

    // 🔥 STORE BERITA (AMAN RAILWAY)
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $gambarPath = null;

        // ✅ UPLOAD AMAN (public folder)
     if ($request->hasFile('gambar')) {

    $file = $request->file('gambar');

    $namaFile = time().'_'.$file->getClientOriginalName();

    // simpan ke storage/app/public/berita
    $path = $file->storeAs('berita', $namaFile, 'public');

    // path untuk ditampilkan
    $gambarPath = 'storage/'.$path;
}
        Berita::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'isi' => $request->isi,
            'gambar' => $gambarPath,
            'tanggal_upload' => now(),
        ]);

        return redirect('/admin/berita')->with('success', 'Berita berhasil ditambahkan');
    }

    // 🔥 EDIT FORM
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita.edit', compact('berita'));
    }

    // 🔥 UPDATE BERITA (AMAN)
    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = [
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'isi' => $request->isi,
        ];

        // ✅ kalau upload gambar baru
if ($request->hasFile('gambar')) {

    $file = $request->file('gambar');

    $namaFile = time().'_'.$file->getClientOriginalName();

    $path = $file->storeAs('berita', $namaFile, 'public');

    $data['gambar'] = 'storage/'.$path;
}

        $berita->update($data);

        return redirect('/admin/berita')->with('success', 'Berita berhasil diupdate');
    }

    // 🔥 DELETE
    public function delete($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();

        return redirect('/admin/berita')->with('success', 'Berita berhasil dihapus');
    }
}
