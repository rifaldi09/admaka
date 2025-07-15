{{-- Modal ketika surat ditolak --}}
<div class="modal fade" id="modalTolakPm-{{ $id }}" tabindex="-1" aria-labelledby="modalTolakPm-{{ $id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <form action="{{ route($route, $id) }}" class="modal-content" method="post" enctype="multipart/form-data"
            id="tolak-form">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Penolakan Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{-- Content Penolakan Surat Pengajuan KP --}}
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="form-group">
                    <label for="alasan">Alasan</label>
                    {{-- alasan/deskripsi surat di tolak --}}
                    <textarea class="form-control" name="alasan_ditolak" rows="6" required></textarea>
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