@extends('layout.master2')

@section('title')
    SI PIRANG | Detail Peminjaman Alat Dan Bahan
@stop

@section('css')

@stop

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-7 align-self-center">
                    <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Detail Peminjaman Alat Dan Bahan</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 p-0">
                                <li class="breadcrumb-item"></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-5 align-self-center">
                    <div class="customize-input float-right">
                        <p><span class="form-control bg-white border-0 custom-shadow custom-radius"id="tanggalwaktu"></span>
                        </p>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-actions">
                                        <div class="text-left">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h3 class="card-title">Nama Peminjam</h3>
                                                    </div>
                                                    <div class="row col-sm-1">
                                                        <h3 class="card-title">:</h3>
                                                    </div>
                                                    <div class="row col-auto mb-3">
                                                        <h3>{{ $dataPmj['user']['nama'] }}</h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h3 class="card-title">NIM</h3>
                                                    </div>
                                                    <div class="row col-sm-1">
                                                        <h3 class="card-title">:</h3>
                                                    </div>
                                                    <div class="row col-auto mb-3">
                                                        <h3>{{ $dataPmj['user']['nim'] }}</h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h3 class="card-title">NO.TELP</h3>
                                                    </div>
                                                    <div class="row col-sm-1">
                                                        <h3 class="card-title">:</h3>
                                                    </div>
                                                    <div class="row col-auto mb-3">
                                                        <h3>{{ $dataPmj['user']['telp'] }}</h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h3 class="card-title">Email</h3>
                                                    </div>
                                                    <div class="row col-sm-1">
                                                        <h3 class="card-title">:</h3>
                                                    </div>
                                                    <div class="row col-auto mb-3">
                                                        <h3>{{ $dataPmj['user']['email'] }}</h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h3 class="card-title">Kelas</h3>
                                                    </div>
                                                    <div class="row col-sm-1">
                                                        <h3 class="card-title">:</h3>
                                                    </div>
                                                    <div class="row col-auto mb-3">
                                                        <h3>{{ $dataPmj['kelas'] }}</h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h3 class="card-title">PIC - Dosen Pengampu</h3>
                                                    </div>
                                                    <div class="row col-sm-1">
                                                        <h3 class="card-title">:</h3>
                                                    </div>
                                                    <div class="row col-auto mb-3">
                                                        <h3>{{ $dataPmj['pic'] }}</h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h3 class="card-title">Tanggal dan Waktu Mulai</h3>
                                                    </div>
                                                    <div class="row col-sm-1">
                                                        <h3 class="card-title">:</h3>
                                                    </div>
                                                    <div class="row col-auto mb-3">
                                                        <h3>{{ date('d-m-Y', strtotime($dataPmj['tgl_pinjam'])) }} | {{ date('H:i', strtotime($dataPmj['tgl_pinjam'])) }}</h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h3 class="card-title">Tanggal dan Waktu Selesai</h3>
                                                    </div>
                                                    <div class="row col-sm-1">
                                                        <h3 class="card-title">:</h3>
                                                    </div>
                                                    <div class="row col-auto mb-3">
                                                        <h3>{{ date('d-m-Y', strtotime($dataPmj['tgl_selesai'])) }} | {{ date('H:i', strtotime($dataPmj['tgl_selesai'])) }}</h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h3 class="card-title">Alat</h3>
                                                    </div>
                                                    <div class="row col-sm-1">
                                                        <h3 class="card-title">:</h3>
                                                    </div>
                                                    <div class="col">
                                                        @foreach ($dataPmj['peminjamanalat'] as $item)
                                                            <div class="d-flex">
                                                                <h3 class="me-3">- {{ $item['alat']['nama'] }} : {{ $item['jumlah'] }} {{ $item['alat']['satuan'] }}</h3>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h3 class="card-title">Bahan</h3>
                                                    </div>
                                                    <div class="row col-sm-1">
                                                        <h3 class="card-title">:</h3>
                                                    </div>
                                                    <div class="col">
                                                        @foreach ($dataPmj['peminjamanbahan'] as $item)
                                                            <div class="d-flex">
                                                                <h3 class="me-3">- {{ $item['bahan']['nama'] }} : {{ $item['jumlah'] }} {{ $item['bahan']['satuan'] }}</h3>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h3 class="card-title">Status</h3>
                                                    </div>
                                                    <div class="row col-sm-1">
                                                        <h3 class="card-title">:</h3>
                                                    </div>
                                                    @if ($dataPmj['status']=='terkirim')
                                                    <div class="row col-auto mb-3">
                                                        <h3 class="text-secondary font-weight-bold">{{ $dataPmj['status'] }}</h3>
                                                    </div>
                                                    @endif
                                                    @if ($dataPmj['status']=='ditolak')
                                                    <div class="row col-auto mb-3">
                                                        <h3 class="text-danger font-weight-bold">{{ $dataPmj['status'] }}</h3>
                                                    </div>
                                                    @endif
                                                    @if ($dataPmj['status']=='di prosess')
                                                    <div class="row col-auto mb-3">
                                                        <h3 class="text-warning font-weight-bold">{{ $dataPmj['status'] }}</h3>
                                                    </div>
                                                    @endif
                                                    @if ($dataPmj['status']=='selesai')
                                                    <div class="row col-auto mb-3">
                                                        <h3 class="text-info font-weight-bold">{{ $dataPmj['status'] }}</h3>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endsection
