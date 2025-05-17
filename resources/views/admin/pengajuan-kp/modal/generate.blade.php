<div class="modal fade" id="generateModal-{{ $kp->id_pengajuan }}" tabindex="-1" role="dialog" aria-labelledby="generateModalLabel-{{ $kp->id_pengajuan }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="generateModalLabel->{{ $kp->id_pengajuan }}">Upload File Pengajuan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('word-pengajuan', $kp->id_pengajuan) }}" method="post">
            <div class="modal-body">
                @csrf
                @method('PUT')
                <label for="nomor_surat">Ubah Nomor Surat</label>
                <input type="text" name="no_surat" id="nomor_surat" class="form-control" value="{{ $kp->no_surat }}">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Kirim</button>
            </div>
        </form>
        </div>
    </div>
</div>