<div class="modal fade" id="permohonanModal" tabindex="-1" role="dialog" aria-labelledby="permohonanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="permohonanModalLabel">Buat Surat</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('create-permohonan-magang') }}" method="post">
            <div class="modal-body">
                @csrf
                <label for="tujuan_surat">Kepada Yth</label>
                <input type="text" name="tujuan surat" id="tanggal_mulai" class="form-control mb-3">
                <label for="tanggal_mulai">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control mb-3">
                <label for="tanggal_selesai">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control mb-3">
                <label for="alamat_surat">Alamat Surat</label>
                <textarea name="alamat_surat" id="alamat_surat" cols="30" rows="2" class="form-control mb-3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Kirim</button>
            </div>
        </form>
        </div>
    </div>
</div>