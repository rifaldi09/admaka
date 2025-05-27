<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th class="w-25">Nama</th>
        <th class="w-25">Status</th>
        <th class="w-25">Aksi</th>
        <th class="w-75">Upload File Bertanda Tangan</th>
    </tr>
    @forelse ($diterima as $key => $data)
    @foreach ($data->permohonanMagang as $kp)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $data->dataMahasiswa->nama }}</td>
            <td>{{ $kp->status }}</td>
            <td class="d-flex">
                @if($kp->status == 'Penerbitan')
                <button type="button" class="btn btn-success mr-2 align-self-start" data-toggle="modal" data-target="#generateModal-{{ $kp->id_permohonan_magang }}">
                    Generate
                </button>
                @include('admin.permohonan-magang.modal.generate')
                @endif
                <button type="button" class="btn btn-primary align-self-start" data-toggle="modal" data-target="#detailPermohonanModal-{{ $kp->id_permohonan_magang }}">
                    Detail
                </button>
                @include('admin.permohonan-magang.modal.detail-pm', ['id' => $kp->id_permohonan_magang])
            </td>
            <td>
                @if($kp->status == 'Penerbitan')
                <button type="button" class="btn btn-info mr-2 align-self-start" data-toggle="modal" data-target="#uploadModal-{{ $kp->id_permohonan_magang }}">
                    Upload
                </button>
                @include('admin.permohonan-magang.modal.upload')
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