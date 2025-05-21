<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th class="w-50">Nama</th>
        <th class="w-25">Status</th>
        <th class="w-50">Aksi</th>
    </tr>
    @forelse ($draft as $key => $data)
    @foreach ($data->permohonanPengambilan as $pp)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $data->dataMahasiswa->nama }}</td>
            <td>{{ $pp->status }}</td>
            <td class="d-flex">
                <form action="{{ route('terima-permohonan-mahasiswa', $pp->id_permohonan) }}" class="mr-2" method="post">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-success">Terima</button>
                </form>
                <button type="button" class="btn btn-primary align-self-start" data-toggle="modal" data-target="#detailModal-{{ $pp->id_permohonan }}">
                    Detail
                </button>
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