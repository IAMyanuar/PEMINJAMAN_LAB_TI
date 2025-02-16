<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PeminjamanAlatDanBahanController extends Controller
{
    public function index()
    {
        $apiUrl = env('API_URL');
        $apiToken = session('api_token');
        $id_user = session('id_user');
        $client = new Client();

        try {
            $url = $apiUrl . '/api/peminjaman-alat-bahan/user/' . $id_user;
            $response = $client->request(
                'GET',
                $url,
                ['headers' => [
                    'Authorization' => 'Bearer ' . $apiToken
                ],]
            );
            $conten = $response->getBody()->getContents();
            $contenarray = json_decode($conten, true);
            $dataPmjAlatBahan = $contenarray['data'];
        } catch (\Throwable $th) {
            return view('user.pengajuan_peminjaman')
                ->with('datakosong');
        }

        return view('user.pengajuan_alat_dan_bahan', compact('dataPmjAlatBahan'));
    }

    public function create()
    {
        $apiUrl = env('API_URL');
        $apiToken = session('api_token');
        $id_user = session('id_user');
        $client = new Client();
        try {
            $url1 = $apiUrl . "/api/alat";
            $response1 = $client->request('GET', $url1, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken
                ],
            ]);
            $url2 = $apiUrl . "/api/bahan";
            $response2 = $client->request('GET', $url2, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken
                ],
            ]);
            $conten1 = $response1->getBody()->getContents();
            $contenarray1 = json_decode($conten1, true);
            $alat = $contenarray1['data'];
            $conten2 = $response2->getBody()->getContents();
            $contenarray2 = json_decode($conten2, true);
            $bahan = $contenarray2['data'];
        } catch (\Throwable $th) {
            //throw $th;
        }
        return view('user.ajukan_alat_bahan', compact('alat', 'bahan'));
    }

    public function store(Request $request)
    {
        $apiUrl = env('API_URL');
        $id_user = session('id_user');
        $apiToken = session('api_token');
        $client = new Client();

        $validatedData = $request->validate([
            'kelas' => 'required',
            'pic' => 'required',
            'tgl_pinjam' => 'required',
            'tgl_selesai' => 'required|after_or_equal:tgl_pinjam',
            'alat' => 'nullable|array',
            'alat.*' => 'nullable|integer',
            'jumlah_alat' => 'nullable|array',
            'jumlah_alat.*' => 'nullable|integer',
            'bahan' => 'nullable|array',
            'bahan.*' => 'nullable|integer',
            'jumlah_bahan' => 'nullable|array',
            'jumlah_bahan.*' => 'nullable|integer',
        ], [
            'alat.*.required_with' => 'Jumlah alat harus diisi jika memilih alat.',
            'jumlah_alat.*.required_with' => 'Jumlah alat harus diisi jika memilih alat.',
            'bahan.*.required_with' => 'Jumlah bahan harus diisi jika memilih bahan.',
            'jumlah_bahan.*.required_with' => 'Jumlah bahan harus diisi jika memilih bahan.',
        ]);
        // Validasi tambahan untuk memastikan jumlah ada jika alat/bahan ada
        foreach ($request->input('alat', []) as $index => $alat) {
            if (!empty($alat) && (empty($request->jumlah_alat[$index]) || $request->jumlah_alat[$index] <= 0)) {
                return back()->withErrors(["jumlah_alat.$index" => "Jumlah alat harus diisi jika memilih alat."])->withInput();
            }
        }

        foreach ($request->input('bahan', []) as $index => $bahan) {
            if (!empty($bahan) && (empty($request->jumlah_bahan[$index]) || $request->jumlah_bahan[$index] <= 0)) {
                return back()->withErrors(["jumlah_bahan.$index" => "Jumlah bahan harus diisi jika memilih bahan."])->withInput();
            }
        }

        try {
            $options = [
                'multipart' => [
                    [
                        'name' => 'kelas',
                        'contents' => $validatedData['kelas']
                    ],
                    [
                        'name' => 'pic',
                        'contents' => $validatedData['pic']
                    ],
                    [
                        'name' => 'tgl_pinjam',
                        'contents' => $validatedData['tgl_pinjam']
                    ],
                    [
                        'name' => 'tgl_selesai',
                        'contents' => $validatedData['tgl_selesai']
                    ],
                    [
                        'name' => 'user_id',
                        'contents' => $id_user
                    ],
                    [
                        'name' => 'alat',
                        'contents' => implode(',', $validatedData['alat'])
                        // 'contents' => json_encode($validatedData['alat'] ?? [])
                        // 'contents' => $validatedData['alat']
                    ],
                    [
                        'name' => 'jumlah_alat',
                        'contents' => implode(',', $validatedData['jumlah_alat'])
                        // 'contents' => json_encode($validatedData['jumlah_alat'] ?? [])
                        // 'contents' => $validatedData['jumlah_alat']
                    ],
                    [
                        'name' => 'bahan',
                        'contents' => implode('"', $validatedData['bahan'])
                        // 'contents' => json_encode($validatedData['bahan'] ?? [])
                        // 'contents' => $validatedData['bahan']
                    ],
                    [
                        'name' => 'jumlah_bahan',
                        'contents' => implode('"', $validatedData['jumlah_bahan'])
                        // 'contents' => json_encode($validatedData['jumlah_bahan'] ?? [])
                        // 'jumlah_bahan', $validatedData['jumlah_bahan']
                    ],


                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken,

                ],

            ];
            // dd($options);
            $client = new Client();
            $url = $apiUrl . "/api/peminjaman-alat-bahan";
            $response = $client->request('POST', $url, $options);
            $response->getBody()->getContents();
            return redirect()->to('/PengajuanAlat&Barang')
                ->with('success', 'Pengajuan ruangan Berhasil');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghubungi API',
                'error' => $e->getMessage(),
                'response' => $e->getResponse() ? json_decode($e->getResponse()->getBody(), true) : null
            ], 500);
        }
    }

    public function edit($id){
        $apiUrl = env('API_URL');
        $apiToken = session('api_token');
        $client = new Client();
        try {
            $url = $apiUrl . "/api/peminjaman-alat-bahan/" . $id;
            $response = $client->request(
                'GET',
                $url,
                ['headers' => [
                    'Authorization' => 'Bearer ' . $apiToken
                ],]
            );
            $conten = $response->getBody()->getContents();
            $contenarray = json_decode($conten, true);
            $dataPmj = $contenarray['data'];
            $url1 = $apiUrl . "/api/alat";
            $response1 = $client->request('GET', $url1, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken
                ],
            ]);
            $url2 = $apiUrl . "/api/bahan";
            $response2 = $client->request('GET', $url2, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken
                ],
            ]);
            $conten1 = $response1->getBody()->getContents();
            $contenarray1 = json_decode($conten1, true);
            $alat = $contenarray1['data'];
            $conten2 = $response2->getBody()->getContents();
            $contenarray2 = json_decode($conten2, true);
            $bahan = $contenarray2['data'];
        } catch (\Throwable $th) {
            // return redirect()->back()->withErrors('error', 'Access Denied');
        }
        return view('user.edit_peminjamanAlatBahan', compact('dataPmj','alat','bahan'));
    }

    public function update(Request $request, $id)
    {
        $apiUrl = env('API_URL');
        $id_user = session('id_user');
        $apiToken = session('api_token');
        $client = new Client();

        $validatedData = $request->validate([
            'kelas' => 'required',
            'pic' => 'required',
            'tgl_pinjam' => 'required',
            'tgl_selesai' => 'required|after_or_equal:tgl_pinjam',
            'alat' => 'nullable|array',
            'alat.*' => 'nullable|integer',
            'jumlah_alat' => 'nullable|array',
            'jumlah_alat.*' => 'nullable|integer',
            'bahan' => 'nullable|array',
            'bahan.*' => 'nullable|integer',
            'jumlah_bahan' => 'nullable|array',
            'jumlah_bahan.*' => 'nullable|integer',
        ]);

        try {
            $options = [
                'multipart' => [
                    [
                        'name' => 'kelas',
                        'contents' => $validatedData['kelas']
                    ],
                    [
                        'name' => 'pic',
                        'contents' => $validatedData['pic']
                    ],
                    [
                        'name' => 'tgl_pinjam',
                        'contents' => $validatedData['tgl_pinjam']
                    ],
                    [
                        'name' => 'tgl_selesai',
                        'contents' => $validatedData['tgl_selesai']
                    ],
                    [
                        'name' => 'user_id',
                        'contents' => $id_user
                    ],
                    [
                        'name' => 'alat',
                        'contents' => implode(',', $validatedData['alat'] ?? [])
                    ],
                    [
                        'name' => 'jumlah_alat',
                        'contents' => implode(',', $validatedData['jumlah_alat'] ?? [])
                    ],
                    [
                        'name' => 'bahan',
                        'contents' => implode(',', $validatedData['bahan'] ?? [])
                    ],
                    [
                        'name' => 'jumlah_bahan',
                        'contents' => implode(',', $validatedData['jumlah_bahan'] ?? [])
                    ],
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken,
                ],
            ];

            $url = $apiUrl . "/api/peminjaman-alat-bahan/ubah/" . $id;
            $response = $client->request('POST', $url, $options);
            $response->getBody()->getContents();

            return redirect()->to('/PengajuanAlat&Barang')
                ->with('success', 'Pengajuan alat dan bahan berhasil diperbarui');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghubungi API',
                'error' => $e->getMessage(),
                'response' => $e->getResponse() ? json_decode($e->getResponse()->getBody(), true) : null
            ], 500);
        }
    }


    public function detilPeminjamanAlatBahan($id)
    {
        $apiUrl = env('API_URL');
        $apiToken = session('api_token');
        $client = new Client();

        try {
            $url = $apiUrl . "/api/peminjaman-alat-bahan/" . $id;
            $response = $client->request(
                'GET',
                $url,
                ['headers' => [
                    'Authorization' => 'Bearer ' . $apiToken
                ],]
            );
            $conten = $response->getBody()->getContents();
            $contenarray = json_decode($conten, true);
            $dataPmj = $contenarray['data'];
        } catch (\Throwable $th) {
            // return redirect()->back()->withErrors('error', 'Access Denied');
        }
        return view('user.detail_peminjamanAlatBahan', compact('dataPmj'));
    }

    public function destroyPmjAlatBahan($id)
    {
        $apiUrl = env('API_URL');
        $apiToken = session('api_token');
        $client = new Client();

        try {
            $options = [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken,
                ],
            ];

            $client = new Client();
            $url = $apiUrl . "/api/peminjaman-alat-bahan/hapus/" . $id;
            $response = $client->request('POST', $url, $options);
            $conten = $response->getBody()->getContents();
            $contenarray = json_decode($conten, true);

            // Beri respons berhasil
            return redirect()->back()->with('success', 'Peminjaman Alat Dan Bahan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/PengajuanAlat&Barang')
                ->with('error', 'Terjadi kesalahan. ' . $e->getMessage());
        }
    }
}
