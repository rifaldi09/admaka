<!-- Modal Penambahan Surat Aktif Kuliah-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <form action="{{ route('create-surat-aktif') }}" class="modal-content" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pengajuan Surat Aktif Kuliah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{-- Content Pengajuan Surat Baru --}}

                {{-- id_role & nama_role --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="id_user">NIM / NIDN</label>
                        <input type="text" class="form-control" id="id_user" name="id_user"
                            value="{{ $dataUser->nim }}" disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="{{ $dataUser->nama }}" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ $dataUser->email }}" disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="prodi">Program Studi</label>
                        <input type="text" class="form-control" id="prodi" name="prodi"
                            value="{{ $prodi->nama }}" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahi" name="tempat_lahi"
                            value="{{ $dataUser->tempat_lahir }}" disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                            value="{{ $dataUser->tanggal_lahir }}" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="no_hp">No Handphone</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp"
                            value="{{ $dataUser->no_hp }}" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="keperluan">Keperluan</label>
                    <textarea class="form-control" id="keperluan" name="keperluan"></textarea>
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
