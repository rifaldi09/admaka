<div class="modal fade" id="detailModal-{{ $pp->id_permohonan }}" tabindex="-1" role="dialog"
    aria-labelledby="detailModalLabel-{{ $pp->id_permohonan }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel-{{ $pp->id_permohonan }}">Detail Permohonan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Tujuan Surat</label>
                        <input type="text" class="form-control" value="{{ $pp->tujuan_surat }}" disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Alamat Surat</label>
                        <input type="text" class="form-control" value="{{ $pp->alamat_surat }}" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label>Keperluan</label>
                    <input type="text" class="form-control"
                        value="{{ $pp->keperluan == 'mata_kuliah' ? 'Mata Kuliah' : 'Skripsi' }}" disabled>
                </div>

                @if($pp->keperluan == 'skripsi')
                <div class="form-group">
                    <label>Judul Skripsi</label>
                    <textarea class="form-control" disabled>{{ $pp->judul_skripsi }}</textarea>
                </div>
                @else
                <div class="form-group">
                    <label>Dosen Pengampu</label>
                    <input type="text" class="form-control" value="{{ $pp->dosen->nama }}" disabled>
                </div>
                @endif

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Tanggal Mulai</label>
                        <input type="date" class="form-control" value="{{ $pp->tanggal_mulai }}" disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tanggal Selesai</label>
                        <input type="date" class="form-control" value="{{ $pp->tanggal_selesai }}" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <input type="text" class="form-control" value="{{ $pp->status }}" disabled>
                </div>

                @if($pp->status == 'Ditolak')
                <div class="form-group">
                    <label>Alasan Ditolak</label>
                    <textarea class="form-control" disabled>{{ $pp->alasan_ditolak }}</textarea>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                @if($pp->status == 'Belum Diterima')
                <form action="{{ route('terima-permohonan-mahasiswa', $pp->id_permohonan) }}" class="d-inline"
                    method="post">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-success btn-setujui " title="Setujui" type="submit">
                        <i class="fa-solid fa-check"></i> Setujui Surat
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>