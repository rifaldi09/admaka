@extends('dashboard.home')

@section('title', 'Data Master - Dosen')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">{{ $titleHeader }}</h3>
    </div>
    <div class="card-body">
        <button class="btn btn-primary btn-sm" id="tambahDosen" data-toggle="modal" data-target="#modalDosen"><i
                class="fa-solid fa-plus"></i> Tambah
            Data</button>
        <button class="btn btn-success btn-sm" id="importDosen"><i class="fa-solid fa-arrow-up-from-bracket"></i>
            Import Data</button>
        <br><br>

        {{-- Setup data for datatables --}}
        @php
        $heads = [
        'NIDN',
        'NIP',
        'Nama',
        'Email',
        'No HP',
        ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        $config = [
        'data' => $dataDosenFormatted,
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
</div>

{{-- INSERT DATA DOSEN --}}
{{-- <x-adminlte-modal id="modalMhs" title="Tambah Mahasiswa" v-centered static-backdrop scrollable>
    <form action="{{ route('add_mhs') }}" method="post" id="form-mhs" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <x-adminlte-input type="text" label="NIM" name="nim" placeholder="NIM" required />
        </div>
        <div class="form-group">
            <x-adminlte-input type="text" label="Nama" name="nama" placeholder="Nama" required />
        </div>
        <div class="form-group">
            <x-adminlte-select name="prodi" label="Prodi" required>
                <x-adminlte-options :options="$dataProdi" empty-option="Select an option..." />
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
            <x-adminlte-input type="number" label="No HP" name="no_hp" placeholder="No HP" required />
        </div>
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button form="form-mhs" type="submit" class="mr-auto" theme="success" label="Save" />
        <x-adminlte-button theme="danger" label="Close" data-dismiss="modal" />
    </x-slot>

</x-adminlte-modal> --}}
@endsection
