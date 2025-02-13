<?php

use App\Http\Controllers\API\AlatController;
use Illuminate\Http\Request;
use App\Http\Controllers\API\authController;
use App\Http\Controllers\API\BahanController;
use App\Http\Controllers\API\FasilitasController;
use App\Http\Controllers\API\PeminjamanAlatDanBahanController;
use App\Http\Controllers\API\RuanganController;
use App\Http\Controllers\API\PeminjamanController;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/',function(){
    return response()->json([
        'status' => false,
        'massage' => 'akses tidak diperbolehkan'
    ],401);
})->name('login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//auth
Route::post('registerUser',[authController::class, 'RegisterUser']);//register
Route::post('confirmregister/{id}',[authController::class, 'confirmRegister'])->middleware('auth:sanctum','ablity:access-admin'); //confirm register
Route::get('showuser/{id}',[authController::class, 'showUser'])->middleware('auth:sanctum','ablity:access-admin'); //confirm register
Route::post('login',[authController::class, 'Login']);//login
Route::post('logout',[authController::class, 'Logout'])->middleware('auth:sanctum');//logout


//admin
Route::get('ruangan',[RuanganController::class, 'index']);//menampilkan data ruangan
Route::post('tambahruangan',[RuanganController::class, 'store'])->middleware('auth:sanctum','ablity:access-admin');//tambah ruangan
Route::get('ruangan/{id}',[RuanganController::class,'show'])->middleware('auth:sanctum','ablity:access-admin');//menampilkan data ruangan berdasarkan id
Route::post('ruangan/{id}',[RuanganController::class,'update'])->middleware('auth:sanctum','ablity:access-admin');//edit ruangan
Route::get('peminjaman',[PeminjamanController::class, 'peminjaman']);//
Route::get('peminjaman/submitted',[PeminjamanController::class, 'index'])->middleware('auth:sanctum','ablity:access-admin');//menampilkan data peminjaman yang belum disetujui
Route::get('peminjaman/approve',[PeminjamanController::class, 'peminjamApprove'])->middleware('auth:sanctum','ablity:access-admin');//menampilkan data peminjaman approve
Route::get('peminjaman/inprogress',[PeminjamanController::class, 'peminjamInProgress'])->middleware('auth:sanctum','ablity:access-admin');//menampilkan data peminjaman in progress
Route::get('peminjaman/riwayat',[PeminjamanController::class, 'riwayat'])->middleware('auth:sanctum','ablity:access-admin');//riwayat
Route::get('peminjaman/{id}',[PeminjamanController::class,'show'])->middleware('auth:sanctum');//menampilkan data peminjaman berdasarkan id
Route::get('unduhFileDokumen/{id}',[PeminjamanController::class,'unduhFile'])->middleware('auth:sanctum');//unduh file bukti pendukung peminjaman
Route::post('peminjaman/{id}',[PeminjamanController::class,'updateStatus'])->middleware('auth:sanctum','ablity:access-admin');//edit Status
Route::get('fasilitas',[FasilitasController::class,'index']);
Route::post('tambahfasilitas',[FasilitasController::class, 'store']);
Route::get('fasilitas/{id}',[FasilitasController::class,'show']);
Route::post('fasilitas/{id}',[FasilitasController::class,'update']);
Route::post('riwayat/download',[PeminjamanController::class, 'downloadPeminjamanByMonth']);
//penambahan fitur admin
Route::get('alat',[AlatController::class, 'index']); //menampilkan data alat
Route::post('alat',[AlatController::class, 'store'])->middleware('auth:sanctum','ablity:access-admin');//tambah alat
Route::get('alat/{id}',[AlatController::class, 'show']); //detail alat
Route::post('alat-update/{id}',[AlatController::class, 'update'])->middleware('auth:sanctum','ablity:access-admin'); //ubah alat
Route::post('alat-delete/{id}',[AlatController::class, 'destroy'])->middleware('auth:sanctum','ablity:access-admin'); //hapus alat
Route::get('bahan',[BahanController::class, 'index']);
Route::post('bahan',[BahanController::class, 'store'])->middleware('auth:sanctum','ablity:access-admin');//tambah bahan
Route::get('bahan/{id}',[BahanController::class, 'show']); //detail alat
Route::post('bahan-update/{id}',[BahanController::class, 'update'])->middleware('auth:sanctum','ablity:access-admin'); //ubah bahan
Route::post('bahan-delete/{id}',[BahanController::class, 'destroy'])->middleware('auth:sanctum','ablity:access-admin'); //hapus bahan

//user
Route::post('peminjaman',[PeminjamanController::class, 'storepeminjaman']);//tambah peminjaman
Route::get('peminjamanbyuser/{id}',[PeminjamanController::class,'peminjamanByUser'])->middleware('auth:sanctum','ablity:access-peminjam');//menampilkan data berdasarkan id user
Route::post('EditPeminjaman/{id}',[PeminjamanController::class,'update'])->middleware('auth:sanctum','ablity:access-peminjam');//edit ruangan
Route::post('peminjaman/{id}/feedback',[PeminjamanController::class,'feedback'])->middleware('auth:sanctum','ablity:access-peminjam');//feedback dari user
Route::get('peminjaman/riwayat/{id}',[PeminjamanController::class, 'riwatyatPeminjamanByUser'])->middleware('auth:sanctum','ablity:access-peminjam');//riwayat peminjaman user
Route::post('hapus-peminjaman/{id}',[PeminjamanController::class, 'destroy'])->middleware('auth:sanctum','ablity:access-peminjam');//hapus peminjaman


//kalender
Route::get('kalender',[PeminjamanController::class,'KalenderPeminjaman']);

//list user
Route::get('user',[authController::class, 'listDataUser'])->middleware('auth:sanctum','ablity:access-admin');
