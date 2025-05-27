<div class="modal fade" id="uploadTranskripModal-{{ $tp->id_transkrip }}" tabindex="-1" role="dialog" aria-labelledby="uploadTranskripModalLabel-{{ $tp->id_transkrip }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="uploadTranskripModalLabel-{{ $tp->id_transkrip }}">Upload File transkrip</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('upload-transkrip', $tp->id_transkrip) }}" method="post" enctype="multipart/form-data">
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