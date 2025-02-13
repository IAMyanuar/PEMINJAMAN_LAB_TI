<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class AlatController extends Controller
{
    public function index(){
        $data = Alat::get();
        for ($i = 0; $i < $data->count(); $i++) {
            $data[$i]['foto'] = url('assets/images/alat/' . $data[$i]['foto']);
        }
        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'data' => $data,
        ], 200);
    }

    public function store(Request $request){
        try {
            $dataalat = new Alat();
            $messages = [
                'nama.required' => 'Nama Alat harus diisi.',
                'nama.min' => 'Nama alat minimum 2 karakter',
                'nama.mix' => 'Nama alat maximum 25 karakter',
                'satuan.required' => 'satuan alat wajib isi',
                'jumlah.required' => 'jumlah alat wajib isi',
            ];
            $rules = [
                'nama' => 'required|string|min:2|max:25',
                'satuan' => 'required|string|max:150|min:2',
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif',
                'jumlah' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules,$messages);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'prsoses tambah alat gagal',
                    'data' => $validator->errors()
                ], 422);
            }

            $foto = $request->file('foto');
            $namafoto = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('assets/images/alat'), $namafoto);

            $dataalat->nama = $request->nama;
            $dataalat->satuan = $request->satuan;
            $dataalat->foto = $namafoto;
            $dataalat->jumlah = $request->jumlah;
            $dataalat->save();

            return response()->json([
                'status' => true,
                'message' => 'prsoses tambah alat berhasil',
            ], 201);

            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => 'alat sudah ada',
                ], 409);
            }
    }

    public function show($id)
    {
        //menampilkan data berdasarkan id
        $data = Alat::find($id);
        $data['foto'] = url('assets/images/alat/' . $data['foto']);

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
        // Temukan data alat berdasarkan ID
        $dataalat = Alat::find($id);

        if (empty($dataalat)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        // Validasi input
        $messages = [
            'nama.required' => 'Nama Alat harus diisi.',
            'nama.min' => 'Nama alat minimum 2 karakter',
            'nama.mix' => 'Nama alat maximum 25 karakter',
            'satuan.required' => 'satuan alat wajib isi',
            'jumlah.required' => 'jumlah alat wajib isi',
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
                'message' => 'Proses ubah data alat gagal',
                'data' => $validator->errors(),
                'request' => $request->all(),
            ], 400);
        }

        if ($request->hasFile('foto')) {
            // Hapus file gambar lama jika ada
            if (!empty($dataalat->foto)) {
                $oldPhotoPath = public_path('assets/images/alat/' . $dataalat->foto);
                if (File::exists($oldPhotoPath)) {
                    File::delete($oldPhotoPath);
                }
            }

            // Simpan gambar baru
            $foto = $request->file('foto');
            $namafoto = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('assets/images/alat'), $namafoto);
            $dataalat->foto = $namafoto;
        }

        // Update data alat hanya jika validasi berhasil
        $dataalat->nama = $request->nama;
        $dataalat->satuan = $request->satuan;
        $dataalat->jumlah = $request->jumlah;
        $dataalat->save();

        return response()->json([
            'status' => true,
            'message' => 'Proses ubah alat berhasil',
        ], 200);
    }

    public function destroy($id){
        $dataalat = Alat::findOrFail($id);
        $fotoalat = $dataalat->foto;

        if (!empty($fotoalat)) {
            $pathToFile = public_path('assets/images/alat/' . $fotoalat);
            if (File::exists($pathToFile)) {
                File::delete($pathToFile);
            }
        }
        $dataalat->delete();
        return response()->json([
            'status' => true,
            'message' => 'alat berhasil dihapus',
        ], 200);
    }
}
