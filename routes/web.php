<?php

use App\Http\Controllers\AdminController\AlatController;
use App\Http\Controllers\AdminController\BahanController;
use App\Http\Controllers\AdminController\DashboardController as AdminDashboardController;
use App\Http\Controllers\AdminController\KalenderController;
use App\Http\Controllers\AdminController\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\AdminController\RiwayatController as AdminRiwayatController;
use App\Http\Controllers\AdminController\RuanganController as AdminRuanganController;
use App\Http\Controllers\AdminController\FasilitasController as AdminFasilitasController;
use App\Http\Controllers\AdminController\PeminjamanAlatDanBahanController as AdminAlatBahanController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\UserController\DashboardController;
use App\Http\Controllers\UserController\PeminjamanAlatDanBahanController as UserControllerPeminjamanAlatDanBahanController;
use App\Http\Controllers\UserController\PeminjamanController;
use App\Http\Controllers\UserController\RiwayatController;
use App\Http\Controllers\UserController\PeminjamanAlatDanBahanController;
use App\Http\Controllers\webAuthController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

use function PHPUnit\Framework\returnSelf;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [LandingPageController::class, 'index']);


//register
Route::get('/daftar', [webAuthController::class, 'viewRegister']);
Route::post('/daftar', [webAuthController::class, 'Register'])->name('register');
Route::patch('/admin/confirmregister/{id}', [webAuthController::class, 'confirmRegister'])->name('update-status-user');

//login
Route::get('/login', [webAuthController::class, 'viewLogin']);
Route::post('/login', [webAuthController::class, 'Login']);

Route::middleware('checkToken')->group(function () {
    //admin
    Route::get('/admin/dashboard', [AdminDashboardController::class,'index']);
    Route::get('/admin/konfirmasiuserbaru', [webAuthController::class,'viewConfirmRegister']);
    Route::get('/admin/DataRuangan', [AdminRuanganController::class, 'index']); //data ruangan
    Route::get('/DataRuangan/TambahRuangan', [AdminRuanganController::class, 'create']);
    Route::post('/DataRuangan/TambahRuangan', [AdminRuanganController::class, 'store'])->name('tambah_ruangan');
    Route::get('/DataRuangan/UbahRuangan/{id}', [AdminRuanganController::class, 'edit']);
    Route::put('/DataRuangan/UbahRuangan/{id}', [AdminRuanganController::class, 'update']);
    Route::get('/admin/DataFasilitas', [AdminFasilitasController::class, 'index']);//data fasilitas
    Route::get('/DataFasilitas/TambahFasilitas', [AdminFasilitasController::class, 'create']);
    Route::post('/DataFasilitas/TambahFasilitas', [AdminFasilitasController::class, 'store'])->name('tambah_fasilitas');
    Route::get('/DataFasilitas/UbahFasilitas/{id}', [AdminFasilitasController::class, 'edit']);
    Route::put('/DataFasilitas/UbahFasilitas/{id}', [AdminFasilitasController::class, 'update']);

    Route::get('/admin/accpeminjaman', [AdminPeminjamanController::class, 'index']); //halaman acc peminjaman
    Route::get('/admin/accpeminjaman/detail/{id}', [AdminPeminjamanController::class, 'show']); //detail pemijaman
    Route::post('/update-status/{id}', [AdminPeminjamanController::class, 'updateStatus'])->name('update-status'); //update status
    Route::get('/unduh-file/{id}', [AdminPeminjamanController::class, 'unduhfile']); //untuk download bukti peminjaman
    Route::get('/admin/riwayat', [AdminRiwayatController::class, 'riwayat'])->name('riwayat_search');
    Route::get('/admin/kalender', [KalenderController::class, 'index']);
    Route::post('/admin/riwayat', [AdminRiwayatController::class, 'unduhRiwayat'])->name('download_riwayat');
    //baru
    Route::get('/admin/DataAlat',[AlatController::class,'index']);
    Route::get('/admin/DataAlat/TambahAlat',[AlatController::class,'create']);
    Route::post('/admin/DataAlat/TambahAlat',[AlatController::class,'store'])->name('tambah_alat');
    Route::get('/admin/DataAlat/EditAlat/{id}', [AlatController::class, 'edit']);
    Route::put('/admin/DataAlat/EditAlat/{id}', [AlatController::class, 'update']);
    Route::delete('/admin/DataAlat/HapusAlat/{id}',[AlatController::class,'destroy'])->name('hapus_alat');

    Route::get('/admin/DataBahan', [BahanController::class,'index']);
    Route::get('/admin/DataBahan/TambahBahan', [BahanController::class,'create']);
    Route::post('/admin/DataBahan/TambahBahan', [BahanController::class,'store'])->name('tambah_bahan');
    Route::get('/admin/DataBahan/EditBahan/{id}', [BahanController::class, 'edit']);
    Route::put('/admin/DataBahan/EditBahan/{id}', [BahanController::class, 'update']);
    Route::delete('/admin/DataBahan/HapusBahan/{id}',[BahanController::class,'destroy'])->name('hapus_bahan');

    Route::get('/admin/accpeminjamanAlat&Bahan', [AdminAlatBahanController::class,'index']);
    Route::get('/admin/accpeminjamanAlat&Bahan/{id}', [AdminAlatBahanController::class,'detilPeminjamanAlatBahan']);
    Route::post('/admin/accpeminjamanAlat&Bahan/update-status/{id}', [AdminAlatBahanController::class,'ubahstatus'])->name('ubah-status');


    //user
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/PengajuanPeminjaman', [PeminjamanController::class, 'peminjamanku']);
    Route::get('/AjukanPeminjaman', [PeminjamanController::class, 'create']);
    Route::post('/AjukanPeminjaman', [PeminjamanController::class, 'store'])->name('form_ajukan_peminjaman');
    Route::delete('/PengajuanPeminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('hapus_pengajuan');
    Route::get('/EditPeminjaman/{id}', [PeminjamanController::class, 'edit']);
    Route::get('/peminjaman/detail/{id}', [PeminjamanController::class, 'show']); //detail pemijaman user
    Route::post('/EditPeminjaman/{id}', [PeminjamanController::class, 'update'])->name('ubah_pengajuan');
    Route::patch('/PengajuanPeminjaman/{id}', [PeminjamanController::class, 'updateStatus'])->name('ulasan');
    Route::get('/riwayat', [RiwayatController::class, 'riwayatPeminjaman'])->name('riwayatku_search');
    Route::get('/kalender', [DashboardController::class, 'KalenderPeminjaman']);

    //baru
    Route::get('/PengajuanAlat&Barang',[PeminjamanAlatDanBahanController::class,'index']);
    Route::get('/PengajuanAlat&Barang/ajukan-alat&bahan',[PeminjamanAlatDanBahanController::class,'create']);
    Route::post('/PengajuanAlat&Barang/ajukan-alat&bahan',[PeminjamanAlatDanBahanController::class,'store'])->name('ajukan_alat_bahan');
    Route::delete('/PengajuanAlat&Barang/hapus/{id}',[PeminjamanAlatDanBahanController::class,'destroyPmjAlatBahan'])->name('hapus_pmj_alat_bahan');
    Route::get('/PengajuanAlat&Barang/{id}', [PeminjamanAlatDanBahanController::class,'detilPeminjamanAlatBahan']);
    Route::get('/PengajuanAlat&Barang/ubah/{id}', [PeminjamanAlatDanBahanController::class,'edit']);
    Route::put('/PengajuanAlat&Barang/ubah/{id}', [PeminjamanAlatDanBahanController::class,'update'])->name('ubah_pengajuan_alat_bahan');


    Route::post('/logout', [webAuthController::class, 'Logout'])->name('logout');
});
