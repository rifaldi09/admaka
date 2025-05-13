{{-- Modal ketika surat disetujui --}}
<div class="modal fade" id="modalDetailTerima" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <form action="{{ route('terima-aktif-kuliah') }}" class="modal-content" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{-- Content Persetujuan Surat Aktif Kuliaj --}}

                <input type="hidden" name="id" id="id-terima">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="id_user">NIM</label>
                        <input type="text" class="form-control"name="id_user" id="nim-terima" disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama-terima" name="nama" 
                            disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email-terima" name="email" 
                            disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="prodi">Program Studi</label>
                        <input type="text" class="form-control" id="prodi-terima" name="prodi"
                            disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir" id="tempatlhr-terima" disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggallhr-terima" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nohp">No Handphone</label>
                        <input type="text" class="form-control" name="nohp" id="nohp-terima" disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="status">Status</label>
                        <input type="text" class="form-control" name="status" id="status-terima" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="keperluan">Keperluan</label>
                    <textarea class="form-control" name="keperluan" id="keperluan-terima" disabled></textarea>
                </div>

            </div>
        </form>
    </div>
</div>
