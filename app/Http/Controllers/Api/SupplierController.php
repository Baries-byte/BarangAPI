<?php

namespace App\Http\Controllers\Api;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierResource;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    // Menampilkan data supplier
    public function index()
    {
        // ambil data supplier
        $supplier = Supplier::latest()->paginate(5);

        // return collection supplier sebagai resource
        return new SupplierResource(true, 'List Data Supplier', $supplier);
    }

    // Simpan data supplier
    public function store(Request $request)
    {
        //validasi
        $validator = Validator::make($request->all(), [
            'nama_perusahaan' => ['required', 'unique:supplier,nama_perusahaan'],
            'alamat' => 'required',
            'telepon' => ['required', 'unique:supplier,telepon']
        ],
        [
            'nama_perusahaan.required' => 'Nama Perusahaan Harus Diisi!',
            'nama_perusahaan.unique' => 'Nama Perusahaan yang diisi telah tersedia.',
            'alamat.required' => 'Alamat Harus Diisi!',
            'telepon.required' => 'Telepon Harus Diisi!',
            'telepon.unique' => 'Telepon yang diisi telah tersedia.'
        ]);

        // cek validasi gagal
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        // create data supplier
        $supplier = Supplier::create([
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon
        ]);

        // return response
        return new SupplierResource(true, 'Data Supplier Berhasil Ditambah!', $supplier);
    }

    public function show(Supplier $supplier)
    {
        return new SupplierResource(true, 'Data Supplier Ditemukan!', $supplier);
    }

    public function update(Request $request, Supplier $supplier)
    {
        //validasi
        $validator = Validator::make($request->all(), [
            'nama_perusahaan' => ['required'],
            'alamat' => 'required',
            'telepon' => ['required']
        ],
        [
            'nama_perusahaan.required' => 'Nama Perusahaan Harus Diisi!',
            'alamat.required' => 'Alamat Harus Diisi!',
            'telepon.required' => 'Telepon Harus Diisi!',
        ]);

        // cek validasi gagal
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $supplier->update([
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon
        ]);

        return new SupplierResource(true, 'Data Supplier Berhasil Diubah!', $supplier);
    }

    public function destroy(Supplier $supplier) 
    {
        // delete supplier
        $supplier->delete();

        return new SupplierResource(true, 'Data Supplier Berhasil Dihapus!', null);
    }
}