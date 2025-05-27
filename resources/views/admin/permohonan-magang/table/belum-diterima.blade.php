<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th class="w-50">Nama</th>
        <th class="w-25">Status</th>
        <th class="w-50">Aksi</th>
    </tr>
    {{-- {{ dd($draft->toArray()) }} --}}
    @forelse ($draft as $key => $data)
    @foreach ($data->permohonanMagang as $kp)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $data->dataMahasiswa->nama }}</td>
            <td>{{ $kp->status }}</td>
            <td class="d-flex">
                <form action="{{ route('terima-permohonan-magang', $kp->id_permohonan_magang) }}" class="mr-2" method="post">
                    @csrf
                    <button class="btn btn-success">Terima</button>
                </form>
                <button type="button" class="btn btn-primary align-self-start" data-toggle="modal" data-target="#detailPermohonanModal-{{ $kp->id_permohonan_magang }}">
                    Detail
                </button>
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