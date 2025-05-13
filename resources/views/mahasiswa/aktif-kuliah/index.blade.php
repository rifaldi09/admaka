@extends('dashboard.home')

@section('title', 'Surat Aktif Kuliah')

@section('content')

    <div class="card mt-3">
        <div class="card-header">
            <h1 class="card-title font-weight-bold">Surat Aktif Kuliah</h1>
            <button type="button" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#exampleModal">
                <i class="fa-solid fa-square-plus fa-sm mr-2"></i>Ajukan Surat Baru
            </button>
        </div>
        <div class="card-body">

            @php
                $heads = [
                    ['label' => 'No', 'no-export' => true, 'width' => 1],
                    'Keperluan',
                    ['label' => 'Status', 'no-export' => true, 'width' => 8],
                    ['label' => 'Actions', 'no-export' => true, 'width' => 5],
                ];

                $config = [
                    'data' => $dataSuratFormatted,
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

    @include('mahasiswa.aktif-kuliah.modal.addSuratAktif')
    @include('mahasiswa.aktif-kuliah.modal.editSuratPenolakan')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle edit and reject button clicks
            $(document)
                .on('click', '.btn-edit', function() {
                    const data = $(this).data();

                    Object.keys(data).forEach(key => {
                        $(`#${key}-edit`).val(data[key]);
                    });
                })
        });
    </script>

@endsection
