<div class="modal fade" id="editPermohonanModal-{{ $detail->id_permohonan }}" tabindex="-1" role="dialog" aria-labelledby="editPermohonanModalLabel-{{ $detail->id_permohonan }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editPermohonanModalLabel-{{ $detail->id_permohonan }}">Ubah Pengajuan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('edit-permohonan', $detail->id_permohonan) }}" method="post">
            <div class="modal-body">
                @csrf
                @method('PUT')
                <label for="tujuan_surat">Kepada Yth</label>
                <input type="text" name="tujuan surat" id="tujuan_surat" class="form-control mb-3" value="{{ $detail->tujuan_surat }}">
                <label for="alamat_surat">Alamat Surat</label>
                <textarea name="alamat_surat" id="alamat_surat" cols="30" rows="2" class="form-control mb-3">{{ $detail->alamat_surat }}</textarea>
                <label for="judul_skripsi">Judul Skripsi</label>
                <textarea name="judul_skripsi" id="judul_skripsi" cols="30" rows="2" class="form-control mb-3">{{ $detail->judul_skripsi }}</textarea>
                <label for="tanggal_mulai">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control mb-3" value="{{ $detail->tanggal_mulai }}">
                <label for="tanggal_selesai">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control mb-3" value="{{ $detail->tanggal_selesai }}">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Kirim</button>
            </div>
        </form>
        </div>
    </div>
</div>