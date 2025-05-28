<div class="modal fade" id="modalUpload-{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="modalUpload-{{ $id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Upload Surat Rekomendasi Bertanda Tangan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('upload-surat-rekomendasi') }}" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                @csrf
                <label for="pdf">Masukkan Surat Bertanda Tangan (Only PDF)</label>
                <input type="hidden" value="{{ encrypt($id) }}" name="id">
                <input type="file" id="pdf" name="file" accept=".pdf" required class="form-file">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Kirim</button>
            </div>
        </form>
        </div>
    </div>
</div>