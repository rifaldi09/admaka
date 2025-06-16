@extends('dashboard.home')

@section('title', 'Pengajuan Kerja Praktik')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h1 class="card-title font-weight-bold">Pengajuan KP yang Diterima</h1>
        </div>

        <div class="card-body">
            @php
                $heads = [
                    ['label' => 'No', 'no-export' => true, 'width' => 5],
                    ['label' => 'Nama Mahasiswa', 'width' => 50],
                    ['label' => 'Aksi', 'no-export' => true, 'width' => 45],
                ];
            @endphp

            <x-adminlte-datatable id="kpDiterimaTable" :heads="$heads" class="table-bordered table-hover">
                @php $no = 1; @endphp
                @forelse ($diterima as $data)
                    @foreach ($data->pengajuanKp as $kp)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $data->dataMahasiswa->nama }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-sm btn-danger mr-2"
                                        data-toggle="modal" data-target="#tolakModal-{{ $kp->id_pengajuan }}">
                                        <i class="fa-solid fa-xmark mr-1"></i> Tolak
                                    </button>
                                    @include('dosen.modal.tolak-modal', ['id' => $kp->id_pengajuan, 'route' => 'tolak-pengajuan'])

                                    <form action="{{ route('penerbitan-pengajuan', $kp->id_pengajuan) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success mr-2">
                                            <i class="fa-solid fa-check mr-1"></i> Terbitkan
                                        </button>
                                    </form>

                                    <button type="button" class="btn btn-sm btn-primary"
                                        data-toggle="modal" data-target="#detailModal-{{ $kp->id_pengajuan }}">
                                        <i class="fa-solid fa-circle-info mr-1"></i> Detail
                                    </button>
                                    @include('admin.pengajuan-kp.modal.detail-kp', ['id' => $kp->id_pengajuan])
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
