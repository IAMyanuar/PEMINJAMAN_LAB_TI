@extends('layout.master1')

@section('title')
    SI PIRANG | Ubah Bahan
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
                    <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Ubah Bahan</h3>
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
                                    @if (session()->has('BahanIsExist'))
                                    <div class="alert alert-danger">
                                        <strong>{{ session('BahanIsExist') }}</strong>
                                    </div>
                                    @endif
                                    <form method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label>Nama Bahan</label>
                                            <input type="text" class="form-control" name="nama" value="{{  $data['nama'] }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Satuan</label>
                                            <input type="text" class="form-control" name="satuan" value="{{  $data['satuan'] }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Jumlah</label><br>
                                            <input type="number" class="form-control" name="jumlah" pattern="[0-9]" value="{{  $data['jumlah'] }}" required>
                                        </div>
                                        <button class="btn-primary btn" >Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endsection
