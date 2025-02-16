@extends('layout.master2')

@section('title')
    SI PIRANG | Form Pengajuan Alat & Bahan
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
                    <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Ajukan Peminjaman Alat Dan Bahan
                    </h3>
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
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @elseif (session()->has('error'))
                                    <div class="alert alert-danger">
                                        <strong>{{ session('error') }}</strong>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <form action="{{ route('ajukan_alat_bahan') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label>Kelas</label>
                                            <input type="text" class="form-control" name="kelas"
                                                placeholder="Contoh: 1A-TRPL">
                                        </div>
                                        <div class="form-group">
                                            <label>PIC-Dosen Pengampu</label>
                                            <input type="text" class="form-control" name="pic">
                                        </div>
                                        <div id="alat">
                                            <div class="row alat-row">
                                                <div class="form-group col-md-7">
                                                    <label>Alat</label>
                                                    <select class="form-control" name="alat[]">
                                                        <option value="">Pilih Alat</option>
                                                        @foreach ($alat as $dataAlat)
                                                            <option value="{{ $dataAlat['id'] }}">
                                                                {{ $dataAlat['nama'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label>Jumlah</label>
                                                    <input type="number" class="form-control" name="jumlah_alat[]">
                                                </div>
                                                <div class="p-4">
                                                    <button type="button" class="btn btn-circle btn-primary"
                                                        id="tambahalat"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="bahan">
                                            <div class="row bahan-row">
                                                <div class="form-group col-md-7">
                                                    <label>Bahan</label>
                                                    <select class="form-control" name="bahan[]">
                                                        <option value="">Pilih Bahan</option>
                                                        @foreach ($bahan as $dataBahan)
                                                            <option value="{{ $dataBahan['id'] }}">
                                                                {{ $dataBahan['nama'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label>Jumlah</label>
                                                    <input type="number" class="form-control" name="jumlah_bahan[]">
                                                </div>
                                                <div class="p-4">
                                                    <button type="button" class="btn btn-circle btn-primary"
                                                        id="tambahbahan"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Waktu Pinjam</label>
                                            <input type="datetime-local" class="form-control" name="tgl_pinjam">
                                        </div>
                                        <div class="form-group">
                                            <label>Waktu Selesai</label>
                                            <input type="datetime-local" class="form-control" name="tgl_selesai">
                                        </div>
                                        <button class="btn-primary btn" type="submit">Simpan</button>
                                    </form>
                                </div>
                            @endsection


                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    $('#tambahalat').click(function() {
                                        var alatRow = `
                                                            <div class="row alat-row">
                                                                <div class="form-group col-md-7">
                                                                    <label>Alat</label>
                                                                    <select class="form-control" name="alat[]">
                                                                        <option value="">Pilih Alat</option>
                                                                        @foreach ($alat as $dataAlat)
                                                                            <option value="{{ $dataAlat['id'] }}">{{ $dataAlat['nama'] }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label>Jumlah</label>
                                                                    <input type="number" class="form-control" name="jumlah_alat[]">
                                                                </div>
                                                                <div class="p-4">
                                                                    <button class="btn btn-circle btn-danger remove-alat"><i class="fas fa-minus"></i></button>
                                                                </div>
                                                            </div>`;
                                        $('#alat').append(alatRow);
                                    });

                                    $(document).on('click', '.remove-alat', function() {
                                        $(this).closest('.alat-row').remove();
                                    });
                                });
                                $(document).ready(function() {
                                    $('#tambahbahan').click(function() {
                                        var alatRow = `
                                                            <div class="row bahan-row">
                                                                <div class="form-group col-md-7">
                                                                    <label>Bahan</label>
                                                                    <select class="form-control" name="bahan[]">
                                                                        <option value="">Pilih Bahan</option>
                                                                        @foreach ($bahan as $dataBahan)
                                                                            <option value="{{ $dataBahan['id'] }}">{{ $dataBahan['nama'] }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label>Jumlah</label>
                                                                    <input type="number" class="form-control" name="jumlah_bahan[]">
                                                                </div>
                                                                <div class="p-4">
                                                                    <button class="btn btn-circle btn-danger remove-bahan"><i class="fas fa-minus"></i></button>
                                                                </div>
                                                            </div>`;
                                        $('#bahan').append(alatRow);
                                    });

                                    $(document).on('click', '.remove-bahan', function() {
                                        $(this).closest('.bahan-row').remove();
                                    });
                                });
                            </script>
