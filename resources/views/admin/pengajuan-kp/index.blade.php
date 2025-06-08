@extends('dashboard.home')

@section('title', 'Surat Pengajuan Kerja Praktik')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h1 class="card-title font-weight-bold">Surat Pengajuan Kerja Praktik</h1>
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
                                ['label' => 'Status', 'no-export' => true, 'width' => 5],
                                'Tanggal Pengajuan',
                                ['label' => 'Actions', 'no-export' => true, 'width' => 7],
                            ];
                        @endphp

                        <x-adminlte-datatable id="table1" :heads="$heads">
                            @foreach ($draft as $data)
                                @foreach ($data->pengajuanKp as $kp)
                                    @if ($kp->status == 'Belum Diterima')
                                        <tr>
                                            <td>{{ $data->dataMahasiswa->nim }}</td>
                                            <td>{{ $data->dataMahasiswa->nama }}</td>
                                            <td>{{ $data->dataMahasiswa->prodi->nama }}</td>
                                            <td>
                                                <div class="border border-warning btn-sm text-warning text-center">
                                                    {{ $kp->status }}</div>
                                            </td>
                                            <td>{{ $kp->created_at }}</td>
                                            <td>
                                                <nobr>
                                                    <button class="btn btn-primary btn-edit btn-sm mr-3" title="Detail"
                                                        data-toggle="modal"
                                                        data-target="#detailModal-{{ $kp->id_pengajuan }}">
                                                        <i class="fa-solid fa-eye"></i> Lihat
                                                    </button>
                                                    @include('admin.pengajuan-kp.modal.detail-kp', [
                                                        'id' => $kp->id_pengajuan,
                                                    ])
                                                    <form action="{{ route('terima-pengajuan', $kp->id_pengajuan) }}" class="d-inline" method="post">
                                                        @csrf
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
                                ['label' => 'Status', 'no-export' => true, 'width' => 3],
                                'Tanggal Pengajuan',
                                ['label' => 'Actions', 'no-export' => true, 'width' => 7],
                                'Upload Surat',
                            ];
                        @endphp

                        <x-adminlte-datatable id="table2" :heads="$heads">
                            @foreach ($diterima as $data)
                                @foreach ($data->pengajuanKp as $kp)
                                    @if ($kp->status != 'Belum Diterima')
                                        <tr>
                                            <td>{{ $data->dataMahasiswa->nim }}</td>
                                            <td>{{ $data->dataMahasiswa->nama }}</td>
                                            <td>{{ $data->dataMahasiswa->prodi->nama }}</td>
                                            <td>
                                                @if ($kp->status == 'Diterima')
                                                    <div class="border border-success btn-sm text-success text-center">
                                                        {{ $kp->status }}</div>
                                                @elseif ($kp->status == 'Penerbitan')
                                                    <div class="border border-primary btn-sm text-primary text-center">
                                                        {{ $kp->status }}</div>
                                                @endif
                                            </td>
                                            <td>{{ $kp->created_at }}</td>
                                            <td>
                                                <nobr>
                                                    <button class="btn btn-primary btn-detail-terima btn-sm mr-3"
                                                        data-toggle="modal"
                                                        data-target="#detailModal-{{ $kp->id_pengajuan }}"
                                                        title="Detail">
                                                        <i class="fa-solid fa-eye"></i> Detail
                                                    </button>
                                                    @include('admin.pengajuan-kp.modal.detail-kp', [
                                                        'id' => $kp->id_pengajuan,
                                                    ])
                                                    @if ($kp->status != 'Ditolak')
                                                        @if ($kp->status == 'Penerbitan')
                                                            <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                                data-target="#generateModal-{{ $kp->id_pengajuan }}"
                                                                title="Generate" type="button">
                                                                <i class="fa-solid fa-download"></i>
                                                                Generate
                                                            </button>
                                                             @include('admin.pengajuan-kp.modal.generate', [
                                                                'id' => $kp->id_pengajuan,
                                                            ])
                                                        @endif
                                                    @endif
                                                </nobr>
                                            </td>
                                            <td>
                                                <nobr>
                                                    @if ($kp->status == 'Penerbitan')
                                                        <button class="btn btn-success btn-sm btn-upload" data-toggle="modal"
                                                            data-target="#uploadModal-{{ $kp->id_pengajuan }}"title="Upload">
                                                            <i class="fa-solid fa-upload"></i> Upload
                                                        </button>
                                                        @include('admin.pengajuan-kp.modal.upload', [
                                                            'id' => $kp->id_pengajuan,
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