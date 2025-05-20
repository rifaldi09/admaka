<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th class="w-75">Nama</th>
        <th class="w-25">Aksi</th>
    </tr>
    @forelse ($diterima as $key => $data)
        @foreach ($data->pengajuanKp as $kp)
            <tr>
                <td>{{ 1 + $key }}</td>
                <td>{{ $data->dataMahasiswa->nama }}</td>
                <td class="d-flex">
                    <button type="button" class="btn btn-danger mr-2 align-self-start" data-toggle="modal" data-target="#tolakModal-{{ $kp->id_pengajuan }}">
                        Tolak
                    </button>
                    <form action="{{ route('penerbitan-pengajuan', $kp->id_pengajuan) }}" class="mr-2" method="post">
                        @csrf
                        <button class="btn btn-success">Terbitkan</button>
                    </form>
                    <button type="button" class="btn btn-primary align-self-start" data-toggle="modal" data-target="#detailModal-{{ $kp->id_pengajuan }}">
                        Detail
                    </button>
                    @include('dosen.pengajuan-kp.tolak-modal', ['id' => $kp->id_pengajuan])
                    @include('admin.pengajuan-kp.modal.detail-kp', ['id' => $kp->id_pengajuan])
                </td>
            </tr>
        @endforeach
    @empty
        <tr>
            <td colspan="8" class="text-secondary text-center">Tidak ada data</td>
        </tr>
    @endforelse
</table>
