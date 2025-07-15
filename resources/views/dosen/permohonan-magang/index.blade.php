@extends('dashboard.home')

@section('title', 'Pengajuan Magang')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h1 class="card-title font-weight-bold">Pengajuan Magang yang Diterima</h1>
    </div>

    <div class="card-body">
        @php
        $heads = [
        ['label' => 'No', 'no-export' => true, 'width' => 5],
        ['label' => 'Nama Mahasiswa', 'width' => 50],
        ['label' => 'Aksi', 'no-export' => true, 'width' => 45],
        ];
        @endphp

        <x-adminlte-datatable id="magangDiterimaTable" :heads="$heads" class="table-bordered table-hover">
            @php $no = 1;@endphp
            @forelse ($diterima as $data)
            @foreach ($data->permohonanMagang as $magang)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $data->dataMahasiswa->nama }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-danger mr-2" data-toggle="modal"
                            data-target="#tolakModal-{{ $magang->id_permohonan_magang }}">
                            <i class="fa-solid fa-xmark mr-1"></i> Tolak
                        </button>
                        @include('dosen.modal.tolak-modal', ['id' => $magang->id_permohonan_magang, 'route' =>
                        'tolak-permohonan-magang'])

                        <form action="{{ route('penerbitan-permohonan-magang', $magang->id_permohonan_magang) }}"
                            method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success mr-2">
                                <i class="fa-solid fa-check mr-1"></i> Terbitkan
                            </button>
                        </form>

                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                            data-target="#detailPermohonanMagangModal-{{ $magang->id_permohonan_magang }}">
                            <i class="fa-solid fa-circle-info mr-1"></i> Detail
                        </button>
                        @include('admin.permohonan-magang.modal.detail-pm', ['id' => $magang->id_permohonan_magang])
                    </div>
                </td>
            </tr>
            @endforeach
            @empty
            <tr>
                <td colspan="3" class="text-center text-secondary py-3">Tidak ada data</td>
            </tr>
            @endforelse
        </x-adminlte-datatable>
    </div>
</div>
@endsection