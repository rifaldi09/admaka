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
                <p>Keperluan: {{ $pp->keperluan == 'mata_kuliah' ? 'Mata Kuliah' : 'Skripsi' }}</p>
                @if($pp->keperluan == 'skripsi')
                <p>Judul skripsi: {{ $pp->judul_skripsi  }}</p>
                @else
                <p>Dosen Pengampu: {{ $pp->dosen->nama }}</p>
                @endif
                <p>Tanggal Mulai: {{ \Carbon\Carbon::parse($pp->tanggal_mulai)->translatedFormat('j F Y') }}</p>
                <p>Tanggal Mulai: {{ \Carbon\Carbon::parse($pp->tanggal_selesai)->translatedFormat('j F Y') }}</p>
                <p>Status: {{ $pp->status }}</p>
                @if($pp->status == 'Ditolak')
                <p>Alasan Ditolak: {{ $pp->alasan_ditolak }}</p>
                @endif
            </div>
        </div>
    </div>
</div>