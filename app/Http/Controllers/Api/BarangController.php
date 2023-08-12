<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BarangResource;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    // Menampilkan data barang
    public function index()
    {
        // get barang
        $barang = Barang::with('kategori')->with('supplier')->latest()->paginate(5);

        return new BarangResource(true, 'List Data Barang', $barang);
    }

    // menyimpan data barang
    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'nama_barang' => ['required', 'unique:barang,nama_barang'],
            'kategori_id' => 'required',
            'supplier_id' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'deskripsi' => 'required'
        ]);

        // cek validasi gagal
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        // create barang
        $barang = Barang::create([
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'supplier_id' => $request->supplier_id,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'deskripsi' => $request->deskripsi
        ]);

        // return response
        return new BarangResource(true, 'Data Barang Berhasil Ditambah!', $barang);
    }

    public function show(Barang $barang)
    {
        $barang->load('kategori', 'supplier');
        return new BarangResource(true, 'Data Barang Ditemukan!', $barang);
    }

    public function update(Request $request, Barang $barang)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'nama_barang' => ['required'],
            'kategori_id' => 'required',
            'supplier_id' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'deskripsi' => 'required'
        ]);

        // cek validasi gagal
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        // update barang
        $barang->update([
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'supplier_id' => $request->supplier_id,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'deskripsi' => $request->deskripsi
        ]);

        // return response
        return new BarangResource(true, 'Data Barang Berhasil Diubah!', $barang);
    }

    public function destroy(Barang $barang) 
    {
        // delete barang
        $barang->delete();

        return new BarangResource(true, 'Data Barang Berhasil Dihapus!', null);
    }
}
