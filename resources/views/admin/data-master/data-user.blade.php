@extends('dashboard.home')

@section('title', 'Data Master - Akun User')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Data User</h3>
    </div>
    <div class="card-body">
        {{-- <button class="btn btn-primary btn-sm mb-3" id="tambahUser" data-toggle="modal" data-target="#modalUser"><i
                class="fa-solid fa-plus"></i> Tambah Data</button> --}}

        {{-- Setup data for datatables --}}
        @php
        $heads = [
        'Id User',
        'Nama User',
        'Roles',

        ];

        $config = [
        'data' => $dataUserFormatted,
        'order' => [[1, 'asc']],
        'columns' => [null, null, null, null, ['orderable' => true]],
        ];
        @endphp

        {{-- Minimal example / fill data using the component slot --}}
        <x-adminlte-datatable id="tableUser" :heads="$heads">
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

{{-- INSERT DATA USER --}}
{{-- <x-adminlte-modal id="modalUser" title="Tambah User" v-centered static-backdrop scrollable>
    <form action="{{ route('add_user') }}" method="post" id="form-prodi" enctype="multipart/form-data">
@csrf
<div class="form-group">
    <x-adminlte-input type="text" label="Nama" name="nama" placeholder="Nama Prodi" required />
</div>
</form>
<x-slot name="footerSlot">
    <x-adminlte-button form="form-prodi" type="submit" class="mr-auto" theme="success" label="Save" />
    <x-adminlte-button theme="danger" label="Close" data-dismiss="modal" />
</x-slot>
</x-adminlte-modal> --}}

{{-- UPDATE DATA USER --}}
<x-adminlte-modal id="modalUpdateUser" title="Ubah Data User" v-centered static-backdrop scrollable>
    <form id='editFormUser' method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <x-adminlte-input type="text" label="Nama" name="nama" id="nama" placeholder="Nama User" required />
        </div>
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button form="editFormUser" type="submit" class="mr-auto" theme="success" label="Save" />
        <x-adminlte-button theme="danger" label="Close" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>

<script>
// Menambahkan sweetalert2 untuk konfirmasi hapus role
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-user');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            // Mencegah form terkirim langsung saat tombol klik
            event.preventDefault();

            const form = this.closest('form');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                icon: 'warning',
                text: "Data user yang dihapus tidak dapat lagi digunakan!",
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
    const editButtons = document.querySelectorAll('.update-user');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.key;
            // Ambil data via AJAX
            fetch(`update-user/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert('Data tidak ditemukan');
                        return;
                    }
                    // set data;
                    document.getElementById('nama').value = data.nama;

                    // Set form action
                    const form = document.getElementById('editFormUser');
                    form.action = `update_datauser/${id}`;

                    // Tampilkan modal
                    $('#modalUpdateUser').modal('show');
                })
                .catch(error => {
                    toastr.error("Terjadi kesalahan ketika mengambil data");
                });
        });
    });
});
</script>
@endsection