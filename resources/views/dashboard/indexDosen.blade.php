@extends('dashboard.home')

@section('title','Dashboard Dosen')

@section('content')
<div class="py-3">
    <div class="mb-4">
        <h2>Hi, {{ $user->nama }}</h2>
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-6">
            <div class="bg-white border border-secondary-subtle rounded shadow-sm">
                <div class="p-4">
                    <h5 style="font-size: 18px; font-weight: 400">Permohonan Pengambilan Data Penelitian</h5>
                    <div class="d-flex justify-content-between mt-3">
                        <span class="lead" style="font-weight: 500">{{ $dataPenelitian }} Surat</span>
                        <a href="{{ route('ppdp-dosen') }}" class="btn btn-primary btn-sm">Detail</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="bg-white border border-secondary-subtle rounded shadow-sm">
                <div class="p-4">
                    <h5 style="font-size: 18px; font-weight: 400">Pengajuan Kerja Praktik</h5>
                    <div class="d-flex justify-content-between mt-3">
                        <span class="lead" style="font-weight: 500">{{ $dataKP }} Surat</span>
                        <a href="{{ route('pengajuan-kp-koordinator') }}" class="btn btn-primary btn-sm">Detail</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="bg-white border border-secondary-subtle rounded shadow-sm">
                <div class="p-4">
                    <h5 style="font-size: 18px; font-weight: 400">Pengajuan Transkrip Nilai Sementara</h5>
                    <div class="d-flex justify-content-between mt-3">
                        <span class="lead" style="font-weight: 500">{{ $dataTranskrip }} Surat</span>
                        <a href="{{ route('transkrip-wd') }}" class="btn btn-primary btn-sm">Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
