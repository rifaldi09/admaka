@extends('dashboard.home')

@section('title', 'Transkrip Nilai Sementara')

@section('content')

<div class="card mt-3">
    <div class="card-header">
        <h1 class="card-title font-weight-bold">Transkrip Nilai Sementara</h1>
        <button type="button" class="btn btn-primary float-right btn-sm" data-toggle="modal"
            data-target="#transkripModal">
            <i class="fa-solid fa-square-plus fa-sm mr-2"></i>Buat Transkrip
        </button>
    </div>

    <div class="card-body">
        @php
        $heads = [
        ['label' => 'No', 'no-export' => true, 'width' => 1],
        'Keperluan',
        ['label' => 'Status', 'no-export' => true, 'width' => 10],
        ['label' => 'Aksi', 'no-export' => true, 'width' => 10],
        ];
        @endphp

        <x-adminlte-datatable id="tableTranskrip" :heads="$heads">
            @forelse ($transkrip as $key => $detail)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $detail->keperluan }}</td>
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
                        @if ($detail->status == 'Penerbitan')
                        @if($detail->filePermohonan && $detail->filePermohonan->isNotEmpty())
                        @foreach ($detail->filePermohonan as $file)
                        <a href="{{ asset('storage/transkrip/' . basename($file->path)) }}" target="_blank"
                            class="btn btn-default text-primary">
                            <i class="fa-solid fa-download"></i> Lihat File
                        </a>
                        @endforeach
                        @else
                        <span class="text-muted"><i>Belum diunggah</i></span>
                        @endif
                        @elseif ($detail->status == 'Ditolak')
                        <button class="btn border border-primary btn-sm text-primary text-center" data-toggle="modal"
                            data-target="#editTranskripModal-{{ $detail->id_transkrip }}" title="Alasan"> <i
                                class="fa-solid fa-eye"></i> Lihat
                        </button>
                        <!-- <button type="button" class="btn btn-default text-warning btn-edit" data-toggle="modal"
                            data-target="#editTranskripModal-{{ $detail->id_transkrip }}">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button> -->
                        @else
                        <span class="text-muted"><i>Sedang diproses</i></span>
                        @endif
                    </nobr>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-secondary text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </x-adminlte-datatable>
    </div>
</div>

@include('mahasiswa.transkrip-nilai.modal.create')
@foreach ($transkrip as $detail)
@include('mahasiswa.transkrip-nilai.modal.edit', ['detail' => $detail])
@endforeach

@endsection