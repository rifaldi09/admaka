<!-- Modal Penambahan Surat Aktif Kuliah-->
<div class="modal fade" id="modalTambahSuratRekomendasi" tabindex="-1" aria-labelledby="modalTambahSuratRekomendasi"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <form action="{{ route('create-surat-rekomendasi') }}" class="modal-content" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahSuratRekomendasi">Pengajuan Surat Rekomendasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{-- Content Pengajuan Surat Baru --}}

                {{-- id_role & nama_role --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="id_user">NIM</label>
                        <input type="text" class="form-control" id="id_user" name="id_user" value="{{ $dataUser->nim }}"
                            disabled required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $dataUser->nama }}"
                            disabled required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $dataUser->email }}"
                            disabled required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="prodi">Program Studi</label>
                        <input type="text" class="form-control" id="prodi" name="prodi" value="{{ $prodiUser->nama }}"
                            disabled required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahi"
                            value="{{ $dataUser->tempat_lahir }}" disabled required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                            value="{{ $dataUser->tanggal_lahir }}" disabled required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="jenjang">Jenjang</label>
                        <input type="text" class="form-control" id="jenjang" name="jenjang"
                            value="{{ $dataUser->jenjang }}" disabled required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="semester">Semester</label>
                        @php
                        $formatter = new \NumberFormatter('id', \NumberFormatter::SPELLOUT);
                        $numberSemester = $formatter->format($dataUser->semester);
                        @endphp
                        <input type="text" class="form-control" id="semester" name="semester"
                            value="{{ $dataUser->semester }} ({{ $numberSemester }})" disabled required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tahun_akademik">Tahun Akademik</label>
                        <input type="text" class="form-control" id="tahun_akademik" name="tahun_akademik"
                            value="{{ $dataUser->tahun_akademik }}" disabled required>
                    </div>
                    <div class="form-row col-md-6">
                        <div class="form-group col-md-6">
                            <label for="ipk">IPK</label>
                            <input type="number" class="form-control" id="ipk" name="ipk" value="{{ $dataUser->ipk }}"
                                disabled required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sks">SKS</label>
                            <input type="text" class="form-control" id="sks" name="sks" value="{{ $dataUser->sks }}"
                                disabled required>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="no_hp">No Handphone</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $dataUser->no_hp }}"
                            disabled required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="perihal">Perihal</label>
                    <textarea class="form-control" name="perihal" required
                        placeholder="Contoh: Untuk menjadi peserta Program Kampus Merdeka"></textarea>
                </div>
                <div class="form-group">
                    <label for="tempat_perihal">Tempat Perihal <small
                            class="text-danger text-sm">*Opsional</small></label>
                    <textarea class="form-control" name="tempat_perihal"
                        placeholder="Contoh: Studi Independen Bersertifikat Tahun 2024 yang diselenggarakan oleh Kemendikbud Ristek"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk fa-sm"></i> Save
                    changes</button>
            </div>
        </form>
    </div>
</div>