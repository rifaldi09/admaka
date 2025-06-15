@extends('dashboard.home')

@section('title', 'Surat Permohonan Pengambilan Data')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h1 class="card-title font-weight-bold">Surat Permohonan Pengambilan Data</h1>
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
                        @php
                            $heads = [
                                ['label' => 'NIM', 'no-export' => true, 'width' => 10],
                                'Nama',
                                'Prodi',
                                'Keperluan',
                                ['label' => 'Status', 'no-export' => true, 'width' => 5],
                                'Tanggal Pengajuan',
                                ['label' => 'Actions', 'no-export' => true, 'width' => 7],
                            ];
                        @endphp

                        <x-adminlte-datatable id="table1" :heads="$heads">
                            @foreach ($draft as $data)
                                @foreach ($data->permohonanPengambilan as $pp)
                                    @if ($pp->status == 'Belum Diterima')
                                        <tr>
                                            <td>{{ $data->dataMahasiswa->nim }}</td>
                                            <td>{{ $data->dataMahasiswa->nama }}</td>
                                            <td>{{ $data->dataMahasiswa->prodi->nama }}</td>
                                            <td>{{ $pp->keperluan == 'mata_kuliah' ? 'Mata Kuliah' : 'Skripsi' }}</td>
                                            <td>
                                                <div class="border border-warning btn-sm text-warning text-center">
                                                    {{ $pp->status }}</div>
                                            </td>
                                            <td>{{ $pp->created_at }}</td>
                                            <td>
                                                <nobr>
                                                    <button class="btn btn-primary btn-edit btn-sm mr-3" title="Detail"
                                                        data-toggle="modal"
                                                        data-target="#detailModal-{{ $pp->id_permohonan }}">
                                                        <i class="fa-solid fa-eye"></i> Lihat
                                                    </button>
                                                    @include('admin.permohonan-pengambilan.modal.detail-pp', [
                                                        'id' => $pp->id_permohonan,
                                                    ])
                                                    <form action="{{ route('terima-permohonan-mahasiswa', $pp->id_permohonan) }}" class="d-inline" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="btn btn-success btn-setujui btn-sm" title="Setujui" type="submit">
                                                            <i class="fa-solid fa-check"></i> Setujui
                                                        </button>
                                                    </form>
                                                </nobr>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
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
                                'Keperluan',
                                ['label' => 'Status', 'no-export' => true, 'width' => 3],
                                'Tanggal Pengajuan',
                                ['label' => 'Actions', 'no-export' => true, 'width' => 7],
                                'Upload Surat',
                            ];
                        @endphp

                        <x-adminlte-datatable id="table2" :heads="$heads">
                            @foreach ($diterima as $data)
                                @foreach ($data->permohonanPengambilan as $pp)
                                    @if ($pp->status != 'Belum Diterima')
                                        <tr>
                                            <td>{{ $data->dataMahasiswa->nim }}</td>
                                            <td>{{ $data->dataMahasiswa->nama }}</td>
                                            <td>{{ $data->dataMahasiswa->prodi->nama }}</td>
                                            <td>{{ $pp->keperluan == 'mata_kuliah' ? 'Mata Kuliah' : 'Skripsi' }}</td>
                                            <td>
                                                @if ($pp->status == 'Diterima')
                                                    <div class="border border-success btn-sm text-success text-center">
                                                        {{ $pp->status }}</div>
                                                @elseif ($pp->status == 'Penerbitan')
                                                    <div class="border border-primary btn-sm text-primary text-center">
                                                        {{ $pp->status }}</div>
                                                @endif
                                            </td>
                                            <td>{{ $pp->created_at }}</td>
                                            <td>
                                                <nobr>
                                                    <button class="btn btn-primary btn-detail-terima btn-sm mr-3"
                                                        data-toggle="modal"
                                                        data-target="#detailModal-{{ $pp->id_permohonan }}"
                                                        title="Detail">
                                                        <i class="fa-solid fa-eye"></i> Detail
                                                    </button>
                                                    @include('admin.permohonan-pengambilan.modal.detail-pp', [
                                                        'id' => $pp->id_permohonan,
                                                    ])
                                                    @if ($pp->status != 'Ditolak')
                                                        @if ($pp->status == 'Penerbitan')
                                                            <a href="{{ route('generate-permohonan', $pp->id_permohonan) }}" class="btn btn-primary btn-sm">
                                                                <i class="fa-solid fa-download"></i>
                                                                Generate
                                                            </a>
                                                        @endif
                                                    @endif
                                                </nobr>
                                            </td>
                                            <td>
                                                <nobr>
                                                    @if ($pp->status == 'Penerbitan')
                                                        <button class="btn btn-success btn-sm btn-upload" data-toggle="modal"
                                                            data-target="#uploadModal-{{ $pp->id_permohonan }}"title="Upload">
                                                            <i class="fa-solid fa-upload"></i> Upload
                                                        </button>
                                                        @include('admin.permohonan-pengambilan.modal.upload', [
                                                            'id' => $pp->id_permohonan,
                                                        ])
                                                    @endif
                                                </nobr>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </x-adminlte-datatable>
                    </div>

                </div>
            </div>
        </div>
    </div>

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