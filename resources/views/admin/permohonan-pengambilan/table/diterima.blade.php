<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th class="w-25">Nama</th>
        <th class="w-25">Keperluan</th>
        <th>Status</th>
        <th>Aksi</th>
        <th class="w-75">Upload File Bertanda Tangan</th>
    </tr>
    @forelse ($diterima as $key => $data)
    @foreach ($data->permohonanPengambilan as $pp)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $data->dataMahasiswa->nama }}</td>
            <td>{{ $pp->keperluan == 'mata_kuliah' ? 'Mata Kuliah' : 'Skripsi' }}</td>
            <td>{{ $pp->status }}</td>
            <td class="d-flex">
                @if($pp->status == 'Penerbitan')
                <button type="button" class="btn btn-success mr-2 align-self-start" data-toggle="modal" data-target="#generatePermohonanModal-{{ $pp->id_permohonan }}">
                    Generate
                </button>
                @include('admin.permohonan-pengambilan.modal.generate')
                @endif
                <button type="button" class="btn btn-primary align-self-start" data-toggle="modal" data-target="#detailModal-{{ $pp->id_permohonan }}">
                    Detail
                </button>
                @include('admin.permohonan-pengambilan.modal.detail-pp')
            </td>
            <td>
                @if($pp->status == 'Penerbitan')
                <button type="button" class="btn btn-info mr-2 align-self-start" data-toggle="modal" data-target="#uploadPermohonanModal-{{ $pp->id_permohonan }}">
                    Upload
                </button>
                @include('admin.permohonan-pengambilan.modal.upload')
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