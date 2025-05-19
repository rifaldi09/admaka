<!-- Modal Penambahan Surat Aktif Kuliah-->
<div class="modal fade" id="modalEdit-{{ $data->id_aktif_kuliah }}" tabindex="-1" aria-labelledby="modalEdit-{{ $data->id_aktif_kuliah }}" aria-hidden="true">
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
                <input type="hidden" class="form-control" value="{{ $data->id_aktif_kuliah }}" name="id_edit">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="status">Status</label>
                        <input type="text" class="form-control" value="{{ $data->status }}" name="status" disabled>
                    </div>
                    <div class="form-row col-md-6">
                        <div class="form-group col-md-6">
                            <label for="semester_awal">Semester Awal</label>
                            <input type="number" class="form-control" id="semester_awal" name="semester_awal" value="{{ $data->semester_awal }}" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="semester_akhir">Semester Akhir</label>
                            <input type="number" class="form-control" id="semester_akhir" name="semester_akhir" value="{{ $data->semester_akhir }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="alasan">Alasan DItolak</label>
                    <textarea class="form-control" name="alasan" disabled>{{ $data->alasan }}</textarea>
                </div>

                <div class="form-group">
                    <label for="keperluan">Keperluan</label>
                    <textarea class="form-control" name="keperluan">{{ $data->keperluan }}</textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-edit-save"><i class="fa-solid fa-floppy-disk fa-sm"></i> Save
                    changes</button>
            </div>
        </form>
    </div>
</div>
