<!-- Modal Penambahan Surat Aktif Kuliah-->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <form action="{{ route('edit-penolakan-surat') }}" class="modal-content" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Surat Penolakan Aktif Kuliah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{-- Content Pengajuan Surat Baru --}}

                {{-- id_role & nama_role --}}
                <input type="hidden" class="form-control" id="id-edit" name="id_edit">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="status">Status</label>
                        <input type="text" class="form-control" id="status-edit" name="status" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="alasan">Alasan DItolak</label>
                    <textarea class="form-control" id="alasan-edit" name="alasan" disabled></textarea>
                </div>

                <div class="form-group">
                    <label for="keperluan">Keperluan</label>
                    <textarea class="form-control" id="keperluan-edit" name="keperluan"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk fa-sm"></i> Save
                    changes</button>
            </div>
        </form>
    </div>
</div>
