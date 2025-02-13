<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
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
        //
        return view('admin.tambah_alat');
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
            return redirect()->back()->with('success', 'Alat berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/admin/DataBahan')
                ->with('error', 'Terjadi kesalahan. ' . $e->getMessage());
        }
    }
}
