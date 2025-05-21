<div class="modal fade" id="generatePermohonanModal-{{ $pp->id_permohonan }}" tabindex="-1" role="dialog" aria-labelledby="generatePermohonanModalLabel-{{ $pp->id_permohonan }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="generatePermohonanModalLabel->{{ $pp->id_permohonan }}">Upload File Permohonan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('generate-permohonan', $pp->id_permohonan) }}" method="post">
            <div class="modal-body">
                @csrf
                @method('PUT')
                <label for="nomor_surat">Ubah Nomor Surat</label>
                <input type="text" name="no_surat" id="nomor_surat" class="form-control" value="{{ $pp->no_surat }}">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Kirim</button>
            </div>
        </form>
        </div>
    </div>
</div>