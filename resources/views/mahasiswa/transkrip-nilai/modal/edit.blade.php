    <div class="modal fade" id="editTranskripModal-{{ $detail->id_transkrip }}" tabindex="-1" role="dialog"
        aria-labelledby="editTranskripModalLabel-{{ $detail->editTranskrip }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTranskripModalLabel-{{ $detail->id_transkrip }}">Buat transkrip</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('edit-transkrip', $detail->id_transkrip) }}" method="post">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <!-- <label for="keperluan">Keperluan</label>
                    <textarea name="keperluan" id="keperluan" class="form-control" cols="30" rows="3"></textarea> -->
                        <input type="hidden" class="form-control" value="{{ $detail->id_rekomendasi }}" name="id_edit">

                        <div class="form-group ">
                            <label for="status">Status</label>
                            <input type="text" class="form-control" value="{{ $detail->status }}" name="status"
                                disabled>
                        </div>


                        <div class="form-group">
                            <label for="alasan">Alasan DItolak</label>
                            <textarea class="form-control" name="alasan"
                                disabled>{{ $detail->alasan_ditolak }}</textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <!-- <button type="submit" class="btn btn-success">Kirim</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>