@extends('dashboard.home')

@section('title', 'Surat Rekomendasi')

@section('content')

<div class="card mt-3">
    <div class="card-header">
        <h1 class="card-title font-weight-bold">Surat Rekomendasi</h1>
    </div>
    <div class="card-body">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button"
                    role="tab" aria-controls="home" aria-selected="true">Surat Masuk</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button"
                    role="tab" aria-controls="profile" aria-selected="false">Surat Disetujui</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="mt-3">

                    {{-- table untuk surat yang masih belum disetujui --}}
                    @php
                    $heads = [
                    ['label' => 'NIM', 'no-export' => true, 'width' => 10],
                    'Nama',
                    'Prodi',
                    ['label' => 'Status', 'no-export' => true, 'width' => 5],
                    'Tanggal Pengajuan',
                    ['label' => 'Actions', 'no-export' => true, 'width' => 7],
                    ];

                    @endphp

                    <x-adminlte-datatable id="table1" :heads="$heads">
                        @foreach ($dataSurat as $data)
                        @if ($data->status == 'Belum Diterima')
                        <tr>
                            <td>{{ $data->user->dataMahasiswa->nim }}</td>
                            <td>{{ $data->user->dataMahasiswa->nama }}</td>
                            <td>{{ $data->user->dataMahasiswa->prodi->nama }}</td>
                            <td>
                                <div class="border border-warning btn-sm text-warning text-center">
                                    {{ $data->status }}</div>
                            </td>
                            <td>{{ $data->created_at }}</td>
                            <td>
                                <nobr>
                                    <button class="btn btn-primary btn-edit btn-sm mr-3" title="Detail"
                                        data-toggle="modal"
                                        data-target="#detailRekomendasi-{{ $data->id_rekomendasi }}">
                                        <i class="fa-solid fa-eye"></i> Lihat
                                    </button>
                                    <button class="btn btn-danger btn-tolak btn-sm" data-toggle="modal"
                                        data-target="#tolakRekomendasi-{{ $data->id_rekomendasi }}" title="Tolak">
                                        <i class="fa-solid fa-circle-info"></i> Tolak
                                    </button>
                                </nobr>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>

            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="mt-3">

                    {{-- table untuk surat yang sudah disetujui/ditolak --}}
                    @php
                    $heads = [
                    ['label' => 'NIM', 'no-export' => true, 'width' => 10],
                    'Nama',
                    'Prodi',
                    ['label' => 'Status', 'no-export' => true, 'width' => 3],
                    'Tanggal Pengajuan',
                    ['label' => 'Actions', 'no-export' => true, 'width' => 7],
                    'Upload Surat',
                    ];
                    @endphp

                    <x-adminlte-datatable id="table2" :heads="$heads">
                        @foreach ($dataSurat as $data)
                        @if ($data->status != 'Belum Diterima')
                        <tr>
                            <td>{{ $data->user->dataMahasiswa->nim }}</td>
                            <td>{{ $data->user->dataMahasiswa->nama }}</td>
                            <td>{{ $data->user->dataMahasiswa->prodi->nama }}</td>
                            <td>
                                @if ($data->status == 'Diterima')
                                <div class="border border-success btn-sm text-success text-center">
                                    {{ $data->status }}</div>
                                @elseif ($data->status == 'Penerbitan')
                                <div class="border border-primary btn-sm text-primary text-center">
                                    {{ $data->status }}</div>
                                @else
                                <div class="border border-danger btn-sm text-danger text-center">
                                    {{ $data->status }}</div>
                                @endif
                            </td>
                            <td>{{ $data->created_at }}</td>
                            <td>
                                <nobr>
                                    <button class="btn btn-primary btn-detail-terima btn-sm mr-3" data-toggle="modal"
                                        data-target="#modalDetailTerima-{{ $data->id_rekomendasi }}" title="Detail">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>
                                    @if ($data->status != 'Ditolak')
                                    @if ($data->status == 'Penerbitan')
                                    <a href="{{ route('penerbitan-surat-rekomendasi', encrypt($data->id_rekomendasi)) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-download"></i>
                                        Generate
                                    </a>
                                    <!-- 
                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#penerbitanSurat-{{ $data->id_rekomendasi }}" title="Terbitkan"
                                        type="button">
                                        <i class="fa-solid fa-download"></i>
                                        Terbitkan
                                    </button> -->
                                    @endif
                                    @endif
                                </nobr>
                            </td>
                            <td>
                                <nobr>
                                    @if ($data->status == 'Penerbitan')
                                    <button class="btn btn-success btn-sm btn-upload" data-toggle="modal"
                                        data-target="#modalUpload-{{ $data->id_rekomendasi }}" title="Upload">
                                        <i class="fa-solid fa-upload"></i> Upload
                                    </button>
                                    @endif
                                </nobr>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </x-adminlte-datatable>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- modal --}}
@foreach ($dataSurat as $data)
@if ($data->status != 'Belum Diterima')
@include('admin.surat-rekomendasi.modal.detailDiterima', [
'id' => $data->id_rekomendasi,
])
@include('admin.surat-rekomendasi.modal.upload', [
'id' => $data->id_rekomendasi,
])
@include('admin.surat-rekomendasi.modal.penerbitanSurat', [
'id' => $data->id_rekomendasi,
])
@else
@include('admin.surat-rekomendasi.modal.tolak', [
'id' => $data->id_rekomendasi,
])
@include('admin.surat-rekomendasi.modal.detail', [
'id' => $data->id_rekomendasi,
])
@endif
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Sweet Alert
    $(document).on('click', '.btn-setujui, .tolak', function(e) {
        e.preventDefault();
        const form = $(this).closest('form')[0];
        const isApprove = $(this).hasClass('btn-setujui');

        // Validation for reject form
        if (!isApprove && !form.checkValidity()) {
            form.reportValidity();
            return;
        }

        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: isApprove ? '#14A44D' : '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: isApprove ? 'Ya, setujui suratnya' : 'Ya, tolak suratnya',
            cancelButtonText: 'Batal'
        }).then((result) => result.isConfirmed && form.submit());
    });

    $(document).on('click', '.penerbitan', function(e) {
        e.preventDefault();
        const form = $(this).closest('form')[0];
        const isApprove = $(this).hasClass('.penerbitan');

        // Validation for reject form
        if (!isApprove && !form.checkValidity()) {
            form.reportValidity();
            return;
        }

        Swal.fire({
            title: 'Mau di Terbitkan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#14A44D',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Batal'
        }).then((result) => result.isConfirmed && form.submit());
    });
});
</script>

@endsection