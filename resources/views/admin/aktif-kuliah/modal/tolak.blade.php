{{-- Modal ketika surat ditolak --}}
<div class="modal fade" id="modalTolak-{{ $id }}" tabindex="-1" aria-labelledby="modalTolak-{{ $id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <form action="{{ route('tolak-aktif-kuliah') }}" class="modal-content" method="post" enctype="multipart/form-data"
            id="tolak-form">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Penolakan Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{-- Content Penolakan Surat Aktif Kuliah --}}
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="form-group">
                    <label for="keperluan">Alasan</label>
                    {{-- alasan/deskripsi surat di tolak --}}
                    <textarea class="form-control" name="deskripsi" rows="6" required></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                {{-- button untuk memunculkan modal ketika surat ingin di tolak --}}
                <button type="button" class="btn btn-danger tolak"><i class="fa-solid fa-xmark"></i> Tolak
                    Surat</button>
            </div>
        </form>
    </div>
</div>
