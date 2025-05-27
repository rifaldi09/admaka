<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Keperluan</th>
        <th>Aksi</th>
    </tr>
    @forelse ($diterima as $key => $data)
        @foreach ($data->transkrip as $tp)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $data->dataMahasiswa->nama }}</td>
                <td>{{ $tp->keperluan }}</td>
                <td class="d-flex">
                    <button type="button" class="btn btn-danger mr-2 align-self-start" data-toggle="modal" data-target="#tolakModal-{{ $tp->id_transkrip }}">
                        Tolak
                    </button>
                    <form action="{{ route('penerbitan-transkrip', $tp->id_transkrip) }}" class="mr-2" method="post">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-success">Terbitkan</button>
                    </form>
                    @include('dosen.modal.tolak-modal', ['id' => $tp->id_transkrip, 'route' => 'tolak-transkrip'])
                </td>
            </tr>
        @endforeach
    @empty
        <tr>
            <td colspan="8" class="text-secondary text-center">Tidak ada data</td>
        </tr>
    @endforelse
</table>
