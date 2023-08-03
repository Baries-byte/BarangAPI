<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\KategoriResource;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    // Menampilkan data kategori
    public function index()
    {
        // get kategori kategori
        $kategori = Kategori::latest()->paginate(5);

        // return collection kategori as a resource
        return new KategoriResource(true, 'List Data Kategori', $kategori);
    }

    // Menyimpan data kategori
    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'kategori' => ['required', 'unique:kategori,kategori']
        ], 
        [
            'kategori.required' => 'Kategori Harus Diisi!',
            'kategori.unique' => 'Kategori yang diisi telah tersedia.'
        ]);

        // cek validasi gagal
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        // validasi ini bisa dipakai tapi blm nemu cara buat nampilin error jsonnya.
        // kalau baca sih auto nampilin
        // $request->validate([
        //     'kategori' => 'required'
        // ]);

        // create data kategori
        $kategori = Kategori::create([
            'kategori' => $request->kategori
        ]);

        // return response
        return new KategoriResource(true, 'Data Kategori Berhasil Ditambah!', $kategori);
    }

    public function show(Kategori $kategori)
    {
        // return single kategori as a resource
        return new KategoriResource(true, 'Data Kategori Ditemukan!', $kategori);
    }

    public function update(Request $request, Kategori $kategori)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'kategori' => ['required', 'unique:kategori,kategori']
        ],
        [
            'kategori.required' => 'Kategori Harus Diisi!',
            'kategori.unique' => 'Kategori yang diisi telah tersedia.'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $kategori->update([
            'kategori' => $request->kategori
        ]);

        return new KategoriResource(true, 'Data Kategori Berhasil Diubah!', $kategori);
    }

    public function destroy(Kategori $kategori)
    {
        // delete kategori
        $kategori->delete();

        return new KategoriResource(true, 'Data Kategori Berhasil Dihapus!', null);
    }
}
