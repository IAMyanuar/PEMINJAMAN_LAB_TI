<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class PeminjamanAlatDanBahanController extends Controller
{
    public function index()
    {
        $apiUrl = env('API_URL');
        $apiToken = session('api_token');
        $client = new Client();

        try {
            $url1 = $apiUrl . "/api/peminjaman-alat-bahan";
            $response1 = $client->request(
                'GET',
                $url1,
                ['headers' => [
                    'Authorization' => 'Bearer ' . $apiToken
                ],]
            );
            $conten1 = $response1->getBody()->getContents();
            $contenarray1 = json_decode($conten1, true);
            $dataPmjterkirim = $contenarray1['data'];
        } catch (\Throwable $th) {
            // return redirect()->back()->withErrors('error', 'Access Denied');
        }

        try {
            $url2 = $apiUrl . "/api/peminjaman-alat-bahan/inprogress";
            $response2 = $client->request(
                'GET',
                $url2,
                ['headers' => [
                    'Authorization' => 'Bearer ' . $apiToken
                ],]
            );
            $conten2 = $response2->getBody()->getContents();
            $contenarray2 = json_decode($conten2, true);
            $dataPmjproses = $contenarray2['data'];
        } catch (\Throwable $th) {
            // return redirect()->back()->withErrors('error', 'Access Denied');
        }

        return view('admin.acc_peminjaman_alat_bahan', compact('dataPmjterkirim', 'dataPmjproses'));
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
        return view('admin.detail_peminjamanAlatBahan', compact('dataPmj'));
    }

    public function ubahstatus(Request $request, $id)
    {
        $apiUrl = env('API_URL');
        $apiToken = session('api_token');
        $client = new Client();

        try {
            $datadiubah = [
                'Authorization' => 'Bearer ' . $apiToken,
                'status' => $request->input('status'),
            ];

            $client = new Client();
            $url = $apiUrl . "/api/peminjaman-alat-bahan/update-status/{$id}";
            $response = $client->request('POST', $url, ['json' =>  $datadiubah, 'headers' => [
                'Authorization' => 'Bearer ' . $apiToken,
            ],]);

            // Periksa respons dari API
            if ($response->getStatusCode() === 201) {
                return redirect()->back()->with('success', 'Status berhasil di ubah');
            } else {
                return redirect()->back()->with('error', 'Gagal merubah status');
            }
            //perbaikan bug
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $conten = $response->getBody()->getContents();
            $contenarray = json_decode($conten, true);

            return redirect()->back()
                ->with(['error' => $contenarray['message']]);
        }
    }
}
