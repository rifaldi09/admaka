<div class="modal fade" id="editPengajuanModal-{{ $detail->id_pengajuan }}" tabindex="-1" role="dialog" aria-labelledby="editPengajuanModalLabel-{{ $detail->id_pengajuan }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editPengajuanModalLabel-{{ $detail->id_pengajuan }}">Ubah Pengajuan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('edit-pengajuan', $detail->id_pengajuan) }}" method="post">
            <div class="modal-body">
                @csrf
                <label for="tujuan_surat">Kepada Yth</label>
                <input type="text" name="tujuan surat" id="tujuan_surat" class="form-control mb-3" value="{{ $detail->tujuan_surat }}">
                <label for="tanggal_mulai">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control mb-3" value="{{ $detail->tanggal_mulai }}">
                <label for="tanggal_selesai">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control mb-3" value="{{ $detail->tanggal_selesai }}">
                <label for="alamat_surat">Alamat Surat</label>
                <textarea name="alamat_surat" id="alamat_surat" cols="30" rows="2" class="form-control mb-3">{{ $detail->alamat_surat }}</textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Kirim</button>
            </div>
        </form>
        </div>
    </div>
</div>