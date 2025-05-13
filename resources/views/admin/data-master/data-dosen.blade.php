@extends('dashboard.home')

@section('title', 'Data Master - Dosen')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Data Dosen</h3>
    </div>
    <div class="card-body">
        <button class="btn btn-primary btn-sm" id="tambahDosen" data-toggle="modal" data-target="#modalDosen"><i
                class="fa-solid fa-plus"></i> Tambah
            Data</button>
        <button class="btn btn-success btn-sm" id="importDosen" data-toggle="modal" data-target="#import-Dosen"><i
                class="fa-solid fa-arrow-up-from-bracket"></i>
            Import Data</button>
        <br><br>

        {{-- Setup data for datatables --}}
        @php
        $heads = [
        'NIDN/NUPTK',
        'NIP',
        'Nama',
        'Email',
        'No HP',
        ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        $config = [
        'data' => $dataDosenFormatted,
        'order' => [[1, 'asc']],
        'columns' => [null, null, null, null, ['orderable' => true]],
        ];
        @endphp

        {{-- Minimal example / fill data using the component slot --}}
        <x-adminlte-datatable id="tableDosen" :heads="$heads">
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
<x-adminlte-modal id="modalDosen" title="Tambah Dosen" v-centered static-backdrop scrollable>
    <form action="{{ route('add_dosen') }}" method="post" id="form-dosen" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <x-adminlte-input type="text" label="NIDN/NUPTK" name="nidn" placeholder="NIDN/NUPTK" required />
        </div>
        <div class="form-group">
            <x-adminlte-input type="text" label="NIP" name="nip" placeholder="NIP" required />
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
        <x-adminlte-button form="form-dosen" type="submit" class="mr-auto" theme="success" label="Save" />
        <x-adminlte-button theme="danger" label="Close" data-dismiss="modal" />
    </x-slot>

</x-adminlte-modal>
{{-- UPDATE DATA DOSEN --}}
<x-adminlte-modal id="modalUpdateDosen" title="Ubah Data Dosen" v-centered static-backdrop scrollable>
    <form id='editFormDosen' method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <x-adminlte-input type="text" label="NIP" name="nip1" id="nip1" placeholder="NIP" required />
        </div>
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
        <x-adminlte-button form="editFormDosen" type="submit" class="mr-auto" theme="success" label="Save" />
        <x-adminlte-button theme="danger" label="Close" data-dismiss="modal" />
    </x-slot>

</x-adminlte-modal>

{{-- IMPORT --}}
<x-adminlte-modal id="import-Dosen" title="Import Data Dosen" v-centered static-backdrop scrollable>
    <form action="{{ route('dosen-preview') }}" method="post" id="import-dosen" enctype="multipart/form-data">
        @csrf
        <label for="file">Upload file (.csv)</label>
        <input type="file" name="file" class="form-control" id="file" accept=".csv" required>
    </form>
    <a href="{{ asset('template/template_dosen.csv') }}" class="btn btn-link" download>Donwload Template</a>
    <x-slot name="footerSlot">
        <x-adminlte-button form="import-dosen" type="submit" class="mr-auto" theme="success" label="Save" />
        <x-adminlte-button theme="danger" label="Close" data-dismiss="modal" />
    </x-slot>

</x-adminlte-modal>
<script>
// Menambahkan sweetalert2 untuk konfirmasi hapus role
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delet-dosen');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            // Mencegah form terkirim langsung saat tombol klik
            event.preventDefault();

            const form = this.closest('form');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                icon: 'warning',
                text: "Data yang dihapus termasuk juga dengan user login dan NIDN/NUPTK tidak dapat lagi digunakan!",
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
    const editButtons = document.querySelectorAll('.update-dosen');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const nidn = this.dataset.key;
            // Ambil data via AJAX
            fetch(`update-dosen/${nidn}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert('Data tidak ditemukan');
                        return;
                    }
                    // set data;
                    document.getElementById('nip1').value = data.nip;
                    document.getElementById('prodi1').value = data.id_prodi;
                    document.getElementById('nama1').value = data.nama;
                    document.getElementById('tempat_lahir1').value = data.tempat_lahir;
                    document.getElementById('tanggal_lahir1').value = data.tanggal_lahir;
                    document.getElementById('email1').value = data.email;
                    document.getElementById('no_hp1').value = data.no_hp;

                    // Set form action
                    const form = document.getElementById('editFormDosen');
                    form.action = `update_datadosen/${nidn}`;

                    // Tampilkan modal
                    $('#modalUpdateDosen').modal('show');
                })
                .catch(error => {
                    toastr.error("Terjadi kesalahan ketika mengambil data");
                });
        });
    });
});
</script>
@endsection