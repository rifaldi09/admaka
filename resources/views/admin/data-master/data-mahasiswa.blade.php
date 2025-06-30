@extends('dashboard.home')

@section('title', 'Data Master - Mahasiswa')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Data Mahasiswa</h3>
    </div>
    <div class="card-body">
        <!-- Tab Mahasiswa -->
        <button class="btn btn-primary btn-sm" id="tambahMhs" data-toggle="modal" data-target="#modalMhs"><i
                class="fa-solid fa-plus"></i> Tambah
            Data</button>
        <button class="btn btn-success btn-sm" id="importMhs" data-toggle="modal" data-target="#import-Mhs"><i
                class="fa-solid fa-arrow-up-from-bracket"></i>
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

        $config = [
        'data' => $dataMhsFormatted,
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
{{-- INSERT DATA MAHASISWA --}}
<x-adminlte-modal id="modalMhs" title="Tambah Mahasiswa" v-centered static-backdrop scrollable>
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

</x-adminlte-modal>

{{-- UPDATE DATA MAHASISWA --}}
<x-adminlte-modal id="modalUpdateMhs" title="Ubah Data Mahasiswa" v-centered static-backdrop scrollable>
    <form id='editForm' method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <x-adminlte-input type="text" label="Nama" name="nama1" id="nama1" placeholder="Nama" required />
        </div>
        <div class="form-group">
            <x-adminlte-select name="prodi1" id="prodi1" label="Prodi" required>
                <x-adminlte-options :options="$dataProdi" empty-option="Select an option..." />
            </x-adminlte-select>
        </div>
        <div class="form-group">
            <x-adminlte-input type="text" label="Tempat Lahir" name="tempat_lahir1" id="tempat_lahir1"
                placeholder="Tempat Lahir" required />
        </div>
        <div class="form-group">
            <x-adminlte-input type="date" label="Tanggal Lahir" name="tanggal_lahir1" id="tanggal_lahir1"
                placeholder="Tanggal Lahir" required />
        </div>
        <div class="form-group">
            <x-adminlte-input type="email" label="Email" name="email1" id="email1" placeholder="Email" required />
        </div>
        <div class="form-group">
            <x-adminlte-input type="number" label="No HP" name="no_hp1" id="no_hp1" placeholder="No HP" required />
        </div>
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button form="editForm" type="submit" class="mr-auto" theme="success" label="Save" />
        <x-adminlte-button theme="danger" label="Close" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>

{{-- IMPORT --}}
<x-adminlte-modal id="import-Mhs" title="Import Data Mahasiswa" v-centered static-backdrop scrollable>
    <form action="{{ route('mhs-preview') }}" method="post" id="import-mhs" enctype="multipart/form-data">
        @csrf
        <label for="file">Upload file (.csv)</label>
        <input type="file" name="file" class="form-control" id="file" accept=".csv" required>
    </form>
    <a href="{{ asset('template/template_mahasiswa.csv') }}" class="btn btn-link" download>Donwload Template</a>
    <x-slot name="footerSlot">
        <x-adminlte-button form="import-mhs" type="submit" class="mr-auto" theme="success" label="Save" />
        <x-adminlte-button theme="danger" label="Close" data-dismiss="modal" />
    </x-slot>

</x-adminlte-modal>

<script>
// Menambahkan sweetalert2 untuk konfirmasi hapus role
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delet-mhs');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            // Mencegah form terkirim langsung saat tombol klik
            event.preventDefault();

            const form = this.closest('form');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                icon: 'warning',
                text: "Data yang dihapus termasuk juga dengan user login dan NIM tidak dapat lagi digunakan!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                // Hanya kirim form jika konfirmasi diterima
                if (result.isConfirmed) {
                    form.submit(); // Kirim form jika konfirmasi diterima
                }
            });
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.update-mhs');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const nim = this.dataset.key;
            // Ambil data via AJAX
            fetch(`update-mhs/${nim}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert('Data tidak ditemukan');
                        return;
                    }
                    // set data;
                    document.getElementById('prodi1').value = data.id_prodi;
                    document.getElementById('nama1').value = data.nama;
                    document.getElementById('tempat_lahir1').value = data.tempat_lahir;
                    document.getElementById('tanggal_lahir1').value = data.tanggal_lahir;
                    document.getElementById('email1').value = data.email;
                    document.getElementById('no_hp1').value = data.no_hp;

                    // Set form action
                    const form = document.getElementById('editForm');
                    form.action = `update_datamhs/${nim}`;

                    // Tampilkan modal
                    $('#modalUpdateMhs').modal('show');
                })
                .catch(error => {
                    toastr.error("Terjadi kesalahan ketika mengambil data");
                });
        });
    });
});
</script>

@endsection
