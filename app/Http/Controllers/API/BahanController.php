<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BahanController extends Controller
{
    public function index(){
        $data = Bahan::get();
        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'data' => $data,
        ], 200);
    }

    public function store(Request $request){
        try {
            $databahan = new Bahan();
            $messages = [
                'nama.required' => 'Nama Bahan harus diisi.',
                'nama.min' => 'Nama bahan minimum 2 karakter',
                'nama.mix' => 'Nama bahan maximum 25 karakter',
                'satuan.required' => 'satuan bahan wajib isi',
                'jumlah.required' => 'jumlah bahan wajib isi',
            ];
            $rules = [
                'nama' => 'required|string|min:2|max:25',
                'satuan' => 'required|string|max:150|min:2',
                'jumlah' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules,$messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'prsoses tambah bahan gagal',
                    'data' => $validator->errors()
                ], 422);
            }

            $databahan->nama = $request->nama;
            $databahan->satuan = $request->satuan;
            $databahan->jumlah = $request->jumlah;
            $databahan->save();

            return response()->json([
                'status' => true,
                'message' => 'prsoses tambah bahan berhasil',
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'bahan sudah ada',
            ], 409);
        }
    }

    public function show($id)
    {
        //menampilkan data berdasarkan id
        $data = Bahan::find($id);
        if(empty($data)){
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Data dengan id: '.$id.' berhasil temukan',
            'data' => $data
        ], 200);
    }

    public function update($id, Request $request)
    {
        // Temukan data bahan berdasarkan ID
        $databahan = Bahan::find($id);

        if (empty($databahan)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        // Validasi input
        $messages = [
            'nama.required' => 'Nama Bahan harus diisi.',
            'nama.min' => 'Nama bahan minimum 2 karakter',
            'nama.mix' => 'Nama bahan maximum 25 karakter',
            'satuan.required' => 'satuan bahan wajib isi',
            'jumlah.required' => 'jumlah bahan wajib isi',
        ];
        $rules = [
            'nama' => 'required|string|min:2|max:25',
            'satuan' => 'required|string|max:150|min:2',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'jumlah' =>'required',
        ];

        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Proses ubah data bahan gagal',
                'data' => $validator->errors(),
                'request' => $request->all(),
            ], 400);
        }

        // Update data bahan hanya jika validasi berhasil
        $databahan->nama = $request->nama;
        $databahan->satuan = $request->satuan;
        $databahan->jumlah = $request->jumlah;
        $databahan->save();

        return response()->json([
            'status' => true,
            'message' => 'Proses ubah bahan berhasil',
        ], 200);
    }

    public function destroy($id){
        $databahan = Bahan::findOrFail($id);
        $databahan->delete();
        return response()->json([
            'status' => true,
            'message' => 'bahan berhasil dihapus',
        ], 200);
    }
}
