@extends('dashboard.home')

@section('title', 'Permohonan Surat Magang')

@section('content')

<div class="card mt-3">
    <div class="card-header">
        <h1 class="card-title font-weight-bold">Permohonan Surat Magang</h1>
        <button type="button" class="btn btn-primary float-right btn-sm" data-toggle="modal"
            data-target="#permohonanModal">
            <i class="fa-solid fa-square-plus fa-sm mr-2"></i>Buat Surat
        </button>
    </div>

    <div class="card-body">
        @php
        $heads = [
        ['label' => 'No', 'no-export' => true, 'width' => 1],
        'Tujuan Surat',
        'Alamat Surat',
        'Tanggal Mulai',
        'Tanggal Selesai',
        ['label' => 'Status', 'no-export' => true, 'width' => 10],
        ['label' => 'Aksi', 'no-export' => true, 'width' => 10],
        ];
        @endphp

        <x-adminlte-datatable id="tableMagang" :heads="$heads">
            @forelse ($pengajuan as $key => $detail)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $detail->tujuan_surat }}</td>
                <td>{{ $detail->alamat_surat }}</td>
                <td>{{ $detail->tanggal_mulai }}</td>
                <td>{{ $detail->tanggal_selesai }}</td>
                <td>
                    @switch($detail->status)
                    @case('Diterima')
                    <div class="border border-success btn-sm text-success text-center">{{ $detail->status }}</div>
                    @break
                    @case('Ditolak')
                    <div class="border border-danger btn-sm text-danger text-center">{{ $detail->status }}</div>
                    @break
                    @case('Penerbitan')
                    <div class="border border-primary btn-sm text-primary text-center">{{ $detail->status }}</div>
                    @break
                    @default
                    <div class="border border-warning btn-sm text-warning text-center">{{ $detail->status }}</div>
                    @endswitch
                </td>
                <td>
                    <nobr>
                        @if($detail->status == 'Ditolak')
                        <!-- <button type="button" class="btn btn-default text-warning" data-toggle="modal"
                            data-target="#editPermohonanModal-{{ $detail->id_permohonan_magang }}">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button> -->
                        <button type="button" class="btn border border-primary btn-sm text-primary text-center"
                            data-toggle="modal" data-target="#editPermohonanMagang-{{ $detail->id_permohonan_magang }}">
                            <i class="fa-solid fa-eye"></i> Lihat
                        </button>
                        @elseif($detail->status == 'Penerbitan')
                        @if($detail->filePengajuan && $detail->filePengajuan->isNotEmpty())
                        @foreach ($detail->filePengajuan as $file)
                        <!-- <a href="{{ asset('storage/permohonan-magang/' . basename($file->path)) }}" target="_blank"
                            class="btn btn-default text-primary">
                            <i class="fa-solid fa-download"></i> Lihat File
                        </a> -->
                        <form action="{{ route('unduh-pdf-surat-permohonan-magang') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ encrypt($detail->id_permohonan_magang) }}" name="id">
                            <button class="btn border border-primary btn-sm text-primary text-center" title="Unduh"><i
                                    class="fa-solid fa-download"></i> Unduh</button>
                        </form>
                        @endforeach
                        @else
                        <span class="text-muted"><i>Belum diunggah</i></span>
                        @endif
                        @else
                        <span class="text-muted"><i>Sedang diproses</i></span>
                        @endif
                    </nobr>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-secondary">Tidak ada data</td>
            </tr>
            @endforelse
        </x-adminlte-datatable>

    </div>
</div>

@include('mahasiswa.permohonan-magang.permohonan-modal')
@foreach ($pengajuan as $detail)
@include('mahasiswa.permohonan-magang.edit-permohonan-modal', ['detail' => $detail])
@endforeach

@endsection