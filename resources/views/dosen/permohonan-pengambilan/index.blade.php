@extends('dashboard.home')

@section('title', 'Permohonan Pengambilan Data')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h1 class="card-title font-weight-bold">Permohonan Pengambilan Data yang Diterima</h1>
        </div>

        <div class="card-body">
            @php
                $heads = [
                    ['label' => 'No', 'width' => 5],
                    ['label' => 'Nama Mahasiswa', 'width' => 50],
                    ['label' => 'Aksi', 'width' => 45, 'no-export' => true],
                ];
            @endphp

            <x-adminlte-datatable id="tablePermohonanDiterima" :heads="$heads" class="table-bordered table-hover">
                @php $no = 1; @endphp
                @forelse ($diterima as $data)
                    @foreach ($data->permohonanPengambilan as $pp)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $data->dataMahasiswa->nama }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-sm btn-danger mr-2"
                                        data-toggle="modal" data-target="#tolakModal-{{ $pp->id_permohonan }}">
                                        <i class="fa-solid fa-xmark mr-1"></i> Tolak
                                    </button>
                                    @include('dosen.modal.tolak-modal', ['id' => $pp->id_permohonan, 'route' => 'tolak-permohonan'])


                                    <form action="{{ route('penerbitan-permohonan', $pp->id_permohonan) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success mr-2">
                                            <i class="fa-solid fa-check mr-1"></i> Terbitkan
                                        </button>
                                    </form>

                                    <button type="button" class="btn btn-sm btn-primary mr-2"
                                        data-toggle="modal" data-target="#detailModal-{{ $pp->id_permohonan }}">
                                        <i class="fa-solid fa-circle-info mr-1"></i> Detail
                                    </button>
                                    @include('admin.permohonan-pengambilan.modal.detail-pp')
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
