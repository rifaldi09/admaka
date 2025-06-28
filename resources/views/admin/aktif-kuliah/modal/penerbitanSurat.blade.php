<div class="modal fade" id="penerbitanSurat-{{ $id }}" tabindex="-1" role="dialog"
    aria-labelledby="uploapenerbitanSurat-{{ $id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Penerbitan Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('penerbitan-aktif-kuliah', encrypt($id)) }}" method="get"
                enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="status" value="{{ $data->status }}">
                    <label for="nomor_surat">Masukkan Nomor Surat</label>
                    <input type="text" name="nomor_surat" required class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success penerbitan">Terbitkan</button>
                </div>
            </form>
        </div>
    </div>
</div>