<div class="modal fade" id="detailPermohonanModal-{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="detailPermohonanModalLabel-{{ $id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="detailPermohonanModalLabel->{{ $id }}">Detail Permohonan Surat</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <div class="modal-body">
                <p>Tujuan surat: {{ $kp->tujuan_surat }}</p>
                <p>Alamat surat: {{ $kp->alamat_surat }}</p>
                <p>Tanggal Mulai: {{ $kp->tanggal_mulai }}</p>
                <p>Tanggal Selesai: {{ $kp->tanggal_selesai }}</p>
                <p>Status: {{ $kp->status }}</p>
                @if($kp->status == 'Ditolak')
                <p>Alasan Ditolak: {{ $kp->alasan_ditolak }}</p>
                @endif
            </div>
        </div>
    </div>
</div>