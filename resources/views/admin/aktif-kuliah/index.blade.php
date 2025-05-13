{{-- ! MASIH BELUM SELESAI --}}
{{-- ! PROGRES 50%-70% --}}
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
                                ['label' => 'Status', 'no-export' => true, 'width' => 3],
                                'Tanggal Pengajuan',
                                ['label' => 'Actions', 'no-export' => true, 'width' => 7],
                                'Upload Surat',
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

    {{-- modal --}}
    @include('admin.aktif-kuliah.modal.tolak')
    @include('admin.aktif-kuliah.modal.detail')
    @include('admin.aktif-kuliah.modal.detailDiterima')
    @include('admin.aktif-kuliah.modal.upload')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle edit and reject button clicks
            $(document)
                .on('click', '.btn-edit', function() {
                    const data = $(this).data();
                    // console.log(data);
                    
                    Object.keys(data).forEach(key => {
                        $(`#${key}`).val(data[key]);
                    });
                })
                .on('click', '.btn-tolak', function() {
                    $('#id_tolak').val($(this).data('id'));
                })
                .on('click', '.btn-upload', function() {
                    $('#id_upload').val($(this).data('id'));
                    console.log($(this).data('id'));
                    
                });
            $(document)
                .on('click', '.btn-detail-terima', function() {
                    const data = $(this).data();
                    
                    Object.keys(data).forEach(key => {
                        $(`#${key}-terima`).val(data[key]);
                    });
                });

            // Handle confirmation actions
            $(document).on('click', '.btn-setujui, .tolak', function(e) {
                e.preventDefault();
                const form = $(this).closest('form')[0];
                const isApprove = $(this).hasClass('btn-setujui');

                // Validation for reject form
                if (!isApprove && !form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                Swal.fire({
                    title: 'Apakah Kamu Yakin?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: isApprove ? '#14A44D' : '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: isApprove ? 'Ya, setujui suratnya' : 'Ya, tolak suratnya',
                    cancelButtonText: 'Batal'
                }).then((result) => result.isConfirmed && form.submit());
            });

            $(document).on('click', '.penerbitan', function(e) {
                e.preventDefault();
                const form = $(this).closest('form')[0];

                Swal.fire({
                    title: 'Apakah Kamu Yakin?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#14A44D',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Terbitkan Surat Ini',
                    cancelButtonText: 'Batal'
                }).then((result) => result.isConfirmed && form.submit());
            });
        });
    </script>

@endsection
