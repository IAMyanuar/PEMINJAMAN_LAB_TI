<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class BahanController extends Controller
{
    public function index()
    {
        //menampilkan semua data
        $apiUrl = env('API_URL');
        try {
            $apiToken = session('api_token');
            $client = new Client();
            $url = $apiUrl . "/api/bahan";
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken
                ],
            ]);
            $conten = $response->getBody()->getContents();
            $contenarray = json_decode($conten, true);
            $data = $contenarray['data'];
            return view('admin.data_bahan', ['data' => $data]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function create()
    {
        return view('admin.tambah_bahan');
    }

    public function store(Request $request)
    {
        //tambah ruangan
        $apiUrl = env('API_URL');
        $apiToken = session('api_token');
        $validatedData = $request->validate([
            'nama' => 'required|max:70',
            'satuan' => 'required',
            'jumlah' => 'required',
        ]);
        try {
            $options = [
                'multipart' => [
                    [
                        'name' => 'nama',
                        'contents' => $validatedData['nama']
                    ],
                    [
                        'name' => 'satuan',
                        'contents' => $validatedData['satuan']
                    ],
                    [
                        'name' => 'jumlah',
                        'contents' => $validatedData['jumlah']
                    ],
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken,
                ],

            ];

            $client = new Client();
            $url = $apiUrl . "/api/bahan";
            $response = $client->request('POST', $url, $options);
            $response->getBody()->getContents();
            return redirect()->to('/admin/DataBahan')
                ->with('success', 'bahan ' . $validatedData['nama'] . ' berhasil ditambahkan');

        } catch (RequestException $e) {
            $response = $e->getResponse();
            $conten = $response->getBody()->getContents();
            $contenarray = json_decode($conten, true);
            // perbaikan bug
            $errorMessages = '';
            if (!empty($contenarray['data'])) {
                foreach ($contenarray['data'] as $errors) {
                    $errorMessages .= implode(" ", $errors) . ", ";
                }
            }

            return redirect()->back()
                ->with(['BahanIsExist' => $contenarray['message'] . " " . json_encode($errorMessages)]);
        }
    }

    public function edit(string $id)
    {
        try {
            $apiUrl = env('API_URL');
            $apiToken = session('api_token');
            $client = new Client();
            $url = $apiUrl . "/api/bahan/$id";
            $response = $client->request('GET', $url, ['headers' => [
                'Authorization' => 'Bearer ' . $apiToken,
            ],]);
            $conten = $response->getBody()->getContents();
            $contenarray = json_decode($conten, true);
            $data = $contenarray['data'];
            return view('admin.ubah_bahan', ['data' => $data]);
        } catch (\Throwable $th) {
            return redirect()->to('/admin/DataBahan');
        }
    }

    public function update(Request $request, string $id)
    {
        $apiUrl = env('API_URL');
        $apiToken = session('api_token');
        $validatedData = $request->validate([
            'nama' => 'required',
            'satuan' => 'required',
            'jumlah'=> 'required',

        ]);

        // dd($request->all());
        try {
            $options = [
                'multipart' => [
                    [
                        'name' => 'nama',
                        'contents' => $validatedData['nama']
                    ],
                    [
                        'name' => 'satuan',
                        'contents' => $validatedData['satuan']
                    ],
                    [
                        'name' => 'jumlah',
                        'contents' => $validatedData['jumlah']
                    ]
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken,
                ],

            ];

            $client = new Client();
            $url = $apiUrl . "/api/bahan-update/$id";
            $response = $client->request('POST', $url, $options);
            $response->getBody()->getContents();
            return redirect()->to('/admin/DataBahan')
                ->with('success', 'data bahan ' . $validatedData['nama'] . ' berhasil di ubah');
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $conten = $response->getBody()->getContents();
            $contenarray = json_decode($conten, true);
            // perbaikan bug
            $errorMessages = '';
            if (!empty($contenarray['data'])) {
                foreach ($contenarray['data'] as $errors) {
                    $errorMessages .= implode(" ", $errors) . ", ";
                }
            }
            return redirect()->back()
                ->with(['BahanIsExist' => $contenarray['message'] . " " . json_encode($errorMessages)]);
        }
    }


    public function destroy(string $id)
    {
        $apiUrl = env('API_URL');
        $apiToken = session('api_token');

        try {
            $options = [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken,
                ],
            ];

            $client = new Client();
            $url = $apiUrl . "/api/bahan-delete/" . $id;
            $response = $client->request('POST', $url, $options);
            $conten = $response->getBody()->getContents();
            $contenarray = json_decode($conten, true);

            // Beri respons berhasil
            return redirect()->back()->with('success', 'Bahan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/admin/DataBahan')
                ->with('error', 'Terjadi kesalahan. ' . $e->getMessage());
        }
    }
}
