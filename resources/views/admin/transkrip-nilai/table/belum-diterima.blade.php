<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Keperluan</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    {{-- {{ dd($draft->toArray()) }} --}}
    @forelse ($draft as $key => $data)
    @foreach ($data->transkrip as $tp)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $data->dataMahasiswa->nama }}</td>
            <td>{{ $tp->keperluan }}</td>
            <td>{{ $tp->status }}</td>
            <td>
                <form action="{{ route('terima-transkrip', $tp->id_transkrip) }}" class="mr-2" method="post">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-success">Terima</button>
                </form>
            </td>
        </tr>
    @endforeach
    @empty
        <tr>
            <td colspan="8" class="text-secondary text-center">Tidak ada data</td>
        </tr>
    @endforelse
</table>