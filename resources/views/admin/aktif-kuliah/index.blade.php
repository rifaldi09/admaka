{{--! MASIH BELUM SELESAI --}}
{{--! PROGRES 50%-70% --}}
@extends('dashboard.home')

@section('title', 'Surat Aktif Kuliah')

@section('content')

    <div class="card mt-3">
        <div class="card-header">
            <h1 class="card-title font-weight-bold">Surat Aktif Kuliah</h1>
        </div>
        <div class="card-body">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button"
                        role="tab" aria-controls="home" aria-selected="true">Surat Masuk</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button"
                        role="tab" aria-controls="profile" aria-selected="false">Surat Disetujui</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="mt-3">

                        {{-- table untuk surat yang masih belum disetujui --}}
                        @php
                            $heads = [
                                ['label' => 'NIM', 'no-export' => true, 'width' => 10],
                                'Nama',
                                'Prodi',
                                ['label' => 'Status', 'no-export' => true, 'width' => 5],
                                'Tanggal Pengajuan',
                                ['label' => 'Actions', 'no-export' => true, 'width' => 7],
                            ];

                            $config = [
                                'data' => $dataBelumDisetujui,
                                'order' => [[1, 'asc']],
                                'columns' => [null, null, null, ['orderable' => true]],
                            ];
                        @endphp

                        <x-adminlte-datatable id="table1" :heads="$heads">
                            @foreach ($config['data'] as $row)
                                <tr>
                                    @foreach ($row as $cell)
                                        <td>{!! $cell !!}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </x-adminlte-datatable>
                    </div>
                </div>

                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="mt-3">

                        {{-- table untuk surat yang sudah disetujui/ditolak --}}
                        @php
                            $heads = [
                                ['label' => 'NIM', 'no-export' => true, 'width' => 10],
                                'Nama',
                                'Prodi',
                                ['label' => 'Status', 'no-export' => true, 'width' => 5],
                                'Tanggal Pengajuan',
                                ['label' => 'Actions', 'no-export' => true, 'width' => 7],
                            ];

                            $config = [
                                'data' => $dataDisetujui,
                                'order' => [[1, 'asc']],
                                'columns' => [null, null, null, ['orderable' => true]],
                            ];
                        @endphp

                        <x-adminlte-datatable id="table2" :heads="$heads">
                            @foreach ($config['data'] as $row)
                                <tr>
                                    @foreach ($row as $cell)
                                        <td>{!! $cell !!}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </x-adminlte-datatable>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Modal ketika surat ditolak --}}
    <div class="modal fade" id="modalTolak" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">

            <form action="{{ route('tolak-aktif-kuliah') }}" class="modal-content" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Surat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{-- Content Penolakan Surat Aktif Kuliah --}}
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="keperluan">Alasan</label>
                        {{-- alasan/deskripsi surat di tolak --}}
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="6" required></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                    {{-- button untuk memunculkan modal ketika surat ingin di tolak --}}
                    <button type="button" class="btn btn-danger btn-tolak"><i class="fa-solid fa-xmark"></i> Tolak
                        Surat</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal ketika surat disetujui --}}
    <div class="modal fade" id="modalLihat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">

            <form action="{{ route('terima-aktif-kuliah') }}" class="modal-content" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Surat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{-- Content Persetujuan Surat Aktif Kuliaj --}}

                    <input type="hidden" name="id" id="id">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="id_user">NIM</label>
                            <input type="text" class="form-control"name="id_user" id="nim" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" id="nama"
                                disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" id="email"
                                disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="prodi">Program Studi</label>
                            <input type="text" class="form-control" id="prodi" name="prodi" id="prodi"
                                disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" class="form-control" name="tempat_lahir" id="tempatLhr" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" id="tanggalLhr" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nohp">No Handphone</label>
                            <input type="text" class="form-control" name="nohp" id="nohp" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="status">Status</label>
                            <input type="text" class="form-control" name="status" id="status" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keperluan">Keperluan</label>
                        <textarea class="form-control" id="keperluan" name="keperluan" id="keperluan" disabled></textarea>
                    </div>
                    <div class="form-group">
                        <label for="keperluan">Alasan <small
                                style="font-size: 11px; color: red">*opsional</small></label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                    {{-- button untuk memunculkan modal ketika mau di setujui --}}
                    <button type="button" class="btn btn-success btn-setujui"><i class="fa-solid fa-check"></i> Setujui
                        Surat</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // memasukkan data ke dalam modal ketika tombol edit diklik
            $(document).on('click', '.btn-edit', function() {
                const id = $(this).data('id');
                const nim = $(this).data('nim');
                const nama = $(this).data('nama');
                const prodi = $(this).data('prodi');
                const keperluan = $(this).data('keperluan');
                const deskripsi = $(this).data('deskripsi');
                const email = $(this).data('email');
                const nohp = $(this).data('nohp');
                const status = $(this).data('status');
                const tempatLhr = $(this).data('tempatlhr');
                const tanggalLhr = $(this).data('tanggallhr');

                // Isi ke dalam form modal
                $('#id').val(id);
                $('#nim').val(nim);
                $('#nama').val(nama);
                $('#prodi').val(prodi);
                $('#keperluan').val(keperluan);
                $('#deskripsi').val(deskripsi);
                $('#email').val(email);
                $('#nohp').val(nohp);
                $('#status').val(status);
                $('#tempatLhr').val(tempatLhr);
                $('#tanggalLhr').val(tanggalLhr);
            });

            // memanggil class dari tombol setujui dan tolak dari modal
            const confirmButtons = document.querySelectorAll('.btn-setujui');
            const rejectButtons = document.querySelectorAll('.btn-tolak');

            // sweet alert ketika tombol setujui
            confirmButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Apakah Kamu Yakin?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#14A44D',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, setujui suratnya',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // sweet alert ketika tombol tolak
            rejectButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Apakah Kamu Yakin?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, tolak suratnya',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

        });
    </script>

@endsection
