@extends('dashboard.home')

@section('title','Dashboard Dosen')

@section('content')
<div class="py-3">
    <div class="mb-4">
        <h2>Hi, {{ $user->nama }}</h2>
    </div>
    <div class="row mb-5">
        <div class="col-xl-4 col-lg-6">
            <div class="bg-white border border-secondary-subtle rounded shadow-sm">
                <div class="p-4">
                    <h5 class="mb-3" style="font-size: 18px; font-weight: 400">Pengajuan Pengambilan Data Penelitian</h5>
                    <span class="lead" style="font-weight: 500">{{ $dataPenelitian }} Surat</span>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="bg-white border border-secondary-subtle rounded shadow-sm">
                <div class="p-4">
                    <h5 class="mb-3" style="font-size: 18px; font-weight: 400">Pengajuan Kerja Praktik</h5>
                    <span class="lead" style="font-weight: 500">{{ $dataKP }} Surat</span>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="bg-white border border-secondary-subtle rounded shadow-sm">
                <div class="p-4">
                    <h5 class="mb-3" style="font-size: 18px; font-weight: 400">Pengajuan Transkrip Nilai</h5>
                    <span class="lead" style="font-weight: 500">{{ $dataTranskrip }} Surat</span>
                </div>
            </div>
        </div>
    </div>
    <div>
        <h5 class="mb-3" style="font-size: 20px; font-weight: 500">Data Pengajuan Surat Terbaru</h5>
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Jenis Pengajuan Surat</th>
                    <th scope="col">Nama Mahasiswa</th>
                    <th scope="col">Tanggal Pengajuan</th>
                    <th scope="col">Status Surat</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suratPengajuanTerbaru as $surat)
                <tr>
                    <td>{{ $surat->jenis_surat }}</td>
                    <td>{{ $surat->user->dataMahasiswa->nama }}</td>
                    <td>{{ $surat->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $surat->status }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak Ada Data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
