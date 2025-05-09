<div class="modal fade" id="tolakModal-{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="tolakModalLabel-{{ $id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="tolakModalLabel->{{ $id }}">Alasan Penolakan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('tolak-pengajuan', $id) }}" method="post">
            <div class="modal-body">
                @csrf
                <label for="alasan">Alasan</label>
                <textarea name="alasan_ditolak" id="alasan" cols="30" rows="3" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Konfirmasi</button>
            </div>
        </form>
        </div>
    </div>
</div>