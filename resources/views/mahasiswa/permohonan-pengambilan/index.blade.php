@extends('dashboard.home')

@section('title', 'Permohonan Pengambilan Data')

@section('content')

<div class="card mt-3">
    <div class="card-header">
        <h1 class="card-title font-weight-bold">Permohonan Pengambilan Data</h1>
        <button type="button" class="btn btn-primary float-right btn-sm" data-toggle="modal"
            data-target="#permohonanModal">
            <i class="fa-solid fa-square-plus fa-sm mr-2"></i>Buat Permohonan
        </button>
    </div>

    <div class="card-body">
        @php
        $heads = [
        ['label' => 'No', 'no-export' => true, 'width' => 1],
        'Tujuan Surat',
        'Alamat Surat',
        'Keperluan',
        'Tanggal Mulai',
        'Tanggal Selesai',
        ['label' => 'Status', 'no-export' => true, 'width' => 10],

        ['label' => 'Aksi', 'no-export' => true, 'width' => 10],
        ];
        @endphp

        <x-adminlte-datatable id="tablePermohonan" :heads="$heads">
            @forelse ($permohonan as $key => $detail)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $detail->tujuan_surat }}</td>
                <td>{{ $detail->alamat_surat }}</td>
                <td>{{ $detail->keperluan == 'mata_kuliah' ? 'Mata Kuliah' : 'Skripsi' }}</td>
                <td>{{ \Carbon\Carbon::parse($detail->tanggal_mulai)->translatedFormat('j F Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($detail->tanggal_selesai)->translatedFormat('j F Y') }}</td>
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
                        <!-- <a href="{{ asset('storage/permohonan-pengambilan/' . basename($file->path)) }}" target="_blank"
                            class="btn btn-default text-primary">
                            <i class="fa-solid fa-download"></i> Lihat File
                        </a> -->
                        <form action="{{ route('unduh-pdf-surat-permohonan') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ encrypt($detail->id_permohonan) }}" name="id">
                            <button class="btn border border-primary btn-sm text-primary text-center" title="Unduh"><i
                                    class="fa-solid fa-download"></i> Unduh</button>
                        </form>
                        @endforeach
                        @else
                        <span class="text-muted"><i>Belum diunggah</i></span>
                        @endif
                        @elseif ($detail->status == 'Ditolak')
                        <!-- <button type="button" class="btn btn-default text-warning btn-edit" data-toggle="modal"
                            data-target="#editPermohonanModal-{{ $detail->id_permohonan }}">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button> -->
                        <button type="button" class="btn border border-primary btn-sm text-primary text-center"
                            data-toggle="modal" data-target="#editPermohonanModal-{{ $detail->id_permohonan }}">
                            <i class="fa-solid fa-eye"></i> Lihat
                        </button>
                        @else
                        <span class="text-muted"><i>Sedang diproses</i></span>
                        @endif
                    </nobr>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-secondary text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </x-adminlte-datatable>

    </div>
</div>

@include('mahasiswa.permohonan-pengambilan.modal.create-permohonan-modal')
@foreach ($permohonan as $detail)
@include('mahasiswa.permohonan-pengambilan.modal.edit-permohonan-modal', ['detail' => $detail])
@endforeach

@endsection