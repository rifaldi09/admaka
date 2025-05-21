<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th class="w-75">Nama</th>
        <th class="w-25">Aksi</th>
    </tr>
    @forelse ($diterima as $key => $data)
        @foreach ($data->permohonanPengambilan as $pp)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $data->dataMahasiswa->nama }}</td>
                <td class="d-flex">
                    <button type="button" class="btn btn-danger mr-2 align-self-start" data-toggle="modal" data-target="#tolakModal-{{ $pp->id_permohonan }}">
                        Tolak
                    </button>
                    <form action="{{ route('penerbitan-permohonan', $pp->id_permohonan) }}" class="mr-2" method="post">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-success">Terbitkan</button>
                    </form>
                    <button type="button" class="btn btn-primary align-self-start" data-toggle="modal" data-target="#detailModal-{{ $pp->id_permohonan }}">
                        Detail
                    </button>
                    @include('dosen.modal.tolak-modal', ['id' => $pp->id_permohonan, 'route' => 'tolak-permohonan'])
                    @include('admin.permohonan-pengambilan.modal.detail-pp')
                </td>
            </tr>
        @endforeach
    @empty
        <tr>
            <td colspan="8" class="text-secondary text-center">Tidak ada data</td>
        </tr>
    @endforelse
</table>
