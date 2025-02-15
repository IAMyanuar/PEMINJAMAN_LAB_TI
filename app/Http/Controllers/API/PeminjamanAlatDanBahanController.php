<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Bahan;
use App\Models\PeminjamanAlat;
use App\Models\PeminjamanAlatDanBahan;
use App\Models\PeminjamanBahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeminjamanAlatDanBahanController extends Controller
{
    public function index(){
        $data_pnj_alatbahan = PeminjamanAlatDanBahan::with(['user','peminjamanalat.alat','peminjamanbahan.bahan'])
        ->where('status','=','terkirim')
        ->get();
        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'data' => $data_pnj_alatbahan,
        ], 200);
    }

    public function proses(){
        $data_pnj_alatbahan = PeminjamanAlatDanBahan::with(['user','peminjamanalat.alat','peminjamanbahan.bahan'])
        ->where('status','=','di prosess')
        ->get();
        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'data' => $data_pnj_alatbahan,
        ], 200);
    }

    public function detail($id){
        $data_pnj_alatbahan = PeminjamanAlatDanBahan::with(['user','peminjamanalat.alat','peminjamanbahan.bahan'])
        ->find($id);
        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'data' => $data_pnj_alatbahan,
        ], 200);
    }

    public function ubahstatus(Request $request, $id){
        $data_pnj_alatbahan = PeminjamanAlatDanBahan::find($id);

        $rules = [
            'status' => 'required',
        ];

        if(empty($data_pnj_alatbahan)){
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Proses ubah status peminjaman gagal',
                'data' => $validator->errors(),
                'request' => $request->all(),
            ], 400);
        }

        if ($request->status == 'di prosess') {
            $PmjAlat = PeminjamanAlat::where('id_peminjaman_alat_bahan',$id)->get();
            foreach($PmjAlat as $peminjaman_alat){
                $id_alat = $peminjaman_alat->id_alat;
                $jumlah_alat_dipinjam  = $peminjaman_alat->jumlah;

                $alat = Alat::find($id_alat);
                $alat->jumlah -= $jumlah_alat_dipinjam;
                $alat->save();
            }

            $PmjBahan = PeminjamanBahan::where('id_peminjaman_alat_bahan',$id)->get();
            foreach ($PmjBahan as $peminjaman_bahan) {
                $id_bahan = $peminjaman_bahan->id_bahan;
                $jumlah_bahan_dipinjam  = $peminjaman_bahan->jumlah;

                $bahan = Bahan::find($id_bahan);
                $bahan->jumlah -= $jumlah_bahan_dipinjam;
                $bahan->save();
            }
        }

        if ($request->status == 'selesai') {
            $PmjAlat = PeminjamanAlat::where('id_peminjaman_alat_bahan',$id)->get();
            foreach($PmjAlat as $peminjaman_alat){
                $id_alat = $peminjaman_alat->id_alat;
                $jumlah_alat_dipinjam  = $peminjaman_alat->jumlah;

                $alat = Alat::find($id_alat);
                $alat->jumlah += $jumlah_alat_dipinjam;
                $alat->save();
            }

            $PmjBahan = PeminjamanBahan::where('id_peminjaman_alat_bahan',$id)->get();
            foreach ($PmjBahan as $peminjaman_bahan) {
                $id_bahan = $peminjaman_bahan->id_bahan;
                $jumlah_bahan_dipinjam  = $peminjaman_bahan->jumlah;

                $bahan = Bahan::find($id_bahan);
                $bahan->jumlah += $jumlah_bahan_dipinjam;
                $bahan->save();
            }
        }

        $data_pnj_alatbahan->status = $request->status;
        $data_pnj_alatbahan->save();

        return response()->json([
            'status' => 'true',
            'message' => 'Proses ubah ststus peminjaman alat dan bahan berhasil',
        ], 201);

    }

    public function riwayatPmjAlatBahan(){
        $data_pnj_alatbahan = PeminjamanAlatDanBahan::with(['user','peminjamanalat.alat','peminjamanbahan.bahan'])
        ->where('status','=','selesai')
        ->orWhere('status','=','ditolak')
        ->get();
        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'data' => $data_pnj_alatbahan,
        ], 200);
    }

    public function PmjAlatBahanByIdUser($id){
        $data_pnj_alatbahan = PeminjamanAlatDanBahan::with(['user','peminjamanalat.alat','peminjamanbahan.bahan'])->find($id);
        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'data' => $data_pnj_alatbahan,
        ], 200);
    }
}
