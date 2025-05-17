<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th class="w-25">Nama</th>
        <th class="w-25">Status</th>
        <th class="w-25">Aksi</th>
        <th class="w-75">Upload File Bertanda Tangan</th>
    </tr>
    @forelse ($diterima as $key => $data)
        <tr>
            <td>{{ 1 + $key }}</td>
            <td>{{ $data->dataMahasiswa->nama }}</td>
            @foreach ($data->pengajuanKp as $kp)
            <td>{{ $kp->status }}</td>
            <td class="d-flex">
                @if($kp->status == 'Penerbitan')
                <button type="button" class="btn btn-success mr-2 align-self-start" data-toggle="modal" data-target="#generateModal-{{ $kp->id_pengajuan }}">
                    Generate
                </button>
                @include('admin.pengajuan-kp.modal.generate')
                @endif
                <button type="button" class="btn btn-primary align-self-start" data-toggle="modal" data-target="#detailModal-{{ $kp->id_pengajuan }}">
                    Detail
                </button>
                @include('admin.pengajuan-kp.modal.detail-kp', ['id' => $kp->id_pengajuan])
            </td>
            <td>
                @if($kp->status == 'Penerbitan')
                <button type="button" class="btn btn-info mr-2 align-self-start" data-toggle="modal" data-target="#uploadModal-{{ $kp->id_pengajuan }}">
                    Upload
                </button>
                @include('admin.pengajuan-kp.modal.upload')
                @endif
            </td>
            @endforeach
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-secondary text-center">Tidak ada data</td>
        </tr>
    @endforelse
</table>