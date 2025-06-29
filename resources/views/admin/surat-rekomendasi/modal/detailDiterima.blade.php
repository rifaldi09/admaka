{{-- Modal ketika surat disetujui --}}
<div class="modal fade" id="modalDetailTerima-{{ $id }}" tabindex="-1" aria-labelledby="modalDetailTerima-{{ $id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{-- Content Persetujuan Surat Aktif Kuliaj --}}

                <input type="hidden" name="id" value="{{ $id }}">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="id_user">NIM</label>
                        <input type="text" class="form-control" name="id_user"
                            value="{{ $data->user->dataMahasiswa->nim }}" disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" value="{{ $data->user->dataMahasiswa->nama }}"
                            name="nama" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" value="{{ $data->user->dataMahasiswa->email }}"
                            name="email" disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="prodi">Program Studi</label>
                        <input type="text" class="form-control" value="{{ $data->user->dataMahasiswa->prodi->nama }}"
                            name="prodi" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir"
                            value="{{ $data->user->dataMahasiswa->tempat_lahir }}" disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir"
                            value="{{ $data->user->dataMahasiswa->tanggal_lahir }}" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="jenjang">Jenjang</label>
                        <input type="text" class="form-control" name="jenjang"
                            value="{{ $data->user->dataMahasiswa->jenjang }}" disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="semester">Semester</label>
                        @php
                        $formatter = new \NumberFormatter('id', \NumberFormatter::SPELLOUT);
                        $numberSemester = $formatter->format($data->user->dataMahasiswa->semester);
                        @endphp
                        <input type="text" class="form-control" name="semester"
                            value="{{ $data->user->dataMahasiswa->semester }} ({{ $numberSemester }})" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-row col-md-6">
                        <div class="form-group col-md-6">
                            <label for="tahun_akademik">Tahun Akademik</label>
                            <input type="text" class="form-control" name="tahun_akademik"
                                value="{{ $data->user->dataMahasiswa->tahun_akademik }}" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="ipk">IPK</label>
                            <input type="number" class="form-control" name="ipk"
                                value="{{ $data->user->dataMahasiswa->ipk }}" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="sks">SKS</label>
                            <input type="text" class="form-control" name="sks"
                                value="{{ $data->user->dataMahasiswa->sks }}" disabled>
                        </div>
                    </div>
                    <div class="form-row col-md-6">
                        <div class="form-group col-md-6">
                            <label for="no_hp">No Handphone</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp"
                                value="{{ $data->user->dataMahasiswa->no_hp }}" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="status">Status</label>
                            <input type="text" class="form-control" name="status" value="{{ $data->status }}" disabled>
                        </div>
                    </div>
                </div>

                @if ($data->status=='Ditolak')
                <div class="form-group">
                    <label for="alasan_ditolak">Alasan Ditolak</label>
                    <textarea class="form-control" name="alasan_ditolak" disabled>{{ $data->alasan_ditolak }}</textarea>
                </div>
                @endif
                <div class="form-group">
                    <label for="perihal">Perihal</label>
                    <textarea class="form-control" name="perihal" disabled>{{ $data->perihal }}</textarea>
                </div>
                <div class="form-group">
                    <label for="tempat_perihal">Tempat Perihal</label>
                    <textarea class="form-control" name="tempat_perihal" disabled>{{ $data->tempat_perihal }}</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                </div>

            </div>
        </div>
    </div>
</div>