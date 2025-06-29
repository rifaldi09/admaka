@extends('dashboard.home')

@section('title', 'Transkrip Nilai')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h1 class="card-title font-weight-bold">Transkrip yang Diterima</h1>
    </div>

    <div class="card-body">
        @php
        $heads = [
        ['label' => 'No', 'width' => 5],
        ['label' => 'Nama Mahasiswa', 'width' => 35],
        ['label' => 'Keperluan', 'width' => 30],
        ['label' => 'Aksi', 'width' => 30, 'no-export' => true],
        ];
        @endphp

        <x-adminlte-datatable id="tableTranskripDiterima" :heads="$heads" class="table-bordered table-hover">
            @php $no = 1; @endphp
            @forelse ($diterima as $data)
            @foreach ($data->transkrip as $tp)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $data->dataMahasiswa->nama }}</td>
                <td>{{ $tp->keperluan }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <button type="button" class="btn btn-sm btn-danger mr-2" data-toggle="modal"
                            data-target="#tolakModal-{{ $tp->id_transkrip }}">
                            <i class="fa-solid fa-xmark mr-1"></i> Tolak
                        </button>
                        @include('dosen.modal.tolak-modal', ['id' => $tp->id_transkrip, 'route' => 'tolak-transkrip'])

                        <form action="{{ route('penerbitan-transkrip', $tp->id_transkrip) }}" method="POST"
                            class="m-0 mr-2">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fa-solid fa-check mr-1"></i> Terbitkan
                            </button>
                        </form>
                        <button type="button" class="btn btn-sm btn-primary mr-2" data-toggle="modal"
                            data-target="#detailtranskripModal-{{ $tp->id_transkrip }}">
                            <i class="fa-solid fa-circle-info mr-1"></i> Detail
                        </button>
                        @include('admin.transkrip-nilai.modal.detail-tp', [
                        'id' => $tp->id_transkrip,
                        ])
                    </div>

                    @include('dosen.modal.tolak-modal', ['id' => $tp->id_transkrip, 'route' => 'tolak-transkrip'])
                </td>
            </tr>
            @endforeach
            @empty
            <tr>
                <td colspan="4" class="text-center text-secondary py-3">Tidak ada data</td>
            </tr>
            @endforelse
        </x-adminlte-datatable>
    </div>
</div>
@endsection