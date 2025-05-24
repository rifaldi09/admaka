<!-- Modal Penambahan Surat Aktif Kuliah-->
<div class="modal fade" id="modalEditRekomendasi-{{ $data->id_rekomendasi }}" tabindex="-1" aria-labelledby="modalEditRekomendasi-{{ $data->id_rekomendasi }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <form action="{{ route('edit-penolakan-rekomendasi') }}" class="modal-content" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Surat Penolakan Rekomendasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{-- Content Pengajuan Surat Baru --}}

                {{-- id_role & nama_role --}}
                <input type="hidden" class="form-control" value="{{ $data->id_rekomendasi }}" name="id_edit">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="status">Status</label>
                        <input type="text" class="form-control" value="{{ $data->status }}" name="status" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="alasan">Alasan DItolak</label>
                    <textarea class="form-control" name="alasan" disabled>{{ $data->alasan_ditolak }}</textarea>
                </div>

                <div class="form-group">
                    <label for="perihal">Perihal</label>
                    <textarea class="form-control" name="perihal" required placeholder="Contoh: Untuk menjadi peserta Program Kampus Merdeka">{{ $data->perihal }}</textarea>
                </div>
                <div class="form-group">
                    <label for="tempat_perihal">Tempat Perihal <small class="text-danger text-sm">*Opsional</small></label>
                    <textarea class="form-control" name="tempat_perihal" placeholder="Contoh: Studi Independen Bersertifikat Tahun 2024 yang diselenggarakan oleh Kemendikbud Ristek">{{ $data->tempat_perihal }}</textarea>
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
