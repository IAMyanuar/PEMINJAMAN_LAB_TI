@extends('layout.master1')

@section('title')
    SI PIRANG | Data Alat
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
                    <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Alat</h3>
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
                                    <div class="form-actions">
                                        <div class="text-right  mb-3">
                                            <a href="{{ url('/admin/DataAlat/TambahAlat')}}" type="button"
                                                class="btn btn-outline-primary btn-rounded"><i class="icon-plus"></i> Tambah
                                                Alat</a>
                                        </div>
                                    </div>


                                    <div class="table-responsive table-bordered">
                                        <table class="table">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Alat</th>
                                                    <th>Satuan</th>
                                                    <th>Jumlah</th>
                                                    <th>Foto</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @php
                                                    $no = 1;
                                                @endphp
                                                @if (empty($data))
                                                    <tr>
                                                        <td colspan="10" class="text-center"><strong>Tidak ada
                                                                data alat</strong></td>
                                                    </tr>
                                                @endif
                                                @foreach ($data as $item)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $item['nama'] }}</td>
                                                        <td>{{ $item['satuan'] }}</td>
                                                        <td>
                                                            Jumlah: {{ $item['jumlah'] }}
                                                        </td>
                                                        <td><img src="{{ $item['foto'] }}" width="100"></td>
                                                        <td>
                                                            <a href="{{ url('/admin/DataAlat/EditAlat/' . $item['id']) }}"
                                                                class="btn btn-rounded btn-warning text-white" data-toggle="tooltip" data-placement="left"
                                                                title="" data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                                            <form
                                                                action="{{ route('hapus_alat', $item['id']) }}" method="POST" onsubmit="return confirmDelete('{{ $item['nama'] }}');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button href="{{ url('/admin/DataAlat/HapusAlat/' . $item['id']) }}"
                                                                class="btn btn-rounded btn-danger text-white" data-toggle="tooltip" data-placement="right"
                                                                title="" data-original-title="hapus"><i class="fas fa-trash"></i></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <script>
                                        function confirmDelete(namaAlat) {
                                            return confirm("Apakah Anda yakin ingin menghapus bahan '" + namaAlat + "'?");
                                        }
                                    </script>
                                @endsection
