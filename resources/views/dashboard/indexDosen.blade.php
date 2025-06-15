@extends('dashboard.home')

@section('title','Dashboard Dosen')

@section('content')
<div class="py-3">
    <div class="mb-4">
        <h2>Hi, {{ $user->nama }}</h2>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Surat Permohonan Pengambilan Data Penelitian</h5>
                    <p class="card-text">100 Surat</p>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Surat Pengajuan Kerja Praktik</h5>
                    <p class="card-text">100 Surat</p>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Surat Pengajuan Transkrip Nilai Sementara</h5>
                    <p class="card-text">100 Surat</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
