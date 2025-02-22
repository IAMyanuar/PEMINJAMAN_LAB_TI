@extends('layout.master1')

@section('title')
    SI PIRANG | ACC peminjaman
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
                    <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Konfirmasi Peminjaman</h3>
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
                                {{-- <div class="card-body">
                                    <div class="form-actions">
                                        <div class="text-right">
                                        //
                                        </div>
                                    </div> --}}
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title mb-3"> </h4>

                                        <ul class="nav nav-tabs nav-bordered mb-3">
                                            <li class="nav-item">
                                                <a href="#submitted" data-toggle="tab" aria-expanded="false"
                                                    class="nav-link  active">
                                                    <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                                    <span class="d-none d-lg-block">terkirim
                                                        @if (count($datapeminjamansubmitted[0]) !== 0)
                                                            <span
                                                                class="badge badge-primary notify-no rounded-circle">{{ count($datapeminjamansubmitted[0]) }}</span>
                                                        @endif
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#approved" data-toggle="tab" aria-expanded="true" class="nav-link">
                                                    <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                                    <span class="d-none d-lg-block">disetujui
                                                        @if (count($datapmjapprove[0]) !== 0)
                                                            <span
                                                                class="badge badge-primary notify-no rounded-circle">{{ count($datapmjapprove[0]) }}</span>
                                                        @endif
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#inprogress" data-toggle="tab" aria-expanded="false"
                                                    class="nav-link">
                                                    <i class="mdi mdi-settings-outline d-lg-none d-block mr-1"></i>
                                                    <span class="d-none d-lg-block">di proses
                                                        @if (count($datapmjinprogress[0]) !== 0)
                                                            <span
                                                                class="badge badge-primary notify-no rounded-circle">{{ count($datapmjinprogress[0]) }}</span>
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
                                                                <th>Nama Lembaga</th>
                                                                <th>Nama Kegiatan</th>
                                                                <th>Ruangan</th>
                                                                <th>Fasilitas</th>
                                                                <th>Waktu Mulai</th>
                                                                <th>Waktu Selesai</th>
                                                                <th>surat pendukung</th>
                                                                <th>status</th>
                                                                <th>aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            @if (empty($datapeminjamansubmitted))
                                                                <tr>
                                                                    <td colspan="10" class="text-center"><strong>Tidak ada
                                                                            yang mengajukan peminjaman ruangan</strong></td>
                                                                </tr>
                                                            @endif
                                                            @foreach ($datapeminjamansubmitted[0] as $item)
                                                                <tr>
                                                                    <td>{{ $no++ }}</td>
                                                                    <td>{{ $item['nama_user'] }}</td>
                                                                    <td>{{ $item['nama_lembaga'] }}</td>
                                                                    <td>{{ $item['kegiatan'] }}</td>
                                                                    <td>{{ $item['nama_ruangan'] }}</td>
                                                                    <td>
                                                                        @foreach ($datapeminjamansubmitted[1] as $itemfasilitas)
                                                                            @if ($itemfasilitas['id_peminjaman']==$item['id'])
                                                                            - {{ $itemfasilitas['nama'] }}: {{ $itemfasilitas['jumlah'] }} <br>
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ date('d-m-Y', strtotime($item['tgl_mulai'])) }}
                                                                        <br>jam:
                                                                        {{ date('H:i', strtotime($item['jam_mulai'])) }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ date('d-m-Y', strtotime($item['tgl_selesai'])) }}
                                                                        <br>jam:
                                                                        {{ date('H:i', strtotime($item['jam_selesai'])) }}
                                                                    </td>
                                                                    <td class="text-center"><a
                                                                            class=" btn btn-circle btn-success"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title=""
                                                                            data-original-title="Unduh Surat Pendukung"
                                                                            href="{{ url('/unduh-file/' . $item['id']) }}"><i
                                                                                class="fa fa-download"></a></td>
                                                                    <td>{{ $item['status'] }}</td>
                                                                    <td>
                                                                        <form method="POST"
                                                                            action="{{ route('update-status', ['id' => $item['id'], 'status' => 'disetujui']) }}">
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
                                                                        <!-- feedback modal content -->
                                                                        <div id="reject-modal" class="modal fade"
                                                                            tabindex="-1" role="dialog"
                                                                            aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">

                                                                                    <div class="modal-body">
                                                                                        <div class="text-center mt-2 mb-4">
                                                                                        </div>

                                                                                        <form class="pl-3 pr-3"
                                                                                            action="{{ route('update-status', ['id' => $item['id'], 'status' => 'ditolak']) }}"
                                                                                            method="POST" id="modal-form">
                                                                                            @csrf
                                                                                            @method('POST')
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="username">Berikan
                                                                                                    Masukan atau
                                                                                                    Saran</label>
                                                                                                <input class="form-control"
                                                                                                    name="feedback"
                                                                                                    required>
                                                                                            </div>
                                                                                            <div
                                                                                                class="form-group text-center">
                                                                                                <button
                                                                                                    class="btn btn-primary"
                                                                                                    type="submit">Kirim</button>
                                                                                            </div>

                                                                                        </form>

                                                                                    </div>
                                                                                </div><!-- /.modal-content -->
                                                                            </div><!-- /.modal-dialog -->
                                                                        </div><!-- /.modal -->
                                                                        <a class="btn btn-info btn-rounded"
                                                                            data-toggle="tooltip" data-placement="left"
                                                                            title="" data-original-title="Detail"
                                                                            href="{{ url('/admin/accpeminjaman/detail/' . $item['id']) }}"><i
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
                                                                <th>Nama Lembaga</th>
                                                                <th>Nama Kegiatan</th>
                                                                <th>Ruangan</th>
                                                                <th>Fasilitas</th>
                                                                <th>Waktu Mulai</th>
                                                                <th>Waktu Selesai</th>
                                                                <th>surat pendukung</th>
                                                                <th>status</th>
                                                                <th>aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            @foreach ($datapmjapprove[0] as $item)
                                                                <tr>
                                                                    <td>{{ $no++ }}</td>
                                                                    <td>{{ $item['nama_user'] }}</td>
                                                                    <td>{{ $item['nama_lembaga'] }}</td>
                                                                    <td>{{ $item['kegiatan'] }}</td>
                                                                    <td>{{ $item['nama_ruangan'] }}</td>
                                                                    <td>
                                                                        @foreach ($datapmjapprove[1] as $itemfasilitas)
                                                                            @if ($itemfasilitas['id_peminjaman']==$item['id'])
                                                                            - {{ $itemfasilitas['nama'] }}: {{ $itemfasilitas['jumlah'] }} <br>
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ date('d-m-Y', strtotime($item['tgl_mulai'])) }}
                                                                        <br>jam:
                                                                        {{ date('H:i', strtotime($item['jam_mulai'])) }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ date('d-m-Y', strtotime($item['tgl_selesai'])) }}
                                                                        <br>jam:
                                                                        {{ date('H:i', strtotime($item['jam_selesai'])) }}
                                                                    </td>
                                                                    <td class="text-center"><a
                                                                            class=" btn btn-circle btn-success"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title=""
                                                                            data-original-title="Unduh Surat Pendukung"
                                                                            href="{{ url('/unduh-file/' . $item['id']) }}"><i
                                                                                class="fa fa-download"></a></td>
                                                                    <td>{{ $item['status'] }}</td>
                                                                    <td>
                                                                        <form method="POST"
                                                                            action="{{ route('update-status', ['id' => $item['id'], 'status' => 'di prosess']) }}">
                                                                            @csrf
                                                                            @method('POST')
                                                                            <button class="btn btn-success btn-rounded"
                                                                                data-toggle="tooltip"
                                                                                data-placement="left" title=""
                                                                                data-original-title="Di Pinjam"
                                                                                type="submit"><i
                                                                                    class="fas fa-check"></i></button>
                                                                        </form>
                                                                        <a class="btn btn-info btn-rounded"
                                                                            data-toggle="tooltip" data-placement="left"
                                                                            title="" data-original-title="Detail"
                                                                            href="{{ url('/admin/accpeminjaman/detail/' . $item['id']) }}"><i
                                                                                class="fas fa-search-plus"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="inprogress">
                                                <div class="table-responsive table-bordered">
                                                    <table class="table">
                                                        <thead class="bg-primary text-white">
                                                            <tr>
                                                                <th>no</th>
                                                                <th>Nama Peminjam</th>
                                                                <th>Nama Lembaga</th>
                                                                <th>Nama Kegiatan</th>
                                                                <th>Ruangan</th>
                                                                <th>Fasilitas</th>
                                                                <th>Waktu Mulai</th>
                                                                <th>Waktu Selesai</th>
                                                                <th>surat pendukung</th>
                                                                <th>status</th>
                                                                <th>aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            @foreach ($datapmjinprogress[0] as $item)
                                                                <tr>
                                                                    <td>{{ $no++ }}</td>
                                                                    <td>{{ $item['nama_user'] }}</td>
                                                                    <td>{{ $item['nama_lembaga'] }}</td>
                                                                    <td>{{ $item['kegiatan'] }}</td>
                                                                    <td>{{ $item['nama_ruangan'] }}</td>
                                                                    <td>

                                                                        @foreach ($datapmjinprogress[1] as $itemfasilitas)
                                                                            @if ($itemfasilitas['id_peminjaman']==$item['id'])
                                                                            - {{ $itemfasilitas['nama'] }}: {{ $itemfasilitas['jumlah'] }} <br>
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ date('d-m-Y', strtotime($item['tgl_mulai'])) }}
                                                                        <br>jam:{{ date('H:i', strtotime($item['jam_mulai'])) }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ date('d-m-Y', strtotime($item['tgl_selesai'])) }}
                                                                        <br>jam:
                                                                        {{ date('H:i', strtotime($item['jam_selesai'])) }}
                                                                    </td>
                                                                    <td class="text-center"><a
                                                                            class=" btn btn-circle btn-success"
                                                                            data-toggle="tooltip" data-placement="bottom"
                                                                            title=""
                                                                            data-original-title="Unduh Surat Pendukung"
                                                                            href="{{ url('/unduh-file/' . $item['id']) }}"><i
                                                                                class="fa fa-download"></a></td>
                                                                    <td>{{ $item['status'] }}</td>
                                                                    <td>
                                                                        <form method="POST"
                                                                            action="{{ route('update-status', ['id' => $item['id'], 'status' => 'selesai']) }}">
                                                                            @csrf
                                                                            @method('POST')
                                                                            <button class="btn btn-success btn-rounded"
                                                                                data-toggle="tooltip"
                                                                                data-placement="left" title=""
                                                                                data-original-title="Selesai"
                                                                                type="submit"><i
                                                                                    class="fas fa-check"></i></button>
                                                                        </form>
                                                                        <a class="btn btn-info btn-rounded"
                                                                            data-toggle="tooltip" data-placement="left"
                                                                            title="" data-original-title="Detail"
                                                                            href="{{ url('/admin/accpeminjaman/detail/' . $item['id']) }}"><i
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
