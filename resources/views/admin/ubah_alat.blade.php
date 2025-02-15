@extends('layout.master1')

@section('title')
    SI PIRANG | Ubah Alat
@stop

@section('css')

@stop

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-7 align-self-center">
                    <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Ubah Alat</h3>
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
                        <p><span class="form-control bg-white border-0 custom-shadow custom-radius" id="tanggalwaktu"></span></p>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    @if (session()->has('AlatIsExist'))
                                    <div class="alert alert-danger">
                                        <strong>{{ session('AlatIsExist') }}</strong>
                                    </div>
                                    @endif

                                    <form action="{{ url('/admin/DataAlat/EditAlat/' . $data['id']) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT') {{-- Ubah menjadi PUT agar sesuai dengan route --}}

                                        <div class="form-group">
                                            <label>Nama Alat</label>
                                            <input type="text" class="form-control" name="nama" value="{{  $data['nama'] }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Satuan</label>
                                            <input type="text" class="form-control" name="satuan" value="{{  $data['satuan'] }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Jumlah</label>
                                            <input type="number" class="form-control" name="jumlah" pattern="[0-9]" value="{{ $data['jumlah'] }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Foto:</label><br>
                                            <img src="{{ asset($data['foto']) }}" alt="Foto Alat" width="250px">
                                        </div>

                                        <div class="form-group">
                                            <label>Upload Foto Baru:</label>
                                            <input type="file" class="form-control" name="foto">
                                        </div>

                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection
