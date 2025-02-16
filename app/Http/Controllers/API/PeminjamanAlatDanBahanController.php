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
    public function index()
    {
        $data_pnj_alatbahan = PeminjamanAlatDanBahan::with(['user', 'peminjamanalat.alat', 'peminjamanbahan.bahan'])
            ->where('status', '=', 'terkirim')
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'data' => $data_pnj_alatbahan,
        ], 200);
    }

    public function proses()
    {
        $data_pnj_alatbahan = PeminjamanAlatDanBahan::with(['user', 'peminjamanalat.alat', 'peminjamanbahan.bahan'])
            ->where('status', '=', 'di prosess')
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'data' => $data_pnj_alatbahan,
        ], 200);
    }

    public function detail($id)
    {
        $data_pnj_alatbahan = PeminjamanAlatDanBahan::with(['user', 'peminjamanalat.alat', 'peminjamanbahan.bahan'])
            ->find($id);
        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'data' => $data_pnj_alatbahan,
        ], 200);
    }

    public function ubahstatus(Request $request, $id)
    {
        $data_pnj_alatbahan = PeminjamanAlatDanBahan::find($id);

        $rules = [
            'status' => 'required',
        ];

        if (empty($data_pnj_alatbahan)) {
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
            $PmjAlat = PeminjamanAlat::where('id_peminjaman_alat_bahan', $id)->get();
            foreach ($PmjAlat as $peminjaman_alat) {
                $id_alat = $peminjaman_alat->id_alat;
                $jumlah_alat_dipinjam  = $peminjaman_alat->jumlah;

                $alat = Alat::find($id_alat);
                $alat->jumlah -= $jumlah_alat_dipinjam;
                $alat->save();
            }

            $PmjBahan = PeminjamanBahan::where('id_peminjaman_alat_bahan', $id)->get();
            foreach ($PmjBahan as $peminjaman_bahan) {
                $id_bahan = $peminjaman_bahan->id_bahan;
                $jumlah_bahan_dipinjam  = $peminjaman_bahan->jumlah;

                $bahan = Bahan::find($id_bahan);
                $bahan->jumlah -= $jumlah_bahan_dipinjam;
                $bahan->save();
            }
        }

        if ($request->status == 'selesai') {
            $PmjAlat = PeminjamanAlat::where('id_peminjaman_alat_bahan', $id)->get();
            foreach ($PmjAlat as $peminjaman_alat) {
                $id_alat = $peminjaman_alat->id_alat;
                $jumlah_alat_dipinjam  = $peminjaman_alat->jumlah;

                $alat = Alat::find($id_alat);
                $alat->jumlah += $jumlah_alat_dipinjam;
                $alat->save();
            }

            $PmjBahan = PeminjamanBahan::where('id_peminjaman_alat_bahan', $id)->get();
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


    public function store(Request $request)
    {
        $rules = [
            'kelas' => 'required',
            'pic' => 'required',
            'tgl_pinjam' => 'required',
            'tgl_selesai' => 'required|after_or_equal:tgl_pinjam',
            'alat' => 'nullable',
            'alat.*' => 'nullable',
            'jumlah_alat' => 'nullable',
            'jumlah_alat.*' => 'nullable',
            'bahan' => 'nullable',
            'bahan.*' => 'nullable',
            'jumlah_bahan' => 'nullable',
            'jumlah_bahan.* ' => 'nullable',
            'user_id' => 'required',

        ];

        //validasi data yang di insert
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'prsoses ajukan peminjaman gagal',
                'data' => $validator->errors()
            ], 422);
        }

        $tgl_pinjam = $request->tgl_pinjam;
        $tgl_selesai = $request->tgl_selesai;
        if ($tgl_pinjam > $tgl_selesai) {
            return response()->json([
                'status' => false,
                'message' => 'prsoses ajukan peminjaman gagal karena waktu yang tidak valid',
            ], 400);
        }

        $dataPmjAlatBahan = new PeminjamanAlatDanBahan;
        $dataPmjAlatBahan->kelas = $request->kelas;
        $dataPmjAlatBahan->pic = $request->pic;
        $dataPmjAlatBahan->tgl_pinjam = $tgl_pinjam;
        $dataPmjAlatBahan->tgl_selesai = $tgl_selesai;
        $dataPmjAlatBahan->user_id = $request->user_id;
        $dataPmjAlatBahan->save();

        $id_alat_array = explode(',', $request->alat);
        $jumlah_alat_array = explode(',', $request->jumlah_alat);
        $id_bahan_array = explode('"', $request->bahan);
        $jumlah_bahan_array = explode('"', $request->jumlah_bahan);

        $errorMessages = [];
        $jmlAlatKurang = false;
        $jmlBahanKurang = false;

        // Validasi alat
        foreach ($id_alat_array as $key => $alatId) {
            if (!empty($alatId)) {
                $jumlahDiminta = $jumlah_alat_array[$key] ?? 0;
                $alat = Alat::find($alatId);

                if (!$alat) {
                    $errorMessages[] = "Alat dengan ID {$alatId} tidak ditemukan.";
                    $jmlAlatKurang = true;
                    continue;
                }

                if ($jumlahDiminta > $alat->jumlah) {
                    $errorMessages[] = "Jumlah Alat '{$alat->nama}' tidak mencukupi.";
                    $jmlAlatKurang = true;
                }
            }
        }

        // Jika jumlah alat mencukupi, simpan data peminjaman alat
        if (!$jmlAlatKurang) {
            foreach ($id_alat_array as $key => $alatId) {
                if (!empty($alatId)) {
                    $jumlahDiminta = $jumlah_alat_array[$key] ?? 0;
                    $detailPeminjamanAlat = new PeminjamanAlat;
                    $detailPeminjamanAlat->id_peminjaman_alat_bahan = $dataPmjAlatBahan->id;
                    $detailPeminjamanAlat->id_alat = $alatId;
                    $detailPeminjamanAlat->jumlah = $jumlahDiminta;
                    $detailPeminjamanAlat->save();
                }
            }
        }

        // Validasi bahan
        foreach ($id_bahan_array as $key => $bahanId) {
            if (!empty($bahanId)) {
                $jumlahDiminta = $jumlah_bahan_array[$key] ?? 0;
                $bahan = Bahan::find($bahanId);

                if (!$bahan) {
                    $errorMessages[] = "Bahan dengan ID {$bahanId} tidak ditemukan.";
                    $jmlBahanKurang = true;
                    continue;
                }

                if ($jumlahDiminta > $bahan->jumlah) {
                    $errorMessages[] = "Jumlah Bahan '{$bahan->nama}' tidak mencukupi.";
                    $jmlBahanKurang = true;
                }
            }
        }

        // Jika jumlah bahan mencukupi, simpan data peminjaman bahan
        if (!$jmlBahanKurang) {
            foreach ($id_bahan_array as $key => $bahanId) {
                if (!empty($bahanId)) {
                    $jumlahDiminta = $jumlah_bahan_array[$key] ?? 0;
                    $detailPeminjamanBahan = new PeminjamanBahan;
                    $detailPeminjamanBahan->id_peminjaman_alat_bahan = $dataPmjAlatBahan->id; // Sesuaikan dengan ID peminjaman alat dan bahan
                    $detailPeminjamanBahan->id_bahan = $bahanId;
                    $detailPeminjamanBahan->jumlah = $jumlahDiminta;
                    $detailPeminjamanBahan->save();
                }
            }
        }

        $errorString = implode("\n", $errorMessages);
        if (!empty($errorMessages)) {
            return response()->json([
                'status' => false,
                'message' => $errorString,
                'errors' => $errorMessages
            ], 422);
        }
        return response()->json([
            'status' => true,
            'message' => 'prsoses ajukan peminjaman ruangan berhasil',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'kelas' => 'required',
            'pic' => 'required',
            'tgl_pinjam' => 'required',
            'tgl_selesai' => 'required|after_or_equal:tgl_pinjam',
            'alat' => 'nullable|string', // Harus string jika akan di-explode
            'jumlah_alat' => 'nullable|string',
            'bahan' => 'nullable|string',
            'jumlah_bahan' => 'nullable|string',
            'user_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Proses update peminjaman gagal',
                'data' => $validator->errors()
            ], 422);
        }

        $peminjaman = PeminjamanAlatDanBahan::find($id);
        if (!$peminjaman) {
            return response()->json([
                'status' => false,
                'message' => 'Data peminjaman tidak ditemukan',
            ], 404);
        }

        // Update data peminjaman
        $peminjaman->kelas = $request->kelas;
        $peminjaman->pic = $request->pic;
        $peminjaman->tgl_pinjam = $request->tgl_pinjam;
        $peminjaman->tgl_selesai = $request->tgl_selesai;
        $peminjaman->user_id = $request->user_id;
        $peminjaman->save();

        $errorMessages = [];
        $jmlAlatKurang = false;
        $jmlBahanKurang = false;

        // Menghapus data lama peminjaman alat dan bahan sebelum diperbarui
        PeminjamanAlat::where('id_peminjaman_alat_bahan', $id)->delete();
        PeminjamanBahan::where('id_peminjaman_alat_bahan', $id)->delete();

        // Gunakan explode jika data dikirim dalam bentuk string
        $id_alat_array = explode(',', $request->alat);
        $jumlah_alat_array = explode(',', $request->jumlah_alat);
        $id_bahan_array = explode(',', $request->bahan);
        $jumlah_bahan_array = explode(',', $request->jumlah_bahan);

        // Validasi alat
        foreach ($id_alat_array as $key => $alatId) {
            if (!empty($alatId)) {
                $jumlahDiminta = $jumlah_alat_array[$key] ?? 0;
                $alat = Alat::find($alatId);

                if (!$alat) {
                    $errorMessages[] = "Alat dengan ID {$alatId} tidak ditemukan.";
                    $jmlAlatKurang = true;
                    continue;
                }

                if ($jumlahDiminta > $alat->jumlah) {
                    $errorMessages[] = "Jumlah alat '{$alat->nama}' tidak mencukupi.";
                    $jmlAlatKurang = true;
                }
            }
        }

        // Simpan data peminjaman alat jika jumlah cukup
        if (!$jmlAlatKurang) {
            foreach ($id_alat_array as $key => $alatId) {
                if (!empty($alatId)) {
                    $jumlahDiminta = $jumlah_alat_array[$key] ?? 0;
                    PeminjamanAlat::create([
                        'id_peminjaman_alat_bahan' => $peminjaman->id,
                        'id_alat' => $alatId,
                        'jumlah' => $jumlahDiminta
                    ]);
                }
            }
        }

        // Validasi bahan
        foreach ($id_bahan_array as $key => $bahanId) {
            if (!empty($bahanId)) {
                $jumlahDiminta = $jumlah_bahan_array[$key] ?? 0;
                $bahan = Bahan::find($bahanId);

                if (!$bahan) {
                    $errorMessages[] = "Bahan dengan ID {$bahanId} tidak ditemukan.";
                    $jmlBahanKurang = true;
                    continue;
                }

                if ($jumlahDiminta > $bahan->jumlah) {
                    $errorMessages[] = "Jumlah bahan '{$bahan->nama}' tidak mencukupi.";
                    $jmlBahanKurang = true;
                }
            }
        }

        // Simpan data peminjaman bahan jika jumlah cukup
        if (!$jmlBahanKurang) {
            foreach ($id_bahan_array as $key => $bahanId) {
                if (!empty($bahanId)) {
                    $jumlahDiminta = $jumlah_bahan_array[$key] ?? 0;
                    PeminjamanBahan::create([
                        'id_peminjaman_alat_bahan' => $peminjaman->id,
                        'id_bahan' => $bahanId,
                        'jumlah' => $jumlahDiminta
                    ]);
                }
            }
        }

        // Jika ada error, kembalikan pesan kesalahan
        if (!empty($errorMessages)) {
            return response()->json([
                'status' => false,
                'message' => implode("\n", $errorMessages),
                'errors' => $errorMessages
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Proses update peminjaman berhasil',
        ], 200);
    }


    public function PmjAlatBahanByIdUser($id)
    {
        $data_pnj_alatbahan = PeminjamanAlatDanBahan::with(['user', 'peminjamanalat.alat', 'peminjamanbahan.bahan'])
            ->where('user_id', '=', $id)
            ->whereNotIn('status', ['selesai', 'ditolak'])
            ->orderBy('id', 'desc')
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'data' => $data_pnj_alatbahan,
        ], 200);
    }

    public function destroyPmjAlatBahan($id)
    {
        $data_pmj_alat = PeminjamanAlat::where('id_peminjaman_alat_bahan', $id)->delete();
        $data_pmj_bahan = PeminjamanBahan::where('id_peminjaman_alat_bahan', $id)->delete();

        $data_pmj_alatbahan = PeminjamanAlatDanBahan::findOrFail($id);

        if ($data_pmj_alatbahan) {
            $data_pmj_alatbahan->delete();
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data peminjaman tidak ditemukan',
            ], 404);
        }

        // Beri respons berhasil
        return response()->json([
            'status' => true,
            'message' => 'Peminjaman berhasil dihapus',
        ], 200);
    }
}
