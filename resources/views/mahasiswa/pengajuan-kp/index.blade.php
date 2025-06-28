@extends('dashboard.home')

@section('title', 'Pengajuan Kerja Praktik')

@section('content')

<div class="card mt-3">
    <div class="card-header">
        <h1 class="card-title font-weight-bold">Pengajuan Kerja Praktik</h1>
        <button type="button" class="btn btn-primary float-right btn-sm" data-toggle="modal"
            data-target="#pengajuanModal">
            <i class="fa-solid fa-square-plus fa-sm mr-2"></i>Ajukan Surat Baru
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

        <x-adminlte-datatable id="tablePengajuanKP" :heads="$heads">
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
                        <button type="button" class="btn border border-primary btn-sm text-primary text-center"
                            data-toggle="modal" data-target="#editPengajuanModal-{{ $detail->id_pengajuan }}">
                            <i class="fa-solid fa-eye"></i> Lihat
                        </button>
                        @elseif($detail->status == 'Penerbitan')
                        @if($detail->filePengajuan && $detail->filePengajuan->isNotEmpty())
                        @foreach ($detail->filePengajuan as $file)
                        <form action="{{ route('unduh-pdf-surat-kp') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ encrypt($detail->id_pengajuan) }}" name="id">
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

@include('mahasiswa.pengajuan-kp.pengajuan-modal')
@foreach ($pengajuan as $detail)
@include('mahasiswa.pengajuan-kp.edit-pengajuan-modal', ['detail' => $detail])
@endforeach

@endsection