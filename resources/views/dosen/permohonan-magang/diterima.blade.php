<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th class="w-75">Nama</th>
        <th class="w-25">Aksi</th>
    </tr>
    @forelse ($diterima as $key => $data)
        @foreach ($data->PermohonanMagang as $kp)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $data->dataMahasiswa->nama }}</td>
                <td class="d-flex">
                    <button type="button" class="btn btn-danger mr-2 align-self-start" data-toggle="modal" data-target="#tolakModal-{{ $kp->id_permohonan_magang }}">
                        Tolak
                    </button>
                    <form action="{{ route('penerbitan-permohonan-magang', $kp->id_permohonan_magang) }}" class="mr-2" method="post">
                        @csrf
                        <button class="btn btn-success">Terbitkan</button>
                    </form>
                    <button type="button" class="btn btn-primary align-self-start" data-toggle="modal" data-target="#detailPermohonanModal-{{ $kp->id_permohonan_magang }}">
                        Detail
                    </button>
                    @include('dosen.modal.tolak-modal', ['id' => $kp->id_permohonan_magang, 'route' => 'tolak-permohonan-magang'])
                    @include('admin.permohonan-magang.modal.detail-pm', ['id' => $kp->id_permohonan_magang])
                </td>
            </tr>
        @endforeach
    @empty
        <tr>
            <td colspan="8" class="text-secondary text-center">Tidak ada data</td>
        </tr>
    @endforelse
</table>
