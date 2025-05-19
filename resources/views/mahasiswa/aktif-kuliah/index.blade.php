@extends('dashboard.home')

@section('title', 'Surat Aktif Kuliah')

@section('content')

    <div class="card mt-3">
        <div class="card-header">
            <h1 class="card-title font-weight-bold">Surat Aktif Kuliah</h1>
            <button type="button" class="btn btn-primary float-right btn-sm" data-toggle="modal"
                data-target="#modalTambahSuratAktif">
                <i class="fa-solid fa-square-plus fa-sm mr-2"></i>Ajukan Surat Baru
            </button>
        </div>
        <div class="card-body">

            @php
                $heads = [
                    ['label' => 'No', 'no-export' => true, 'width' => 1],
                    'Keperluan',
                    ['label' => 'Status', 'no-export' => true, 'width' => 13],
                    ['label' => 'Actions', 'no-export' => true, 'width' => 5],
                ];
            @endphp

            <x-adminlte-datatable id="table1" :heads="$heads">
                @foreach ($dataSurat as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data->keperluan }}</td>
                        <td>
                            @switch($data->status)
                                @case('Diterima')
                                    <div class="border border-success btn-sm text-success text-center">{{ $data->status }}</div>
                                @break

                                @case('Ditolak')
                                    <div class="border border-danger btn-sm text-danger text-center">{{ $data->status }}</div>
                                @break

                                @case('Penerbitan')
                                    <div class="border border-primary btn-sm text-primary text-center">{{ $data->status }}</div>
                                @break

                                @default
                                    <div class="border border-warning btn-sm text-warning text-center">{{ $data->status }}</div>
                            @endswitch
                        </td>
                        <td>
                            <nobr>
                                @if ($data->status == 'Ditolak')
                                    <button class="btn btn-default text-warning btn-edit" data-toggle="modal"
                                        data-target="#modalEdit-{{ $data->id_aktif_kuliah }}" title="Edit"><i
                                            class="fa-solid fa-pen-to-square"></i>
                                        Edit</button>
                                @elseif($data->status == 'Penerbitan')
                                    @foreach ($data->filePengajuan as $path)
                                        <form action="{{ route('unduh-pdf-surat-aktif-kuliah') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" value="{{ encrypt($data->id_aktif_kuliah) }}"
                                                name="id">
                                            <button class="btn btn-default text-primary" title="Unduh"><i
                                                    class="fa-solid fa-download"></i> Unduh</button>
                                        </form>
                                    @endforeach
                                @endif
                            </nobr>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>

        </div>
    </div>
    @include('mahasiswa.aktif-kuliah.modal.addSuratAktif')
    @foreach ($dataSurat as $data)
        @include('mahasiswa.aktif-kuliah.modal.editSuratPenolakan', ['data' => $data])
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $(document).on('click', '.btn-edit-save', function(e) {
                e.preventDefault();
                const form = $(this).closest('form')[0];

                Swal.fire({
                    title: 'Apakah Kamu Yakin?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#14A44D',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Ubah surat ini',
                    cancelButtonText: 'Batal'
                }).then((result) => result.isConfirmed && form.submit());
            });
        });
    </script>

@endsection
