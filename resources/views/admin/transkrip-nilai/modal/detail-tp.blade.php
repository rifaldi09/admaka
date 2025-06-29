<div class="modal fade" id="detailtranskripModal-{{$tp->id_transkrip }}" tabindex="-1" role="dialog"
    aria-labelledby="detailtranskripModalLabel-{{ $tp->id_transkrip }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailtranskripModalLabel-{{ $tp->id_transkrip }}">Detail Permohonan
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Keperluan</label>
                    <textarea class="form-control" disabled>{{ $tp->keperluan }}</textarea>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <input type="text" class="form-control" value="{{ $tp->status }}" disabled>
                </div>

                @if($tp->status == 'Ditolak')
                <div class="form-group">
                    <label>Alasan Ditolak</label>
                    <textarea class="form-control" disabled>{{ $tp->alasan_ditolak }}</textarea>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                @if($tp->status == 'Belum Diterima')
                <form action="{{ route('terima-transkrip', $tp->id_transkrip) }}" class="d-inline" method="post">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-success btn-setujui " title="Setujui" type="submit">
                        <i class="fa-solid fa-check"></i> Setujui
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>