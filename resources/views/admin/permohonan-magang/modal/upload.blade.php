<div class="modal fade" id="uploadModal-{{ $magang->id_permohonan_magang }}" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel-{{ $magang->id_permohonan_magang }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="uploadModalLabel->{{ $magang->id_permohonan_magang }}">Upload File</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('upload-permohonan-magang', $magang->id_permohonan_magang) }}" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                @csrf
                <label for="pdf">Tambahkan File PDF</label>
                <input type="file" id="pdf" name="file" accept=".pdf" required class="form-control">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Kirim</button>
            </div>
        </form>
        </div>
    </div>
</div>