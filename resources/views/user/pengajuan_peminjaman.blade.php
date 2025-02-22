@extends('layout.master2')

@section('title')
    SI PIRANG | Pengajuan Ruangan
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
                    <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Pengajuan Peminjaman</h3>
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

                                <div class="card-body">
                                    <div class="form-actions">
                                        <div class="text-right mb-3">
                                            <a class="btn btn-success btn-rounded" href="{{ url('/AjukanPeminjaman') }}">Ajukan
                                                Peminjaman (+)</a>
                                        </div>
                                    </div>


                                    <div class="table-responsive table-bordered">
                                        <table class="table">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Peminjam</th>
                                                    <th>Nama Lembaga</th>
                                                    <th>Nama Kegiatan</th>
                                                    <th>Ruangan</th>
                                                    <th>Fasilitas</th>
                                                    <th>Waktu Mulai</th>
                                                    <th>Waktu Selesai</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (empty($datapeminjaman))
                                                    <tr>
                                                        <td colspan="10" class="text-center"><strong>
                                                                Anda Belum Mengajukan Ruangan Peminjaman Ruangan
                                                            </strong></td>
                                                    </tr>
                                                @else
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach ($datapeminjaman[0] as $item)
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ $item['nama_user'] }}</td>
                                                            <td>{{ $item['nama_lembaga'] }}</td>
                                                            <td>{{ $item['kegiatan'] }}</td>
                                                            <td>{{ $item['nama_ruangan'] }}</td>
                                                            <td>
                                                                @foreach ($datapeminjaman[1] as $itemfasilitas)
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
                                                            <td>
                                                                @if ($item['status'] == 'terkirim')
                                                                    <text
                                                                        class="text-secondary font-weight-bold">{{ $item['status'] }}</text>
                                                                @elseif ($item['status'] == 'disetujui')
                                                                    <text
                                                                        class="text-success font-weight-bold">{{ $item['status'] }}</text>
                                                                @elseif ($item['status'] == 'di prosess')
                                                                    <text
                                                                        class="text-warning font-weight-bold">{{ $item['status'] }}</text>
                                                                @elseif ($item['status'] == 'selesai')
                                                                    <text
                                                                        class="text-info font-weight-bold">{{ $item['status'] }}</text>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($item['status'] == 'terkirim')
                                                                    <a href="{{ url('/EditPeminjaman/' .  $item['id'] ) }}"
                                                                        class="btn btn-warning btn-rounded"
                                                                        data-toggle="tooltip" data-placement="left"
                                                                        title="" data-original-title="Ubah"><i
                                                                            class="fas fa-edit"></i></a>
                                                                    <form
                                                                        action="{{ route('hapus_pengajuan', $item['id']) }}"
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
                                                                        href="{{ url('/peminjaman/detail/' . $item['id']) }}"><i
                                                                            class="fas fa-search-plus"></i></a>
                                                                @endif

                                                                @if ($item['status'] == 'disetujui')
                                                                    <form
                                                                        action="{{ route('hapus_pengajuan', $item['id']) }}"
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
                                                                        href="{{ url('/peminjaman/detail/' . $item['id']) }}"><i
                                                                            class="fas fa-search-plus"></i></a>
                                                                    {{-- <button type="submit" class="btn btn-success btn-rounded"
                                                                    data-toggle="tooltip" data-placement="left"
                                                                    title="" data-original-title="Bukti Disetujui"><i
                                                                        class="fas fa-clipboard-check"></i></button> --}}
                                                                @endif

                                                                @if ($item['status'] == 'di prosess')
                                                                    <a class="btn btn-info btn-rounded"
                                                                        data-toggle="tooltip" data-placement="left"
                                                                        title="" data-original-title="Detail"
                                                                        href="{{ url('/peminjaman/detail/' . $item['id']) }}"><i
                                                                            class="fas fa-search-plus"></i></a>
                                                                @endif

                                                                @if ($item['status'] == 'selesai')
                                                                    <button type="submit" class="btn btn-info btn-rounded"
                                                                        data-toggle="tooltip" data-placement="left"
                                                                        title="" data-original-title="Masukan/Saran"
                                                                        data-target="#feedback-modal"><i
                                                                            class="fas fa-comment-alt"></i></button>
                                                                    <!-- feedback modal content -->
                                                                    <div id="feedback-modal" class="modal fade"
                                                                        tabindex="-1" role="dialog" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">

                                                                                <div class="modal-body">
                                                                                    <div class="text-center mt-2 mb-4">
                                                                                    </div>

                                                                                    <form class="pl-3 pr-3"
                                                                                        action="{{ route('ulasan', $item['id']) }}"
                                                                                        method="POST" id="modal-form">
                                                                                        @csrf
                                                                                        @method('patch')
                                                                                        <div class="form-group">
                                                                                            <label for="username">Berikan
                                                                                                Masukan atau Saran</label>
                                                                                            <input class="form-control"
                                                                                                name="feedback" required>
                                                                                        </div>
                                                                                        <div
                                                                                            class="form-group text-center">
                                                                                            <button class="btn btn-primary"
                                                                                                type="submit">Kirim</button>
                                                                                        </div>

                                                                                    </form>

                                                                                </div>
                                                                            </div><!-- /.modal-content -->
                                                                        </div><!-- /.modal-dialog -->
                                                                    </div><!-- /.modal -->
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                @endsection
