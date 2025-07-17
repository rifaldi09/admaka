    <div class="modal fade" id="transkripModal" tabindex="-1" role="dialog" aria-labelledby="transkripModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transkripModalLabel">Buat transkrip</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('create-transkrip') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <label for="keperluan">Keperluan</label>
                        <textarea name="keperluan" id="keperluan" class="form-control" cols="30" rows="3"
                            required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>