<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        //menampilkan semua data
        $apiUrl = env('API_URL');
        try {
            $apiToken = session('api_token');
            $client = new Client();
            $url = $apiUrl . "/api/alat";
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken
                ],
            ]);
            $conten = $response->getBody()->getContents();
            $contenarray = json_decode($conten, true);
            $data = $contenarray['data'];
            return view('admin.data_alat', ['data' => $data]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function create()
    {
        //
        return view('admin.tambah_alat');
    }

    public function store(Request $request)
    {
        //tambah ruangan
        $apiUrl = env('API_URL');
        $apiToken = session('api_token');
        $validatedData = $request->validate([
            'nama' => 'required',
            'satuan' => 'required',
            'foto' => 'required|image',
            'jumlah' => 'required',
        ]);
        try {
            $foto = $request->file('foto');
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
                        'name' => 'foto',
                        'contents' => fopen($foto, 'r'),
                        'filename' => $foto->getClientOriginalName(),
                        'headers'  => [
                            'Content-Type' => '<Content-type header>'
                        ]
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
            $url = $apiUrl . "/api/alat";
            $response = $client->request('POST', $url, $options);
            $response->getBody()->getContents();
            return redirect()->to('/admin/DataAlat')
                ->with('success', 'ruangan ' . $validatedData['nama'] . ' berhasil ditambahkan');

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
                ->with(['AlatIsExist' => $contenarray['message'] . " " . json_encode($errorMessages)]);
        }
    }

    public function edit(string $id)
    {
        try {
            $apiUrl = env('API_URL');
            $apiToken = session('api_token');
            $client = new Client();
            $url = $apiUrl . "/api/alat/$id";
            $response = $client->request('GET', $url, ['headers' => [
                'Authorization' => 'Bearer ' . $apiToken,
            ],]);
            $conten = $response->getBody()->getContents();
            $contenarray = json_decode($conten, true);
            $data = $contenarray['data'];
            return view('admin.ubah_alat', ['data' => $data]);
        } catch (\Throwable $th) {
            return redirect()->to('/admin/DataAlat');
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
            'foto' => 'nullable|image',

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
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $options['multipart'][] = [
                    'name' => 'foto',
                    'contents' => fopen($foto->getPathname(), 'r'),
                    'filename' => $foto->getClientOriginalName(),
                    'headers' => [
                        'Content-Type' => '<Content-type header>'
                    ]
                ];
            }

            $client = new Client();
            $url = $apiUrl . "/api/alat-update/$id";
            $response = $client->request('POST', $url, $options);
            $response->getBody()->getContents();
            return redirect()->to('/admin/DataAlat')
                ->with('success', 'data alat ' . $validatedData['nama'] . ' berhasil di ubah');
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
                ->with(['AlatIsExist' => $contenarray['message'] . " " . json_encode($errorMessages)]);
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
            $url = $apiUrl . "/api/alat-delete/" . $id;
            $response = $client->request('POST', $url, $options);
            $conten = $response->getBody()->getContents();
            $contenarray = json_decode($conten, true);

            // Beri respons berhasil
            return redirect()->back()->with('success', 'Alat berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/admin/DataAlat')
                ->with('error', 'Terjadi kesalahan. ' . $e->getMessage());
        }
    }
}
