<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th class="w-50">Nama</th>
        <th class="w-25">Status</th>
        <th class="w-50">Aksi</th>
    </tr>
    {{-- {{ dd($draft->toArray()) }} --}}
    @forelse ($draft as $key => $data)
        <tr>
            <td>{{ 1 + $key }}</td>
            <td>{{ $data->dataMahasiswa->nama }}</td>
            @foreach ($data->pengajuanKp as $kp)
            <td>{{ $kp->status }}</td>
            <td class="d-flex">
                <form action="{{ route('terima-pengajuan', $kp->id_pengajuan) }}" class="mr-2" method="post">
                    @csrf
                    <button class="btn btn-success">Terima</button>
                </form>
                <button type="button" class="btn btn-primary align-self-start" data-toggle="modal" data-target="#detailModal-{{ $kp->id_pengajuan }}">
                    Detail
                </button>
                @include('admin.pengajuan-kp.modal.detail-kp', ['id' => $kp->id_pengajuan])
            @endforeach
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-secondary text-center">Tidak ada data</td>
        </tr>
    @endforelse
</table>