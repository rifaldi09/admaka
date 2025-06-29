<div class="modal fade" id="editPermohonanMagang-{{ $detail->id_permohonan_magang }}" tabindex="-1" role="dialog"
    aria-labelledby="editPermohonanMagangLabel-{{ $detail->id_permohonan_magang }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPermohonanMagangLabel-{{ $detail->id_permohonan_magang }}">Ubah Surat
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('edit-permohonan-magang', $detail->id_permohonan_magang) }}" method="post">
                <div class="modal-body">
                    @csrf
                    <!-- <label for="tujuan_surat">Kepada Yth</label>
                    <input type="text" name="tujuan surat" id="tujuan_surat" class="form-control mb-3"
                        value="{{ $detail->tujuan_surat }}">
                    <label for="tanggal_mulai">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control mb-3"
                        value="{{ $detail->tanggal_mulai }}">
                    <label for="tanggal_selesai">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control mb-3"
                        value="{{ $detail->tanggal_selesai }}">
                    <label for="alamat_surat">Alamat Surat</label>
                    <textarea name="alamat_surat" id="alamat_surat" cols="30" rows="2"
                        class="form-control mb-3">{{ $detail->alamat_surat }}</textarea> -->
                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="text" class="form-control" value="{{ $detail->status }}" name="status" disabled>
                    </div>
                    <div class="form-group">
                        <label for="alasan">Alasan DItolak</label>
                        <textarea class="form-control" name="alasan" disabled>{{ $detail->alasan_ditolak }}</textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <!-- <button type="submit" class="btn btn-success">Kirim</button> -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>