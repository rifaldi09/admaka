@extends('dashboard.home')

@section('title','Dashboard Mahasiswa')

@section('content')
<div class="py-3">
    <div class="mb-4">
        <h2>Hi, {{ $user->nama }}</h2>
    </div>
    <div class="row mb-5">
        <div class="col-xl-3 col-md-6 col-lg-4 mb-3">
            <div class="bg-white border border-warning rounded shadow-sm">
                <div class="p-4">
                    <h5 class="mb-3" style="font-size: 18px; font-weight: 400">Status Belum Diterima</h5>
                    <span class="lead" style="font-weight: 500">{{ $belumDiterima }} Surat</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-lg-4 mb-3">
            <div class="bg-white border border-success rounded shadow-sm">
                <div class="p-4">
                    <h5 class="mb-3" style="font-size: 18px; font-weight: 400">Status Diterima</h5>
                    <span class="lead" style="font-weight: 500">{{ $dataDiterima }} Surat</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-lg-4 mb-3">
            <div class="bg-white border border-danger rounded shadow-sm">
                <div class="p-4">
                    <h5 class="mb-3" style="font-size: 18px; font-weight: 400">Status Ditolak</h5>
                    <span class="lead" style="font-weight: 500">{{ $dataDitolak }} Surat</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-lg-4 mb-3">
            <div class="bg-white border border-primary rounded shadow-sm">
                <div class="p-4">
                    <h5 class="mb-3" style="font-size: 18px; font-weight: 400">Status Penerbitan</h5>
                    <span class="lead" style="font-weight: 500">{{ $dataPenerbitan }} Surat</span>
                </div>
            </div>
        </div>
    </div>
    <div>
        <h5 class="mb-3" style="font-size: 20px; font-weight: 500">Data Penerbitan Surat Terbaru</h5>
        <div class="row">
            @forelse ($suratTerbaru as $surat)
                <div class="col-md-6 mb-3">
                    <div class="bg-white border border-primary rounded shadow-sm">
                        <div class="px-4 pt-4 pb-2">
                            <h5 style="font-size: 18px; font-weight: 500">{{ $surat->jenis_surat }}</h5>
                        </div>
                        <ul class="list-group pb-4">
                            <li class="list-group-item d-flex justify-content-between">Tanggal Pembuatan Surat : <span>{{ $surat->created_at->format('d M Y H:i') }}</span></li>
                            <li class="list-group-item d-flex justify-content-between">Tanggal Penerbitan Surat : <span>{{ $surat->updated_at->format('d M Y H:i') }}</span></li>
                        </ul>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="bg-white border border-danger rounded shadow-sm">
                        <div class="p-4 text-center">
                            <h5 style="font-size: 18px; font-weight: 500">Tidak Ada Data</h5>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
