@extends('dashboard.home')

@section('title','Dashboard Admin')

@section('content')
<div class="py-3">
    <div class="mb-4">
        <h2>Hi, Admin</h2>
    </div>
    <div class="row">
        <div class="col">
            <div class="bg-white border border-secondary-subtle rounded shadow-sm">
                <div class="p-4">
                    <h5 style="font-size: 20px; font-weight: 500">Data Surat</h5>
                    <div class="row mt-3">
                        <div class="col-md-6 col-sm-12">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Aktif Kuliah
                                <div class="d-flex justify-content-end align-items-center">
                                    <span style="font-size: 15px; font-weight:700">{{ $dataAktif }} Surat</span>
                                    <span class="mx-2" style="border-left:1px solid black; height:30px; display:inline-block;"></span>
                                    <a href="{{ route('Administrator/aktif-kuliah') }}" class="btn btn-primary btn-sm">Detail</a>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Pengajuan Kerja Praktik
                                <div class="d-flex justify-content-end align-items-center">
                                    <span style="font-size: 15px; font-weight:700">{{ $dataKP }} Surat</span>
                                    <span class="mx-2" style="border-left:1px solid black; height:30px; display:inline-block;"></span>
                                    <a href="{{ route('pengajuan_kp_admin') }}" class="btn btn-primary btn-sm">Detail</a>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Permohonan Pengambilan Data Penelitian
                                <div class="d-flex justify-content-end align-items-center">
                                    <span style="font-size: 15px; font-weight:700">{{ $dataPenelitian }} Surat</span>
                                    <span class="mx-2" style="border-left:1px solid black; height:30px; display:inline-block;"></span>
                                    <a href="{{ route('ppdp-admin') }}" class="btn btn-primary btn-sm">Detail</a>
                                </div>
                            </li>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Permohonan Magang
                                <div class="d-flex justify-content-end align-items-center">
                                    <span style="font-size: 15px; font-weight:700">{{ $dataMagang }} Surat</span>
                                    <span class="mx-2" style="border-left:1px solid black; height:30px; display:inline-block;"></span>
                                    <a href="{{ route('permohonan-magang-admin') }}" class="btn btn-primary btn-sm">Detail</a>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Surat Rekomendasi
                                <div class="d-flex justify-content-end align-items-center">
                                    <span style="font-size: 15px; font-weight:700">{{ $dataRekomendasi }} Surat</span>
                                    <span class="mx-2" style="border-left:1px solid black; height:30px; display:inline-block;"></span>
                                    <a href="{{ route('surat-rekomendasi-admin') }}" class="btn btn-primary btn-sm">Detail</a>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Transkrip Nilai Sementara
                                <div class="d-flex justify-content-end align-items-center">
                                    <span style="font-size: 15px; font-weight:700">{{ $dataTranskrip }} Surat</span>
                                    <span class="mx-2" style="border-left:1px solid black; height:30px; display:inline-block;"></span>
                                    <a href="{{ route('transkrip-admin') }}" class="btn btn-primary btn-sm">Detail</a>
                                </div>
                            </li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
