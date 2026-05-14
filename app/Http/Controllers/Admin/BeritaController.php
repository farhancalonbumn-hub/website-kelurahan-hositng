<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Str;

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

    // folder tujuan
    $tujuan = public_path('berita');

    // buat folder jika belum ada
    if (!file_exists($tujuan)) {
        mkdir($tujuan, 0777, true);
    }
dd(
    $request->hasFile('gambar'),
    $file,
    $tujuan
);
    // upload file
    $file->move($tujuan, $namaFile);

    $gambarPath = 'berita/'.$namaFile;
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

            $file->move(public_path('berita'), $namaFile);

            $data['gambar'] = 'berita/'.$namaFile;
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
