@extends('dashboard.home')

@section('title', 'Data Master')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Data Dosen dan Mahasiswa</h3>
    </div>
    <div class="card-body">
        <!-- Tabs Navigasi -->
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-mhs-tab" data-toggle="tab" data-target="#nav-mhs" type="button"
                    role="tab" aria-controls="nav-mhs" aria-selected="true">Mahasiswa</button>
                <button class="nav-link" id="nav-dsn-tab" data-toggle="tab" data-target="#nav-dsn" type="button"
                    role="tab" aria-controls="nav-dsn" aria-selected="false">Dosen</button>
            </div>
        </nav>
        <!-- Konten Tab -->
        <div class="tab-content" id="nav-tabContent">
            <!-- Tab Mahasiswa -->
            <div class="tab-pane fade show active" id="nav-mhs" role="tabpanel" aria-labelledby="nav-mhs-tab">
                <br>
                <button class="btn btn-primary btn-sm" id="tambahMhs" data-toggle="modal" data-target="#modalMhs"><i
                        class="fa-solid fa-plus"></i> Tambah
                    Data</button>
                <button class="btn btn-success btn-sm" id="importMhs"><i class="fa-solid fa-arrow-up-from-bracket"></i>
                    Import Data</button>
                <br><br>

                {{-- Setup data for datatables --}}
                @php
                $heads = [
                'NIM',
                'Nama',
                'Email',
                'No HP',
                ['label' => 'Actions', 'no-export' => true, 'width' => 5],
                ];

                $btnEdit = '<button class="btn btn-sm btn-default text-primary  " title="Edit">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                </button>';
                $btnDelete = '<button class="btn btn-sm btn-default text-danger  " title="Delete">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>';
                $btnDetails = '<button class="btn btn-sm btn-default text-teal  " title="Details">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </button>';

                $config = [
                'data' => [
                ],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, ['orderable' => true]],
                ];
                @endphp

                {{-- Minimal example / fill data using the component slot --}}
                <x-adminlte-datatable id="table1" :heads="$heads">
                    @foreach($config['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td>{!! $cell !!}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </x-adminlte-datatable>


            </div>
            <!-- Tab Dosen -->
            <div class="tab-pane fade" id="nav-dsn" role="tabpanel" aria-labelledby="nav-dsn-tab">
                <br>
                <button class="btn btn-primary btn-sm" id="tambahDsn"><i class="fa-solid fa-plus"></i> Tambah
                    Data</button>
                <button class="btn btn-success btn-sm" id="importDsn"><i class="fa-solid fa-arrow-up-from-bracket"></i>
                    Import Data</button>
                <br><br>
                {{-- Setup data for datatables --}}
                @php
                $heads = [
                'NIM',
                'Nama',
                'Email',
                'No HP',
                ['label' => 'Actions', 'no-export' => true, 'width' => 5],
                ];

                $btnEdit = '<button class="btn btn-sm btn-default text-primary  " title="Edit">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                </button>';
                $btnDelete = '<button class="btn btn-sm btn-default text-danger  " title="Delete">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>';
                $btnDetails = '<button class="btn btn-sm btn-default text-teal  " title="Details">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </button>';

                $config = [
                'data' => [
                ],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, ['orderable' => true]],
                ];
                @endphp

                {{-- Minimal example / fill data using the component slot --}}
                <x-adminlte-datatable id="table2" :heads="$heads">
                    @foreach($config['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td>{!! $cell !!}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>

        </div>
    </div>
</div>
{{-- INSERT DATA MAHASISWA --}}
<x-adminlte-modal id="modalMhs" title="Tambah Mahasiswa">
    <form>

        <div class="form-group">
            <x-adminlte-input type="text" label="NIM" name="nim" placeholder="NIM" required />
        </div>
        <div class="form-group">
            <x-adminlte-input type="text" label="Nama" name="nama" placeholder="Nama" required />
        </div>
        <div class="form-group">
            <x-adminlte-select name="prodi" label="Prodi" required>
                <x-adminlte-options :options="$dataProdi" disabled="1" empty-option="Select an option..." />
            </x-adminlte-select>
        </div>
        <div class="form-group">
            <x-adminlte-input type="text" label="Tempat Lahir" name="tempat_lahir" placeholder="Tempat Lahir"
                required />
        </div>
        <div class="form-group">
            <x-adminlte-input type="date" label="Tanggal Lahir" name="tanggal_lahir" placeholder="Tanggal Lahir"
                required />
        </div>
        <div class="form-group">
            <x-adminlte-input type="email" label="Email" name="email" placeholder="Email" required />
        </div>
        <div class="form-group">
            <x-adminlte-input type="number" label="No HP" name="email" placeholder="No HP" required />
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Save" />
            <x-adminlte-button theme="danger" label="Close" data-dismiss="modal" />
        </x-slot>
    </form>
</x-adminlte-modal>
@endsection