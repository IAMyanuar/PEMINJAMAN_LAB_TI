@extends('layout.master1')

@section('title')
    SI PIRANG | ACC peminjaman Alat dan Bahan
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
                    <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Konfirmasi Peminjaman Alat Dan Bahan</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 p-0">
                                <li class="breadcrumb-item"><a href=""> </a></li>
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
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title mb-3"> </h4>

                                        <ul class="nav nav-tabs nav-bordered mb-3">
                                            <li class="nav-item">
                                                <a href="#submitted" data-toggle="tab" aria-expanded="false"
                                                    class="nav-link  active">
                                                    <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                                    <span class="d-none d-lg-block">Terkirim
                                                        @if (count($dataPmjterkirim) !== 0)
                                                            <span
                                                                class="badge badge-primary notify-no rounded-circle">{{ count($dataPmjterkirim) }}</span>
                                                        @endif
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#approved" data-toggle="tab" aria-expanded="true" class="nav-link">
                                                    <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                                    <span class="d-none d-lg-block">Di Proses
                                                        @if (count($dataPmjproses) !== 0)
                                                            <span
                                                                class="badge badge-primary notify-no rounded-circle">{{ count($dataPmjproses) }}</span>
                                                        @endif
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="submitted">
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
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            @if (empty($dataPmjterkirim))
                                                                <tr>
                                                                    <td colspan="10" class="text-center"><strong>Tidak ada
                                                                            yang mengajukan peminjaman Alat dan Bahan</strong></td>
                                                                </tr>
                                                            @endif
                                                            @foreach ($dataPmjterkirim as $item)
                                                                <tr>
                                                                    <td>{{ $no++ }}</td>
                                                                    <td>{{ $item['user']['nama'] }}</td>
                                                                    <td>{{ $item['kelas'] }}</td>
                                                                    <td>{{ $item['pic'] }}</td>
                                                                    <td>
                                                                        @foreach ($item['peminjamanalat'] as $itemAlat)
                                                                        @if ($itemAlat['id_peminjaman_alat_bahan'] == $item['id'])
                                                                            - {{ $itemAlat['alat']['nama'] }} : {{ $itemAlat['jumlah'] }} {{ $itemAlat['alat']['satuan'] }} <br>
                                                                        @endif
                                                                    @endforeach
                                                                    </td>
                                                                    <td>
                                                                        @foreach ($item['peminjamanbahan'] as $itemBahan)
                                                                        @if ($itemBahan['id_peminjaman_alat_bahan'] == $item['id'])
                                                                            - {{ $itemBahan['bahan']['nama'] }} : {{ $itemBahan['jumlah'] }} {{ $itemBahan['bahan']['satuan'] }} <br>
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
                                                                    <td class="text-secondary font-weight-bold">{{ $item['status'] }}</td>
                                                                    <td>
                                                                        <form method="POST"
                                                                            action="{{ route('ubah-status', ['id' => $item['id'], 'status' => 'di prosess']) }}">
                                                                            @csrf
                                                                            @method('POST')
                                                                            <button class="btn btn-success btn-rounded"
                                                                                data-toggle="tooltip" data-placement="left"
                                                                                title="" data-original-title="Setujui"
                                                                                type="submit"><i
                                                                                    class="fas fa-check"></i></button>
                                                                        </form>

                                                                        <button class="btn btn-danger btn-rounded"
                                                                            type="button" data-toggle="modal"
                                                                            data-target="#reject-modal"
                                                                            data-id="{{ $item['id'] }}">
                                                                            <i class="fas fa-times" data-toggle="tooltip"
                                                                                data-placement="left" title=""
                                                                                data-original-title="Tolak"></i>
                                                                        </button>

                                                                        <a class="btn btn-info btn-rounded"
                                                                            data-toggle="tooltip" data-placement="right"
                                                                            title="" data-original-title="Detail"
                                                                            href="{{ url('admin/accpeminjamanAlat&Bahan/' . $item['id']) }}"><i
                                                                                class="fas fa-search-plus"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane show" id="approved">
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
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            @if (empty($dataPmjproses))
                                                                <tr>
                                                                    <td colspan="10" class="text-center"><strong>Tidak ada
                                                                            yang mengajukan peminjaman Alat dan Bahan</strong></td>
                                                                </tr>
                                                            @endif
                                                            @foreach ($dataPmjproses as $item_proses)
                                                                <tr>
                                                                    <td>{{ $no++ }}</td>
                                                                    <td>{{ $item_proses['user']['nama'] }}</td>
                                                                    <td>{{ $item_proses['kelas'] }}</td>
                                                                    <td>{{ $item_proses['pic'] }}</td>
                                                                    <td>
                                                                        @foreach ($item_proses['peminjamanalat'] as $itemAlatProses)
                                                                        @if ($itemAlatProses['id_peminjaman_alat_bahan'] == $item_proses['id'])
                                                                            - {{ $itemAlatProses['alat']['nama'] }} : {{ $itemAlatProses['jumlah'] }} {{ $itemAlatProses['alat']['satuan'] }} <br>
                                                                        @endif
                                                                    @endforeach
                                                                    </td>
                                                                    <td>
                                                                        @foreach ($item_proses['peminjamanbahan'] as $itemBahanProses)
                                                                        @if ($itemBahanProses['id_peminjaman_alat_bahan'] == $item_proses['id'])
                                                                            - {{ $itemBahanProses['bahan']['nama'] }} : {{ $itemBahanProses['jumlah'] }} {{ $itemBahanProses['bahan']['satuan'] }} <br>
                                                                        @endif
                                                                    @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ date('d-m-Y', strtotime($item_proses['tgl_pinjam'])) }}
                                                                        <br>jam:
                                                                        {{ date('H:i', strtotime($item_proses['tgl_pinjam'])) }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ date('d-m-Y', strtotime($item_proses['tgl_selesai'])) }}
                                                                        <br>jam:
                                                                        {{ date('H:i', strtotime($item_proses['tgl_selesai'])) }}
                                                                    </td>
                                                                    <td class="text-warning font-weight-bold">{{ $item_proses['status'] }}</td>
                                                                    <td>
                                                                        <form method="POST"
                                                                            action="{{ route('ubah-status', ['id' => $item_proses['id'], 'status' => 'selesai']) }}">
                                                                            @csrf
                                                                            @method('POST')
                                                                            <button class="btn btn-success btn-rounded"
                                                                                data-toggle="tooltip" data-placement="left"
                                                                                title="" data-original-title="Selesai"
                                                                                type="submit"><i
                                                                                    class="fas fa-check"></i></button>
                                                                        </form>

                                                                        <a class="btn btn-info btn-rounded"
                                                                            data-toggle="tooltip" data-placement="right"
                                                                            title="" data-original-title="Detail"
                                                                            href="{{ url('admin/accpeminjamanAlat&Bahan/' . $item_proses['id']) }}"><i
                                                                                class="fas fa-search-plus"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end card-body-->
                                    </div>
                                @endsection
