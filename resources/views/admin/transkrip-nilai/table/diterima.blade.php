<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Keperluan</th>
        <th>Status</th>
        <th class="w-25">Upload File Bertanda Tangan</th>
    </tr>
    @forelse ($diterima as $key => $data)
    @foreach ($data->transkrip as $tp)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $data->dataMahasiswa->nama }}</td>
            <td>{{ $tp->keperluan }}</td>
            <td>{{ $tp->status }}</td>
            <td>
                @if($tp->status == 'Penerbitan')
                <button type="button" class="btn btn-info mr-2 align-self-start" data-toggle="modal" data-target="#uploadTranskripModal-{{ $tp->id_transkrip }}">
                    Upload
                </button>
                @include('admin.transkrip-nilai.modal.upload')
                @else
                <i>Sedang divalidasi</i>
                @endif
            </td>
        </tr>
    @endforeach
    @empty
        <tr>
            <td colspan="8" class="text-secondary text-center">Tidak ada data</td>
        </tr>
    @endforelse
</table>