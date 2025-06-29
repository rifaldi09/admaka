<div class="modal fade" id="detailModal-{{ $id }}" tabindex="-1" role="dialog"
    aria-labelledby="detailModalLabel-{{ $id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel-{{ $id }}">Detail Pengajuan Kerja Praktik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Tujuan Surat</label>
                        <input type="text" class="form-control" value="{{ $kp->tujuan_surat }}" disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Alamat Surat</label>
                        <input type="text" class="form-control" value="{{ $kp->alamat_surat }}" disabled>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Tanggal Mulai</label>
                        <input type="date" class="form-control" value="{{ $kp->tanggal_mulai }}" disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tanggal Selesai</label>
                        <input type="date" class="form-control" value="{{ $kp->tanggal_selesai }}" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <input type="text" class="form-control" value="{{ $kp->status }}" disabled>
                </div>


                @if($kp->status == 'Ditolak')
                <div class="form-group">
                    <label>Alasan Ditolak</label>
                    <textarea class="form-control" disabled>{{ $kp->alasan_ditolak }}</textarea>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                @if($kp->status == 'Belum Diterima')
                <form action="{{ route('terima-pengajuan', $kp->id_pengajuan) }}" class="d-inline" method="post">
                    @csrf
                    <button class="btn btn-success btn-setujui " title="Setujui" type="submit">
                        <i class="fa-solid fa-check"></i> Setujui Surat
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>