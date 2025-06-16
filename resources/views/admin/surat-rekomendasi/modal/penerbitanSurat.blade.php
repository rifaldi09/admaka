<div class="modal fade" id="penerbitanSurat-{{ $id }}" tabindex="-1" role="dialog"
    aria-labelledby="uploapenerbitanSurat-{{ $id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Penerbitan Surat Rekomendasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('konversi-sks', encrypt($id)) }}" method="post"
                enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="konversi_sks">Jumlah SKS yang di Konversi</label>
                        <input type="number" name="konversi_sks" required class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success penerbitan">Terbitkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
