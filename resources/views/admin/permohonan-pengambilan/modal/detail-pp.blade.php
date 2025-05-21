<div class="modal fade" id="detailModal-{{ $pp->id_permohonan }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel-{{ $pp->id_permohonan }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="detailModalLabel->{{ $pp->id_permohonan }}">Detail Permohonan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <div class="modal-body">
                <p>Tujuan surat: {{ $pp->tujuan_surat }}</p>
                <p>Alamat surat: {{ $pp->alamat_surat }}</p>
                <p>Judul skripsi: {{ $pp->alamat_surat }}</p>
                <p>Tanggal Mulai: {{ $pp->tanggal_mulai }}</p>
                <p>Tanggal Selesai: {{ $pp->tanggal_selesai }}</p>
                <p>Status: {{ $pp->status }}</p>
                @if($pp->status == 'Ditolak')
                <p>Alasan Ditolak: {{ $pp->alasan_ditolak }}</p>
                @endif
            </div>
        </div>
    </div>
</div>