@extends('layout.master2')

@section('title')
    SI PIRANG | Pengajuan Alat & Bahan
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
                    <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Pengajuan Alat Dan Bahan</h3>
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
                                @if (session()->has('info'))
                                    <div class="alert alert-warning">
                                        <strong>{{ session('info') }}</strong>
                                    </div>
                                @endif
                                @if (session()->has('success'))
                                    <div class="alert alert-success">
                                        <strong>{{ session('success') }}</strong>
                                    </div>
                                @endif
                                @if (session()->has('error'))
                                    <div class="alert alert-danger">
                                        <strong>{{ session('error') }}</strong>
                                    </div>
                                @endif

                                <div class="card-body">
                                    <div class="form-actions">
                                        <div class="text-right mb-3">
                                            <a class="btn btn-success btn-rounded"
                                                href="{{ url('/PengajuanAlat&Barang/ajukan-alat&bahan') }}">Ajukan
                                                Peminjaman (+)</a>
                                        </div>
                                    </div>


                                    <div class="table-responsive table-bordered">
                                        <table class="table">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th>no</th>
                                                    <th>Nama Peminjam</th>
                                                    <th>Kelas</th>
                                                    <th>PIC-Dosen Pengampu</th>
                                                    <th>Alat</th>
                                                    <th>Bahan</th>
                                                    <th>Waktu Pinjam</th>
                                                    <th>Waktu Kembali</th>
                                                    <th>Status</th>
                                                    <th>aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (empty($dataPmjAlatBahan))
                                                    <tr>
                                                        <td colspan="10" class="text-center"><strong>
                                                                Anda Belum Mengajukan Ruangan Peminjaman Ruangan
                                                            </strong></td>
                                                    </tr>
                                                @else
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach ($dataPmjAlatBahan as $item)
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ $item['user']['nama'] }}</td>
                                                            <td>{{ $item['kelas'] }}</td>
                                                            <td>{{ $item['pic'] }}</td>
                                                            <td>
                                                                @foreach ($item['peminjamanalat'] as $itemAlat)
                                                                    @if ($itemAlat['id_peminjaman_alat_bahan'] == $item['id'])
                                                                        - {{ $itemAlat['alat']['nama'] }} :
                                                                        {{ $itemAlat['jumlah'] }}
                                                                        {{ $itemAlat['alat']['satuan'] }} <br>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach ($item['peminjamanbahan'] as $itemBahan)
                                                                    @if ($itemBahan['id_peminjaman_alat_bahan'] == $item['id'])
                                                                        - {{ $itemBahan['bahan']['nama'] }} :
                                                                        {{ $itemBahan['jumlah'] }}
                                                                        {{ $itemBahan['bahan']['satuan'] }} <br>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td class="text-center">
                                                                {{ date('d-m-Y', strtotime($item['tgl_pinjam'])) }}
                                                                <br>jam:
                                                                {{ date('H:i', strtotime($item['tgl_pinjam'])) }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ date('d-m-Y', strtotime($item['tgl_selesai'])) }}
                                                                <br>jam:
                                                                {{ date('H:i', strtotime($item['tgl_selesai'])) }}
                                                            </td>

                                                                @if ($item['status'] == 'terkirim')
                                                                    <td class="text-secondary font-weight-bold">{{ $item['status'] }}</td>
                                                                @elseif ($item['status'] == 'di prosess')
                                                                    <td class="text-info font-weight-bold">{{ $item['status'] }}</td>
                                                                @endif

                                                            <td>
                                                                @if ($item['status'] == 'terkirim')
                                                                    <a href="{{ url('/PengajuanAlat&Barang/ubah/' . $item['id']) }}"
                                                                        class="btn btn-warning btn-rounded"
                                                                        data-toggle="tooltip" data-placement="left"
                                                                        title="" data-original-title="Ubah"><i
                                                                            class="fas fa-edit"></i></a>
                                                                    <form
                                                                        action="{{ route('hapus_pmj_alat_bahan', $item['id']) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-rounded"
                                                                            data-toggle="tooltip" data-placement="left"
                                                                            title="" data-original-title="Hapus"><i
                                                                                class="fas fa-trash-alt"></i></button>
                                                                    </form>
                                                                    <a class="btn btn-info btn-rounded"
                                                                        data-toggle="tooltip" data-placement="left"
                                                                        title="" data-original-title="Detail"
                                                                        href="{{ url('/PengajuanAlat&Barang/' . $item['id']) }}"><i
                                                                            class="fas fa-search-plus"></i></a>
                                                                @endif

                                                                @if ($item['status'] == 'di prosess')
                                                                    <a class="btn btn-info btn-rounded"
                                                                        data-toggle="tooltip" data-placement="left"
                                                                        title="" data-original-title="Detail"
                                                                        href="{{ url('/PengajuanAlat&Barang/' . $item['id']) }}"><i
                                                                            class="fas fa-search-plus"></i></a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                @endsection
