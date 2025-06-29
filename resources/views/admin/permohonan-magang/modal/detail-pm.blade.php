<div class="modal fade" id="detailPermohonanMagangModal-{{ $magang->id_permohonan_magang }}" tabindex="-1" role="dialog"
    aria-labelledby="detailPermohonanMagangModalLabel-{{ $magang->id_permohonan_magang }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailPermohonanMagangModalLabel->{{ $magang->id_permohonan_magang }}">
                    Detail Permohonan Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Tujuan surat</label>
                    <input type="text" class="form-control" value="{{ $magang->tujuan_surat }}" disabled>
                </div>
                <div class="form-group">
                    <label>Alamat surat</label>
                    <input type="text" class="form-control" value="{{ $magang->alamat_surat }}" disabled>
                </div>
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="text" class="form-control" value="{{ $magang->tanggal_mulai }}" disabled>
                </div>
                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input type="text" class="form-control" value="{{ $magang->tanggal_selesai }}" disabled>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <input type="text" class="form-control" value="{{ $magang->status }}" disabled>
                </div>
                <!-- <p>Tujuan surat: {{ $magang->tujuan_surat }}</p> -->
                <!-- <p>Alamat surat: {{ $magang->alamat_surat }}</p>
                <p>Tanggal Mulai: {{ $magang->tanggal_mulai }}</p>
                <p>Tanggal Selesai: {{ $magang->tanggal_selesai }}</p>
                <p>Status: {{ $magang->status }}</p> -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    @if($magang->status == 'Belum Diterima')
                    <form action="{{ route('terima-permohonan-magang', $magang->id_permohonan_magang) }}"
                        class="d-inline" method="post">
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
</div>