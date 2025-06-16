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
                <p>Tujuan surat: {{ $magang->tujuan_surat }}</p>
                <p>Alamat surat: {{ $magang->alamat_surat }}</p>
                <p>Tanggal Mulai: {{ $magang->tanggal_mulai }}</p>
                <p>Tanggal Selesai: {{ $magang->tanggal_selesai }}</p>
                <p>Status: {{ $magang->status }}</p>
                @if($magang->status == 'Ditolak')
                <p>Alasan Ditolak: {{ $magang->alasan_ditolak }}</p>
                @endif
            </div>
        </div>
    </div>
</div>