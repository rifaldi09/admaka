    <div class="modal fade" id="permohonanModal" tabindex="-1" role="dialog" aria-labelledby="permohonanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permohonanModalLabel">Buat Permohonan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('create-permohonan-mahasiswa') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <label for="tujuan_surat">Kepada Yth</label>
                        <input type="text" name="tujuan surat" id="tanggal_mulai" class="form-control mb-3" required>
                        <label for="alamat_surat">Alamat Surat</label>
                        <textarea name="alamat_surat" id="alamat_surat" cols="30" rows="2" class="form-control mb-3"
                            required></textarea>
                        <label for="keperluan">Keperluan</label>
                        <select name="keperluan" id="keperluan" class="form-control mb-3" required>
                            <option value="skripsi">Skripsi</option>
                            <option value="mata_kuliah">Mata Kuliah</option>
                        </select>
                        <div id="judul_skripsi" class="d-none">
                            <label for="judul_skripsi">Judul Skripsi</label>
                            <textarea name="judul_skripsi" id="judul_skripsi" cols="30" rows="2"
                                class="form-control mb-3"></textarea>
                        </div>
                        <div id="matkul" class="d-none">
                            <label for="dosen">Dosen Pengampu</label>
                            <select name="dosen" id="dosen" class="form-control mb-3" required>
                                @foreach ($dosen as $detail)
                                <option value="{{ $detail->dataDosen->nip }}">{{ $detail->dataDosen->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control mb-3" required>
                        <label for="tanggal_selesai">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control mb-3"
                            required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
    <script>
$(document).ready(function() {
    $('#keperluan').on('change', function() {
        const keperluan = $(this).val();

        if (keperluan === 'skripsi') {
            $('#judul_skripsi').removeClass('d-none');
            $('#matkul').addClass('d-none');
        } else {
            $('#judul_skripsi').addClass('d-none');
            $('#matkul').removeClass('d-none');
        }
    });

    $('#permohonanModal').on('shown.bs.modal', function() {
        $('#keperluan').trigger('change');
    });
});
    </script>
    @endpush