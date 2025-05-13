@extends('dashboard.home')

@section('title', 'Dashboard Manajemen Menu')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Daftar Menu</h3>
    </div>
    <div class="card-body">
        <button class="btn btn-primary btn-sm" id="tambahMenu" data-toggle="modal" data-target="#modalMenu"><i
                class="fa-solid fa-plus"></i> Tambah
            Data</button>
        <br><br>

        {{-- Setup data for datatables --}}
        @php $heads=[ 'Kelompok Menu' , 'Header', 'Nama Menu', ['label'=> 'Actions', 'no-export' =>
        true, 'width' => 5],
        ];

        $config = [
        'data' => $dataMenuFormatted,
        'order' => [[1, 'asc']],
        'columns' => [null, null, ['orderable' => true]],
        ];
        @endphp

        {{-- Minimal example / fill data using the component slot --}}
        <x-adminlte-datatable id="example" :heads="$heads">
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
{{-- INSERT DATA MENU --}}
<x-adminlte-modal id="modalMenu" title="Tambah Menu" v-centered static-backdrop scrollable>
    <form action="{{ route('store-menu') }}" method="post" id="form-menu" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <x-adminlte-input type="text" label="Kelompok Menu" name="kelompok_menu" placeholder="Kelompok Menu"
                required />
        </div>
        <div class="form-group">
            <x-adminlte-input type="text" label="Header" name="header" placeholder="Header" required />
        </div>
        <div class="form-group">
            <x-adminlte-input type="text" label="Nama Menu" name="menu" placeholder="Nama Menu" required />
        </div>
        <div class="form-group">
            <x-adminlte-input type="text" label="URL" name="url" placeholder="URL" required />
        </div>
        <div class="form-group">
            <x-adminlte-input type="text" label="Icon" name="icon" placeholder="Icon" required />
        </div>
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button form="form-menu" type="submit" class="mr-auto" theme="success" label="Save" />
        <x-adminlte-button theme="danger" label="Close" data-dismiss="modal" />
    </x-slot>

</x-adminlte-modal>

{{-- UPDATE DATA MENU --}}
<x-adminlte-modal id="modalUpdateMenu" title="Ubah Data Menu" v-centered static-backdrop scrollable>
    <form id='editFormMenu' method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <x-adminlte-input type="text" label="Kelompok Menu" name="kelompok_menu1" id="kelompok_menu1"
                placeholder="Kelompok Menu" required />
        </div>
        <div class="form-group">
            <x-adminlte-input type="text" label="Header" name="header1" id="header1" placeholder="Header" required />
        </div>
        <div class="form-group">
            <x-adminlte-input type="text" label="Nama Menu" name="menu1" id="menu1" placeholder="Nama Menu" required />
        </div>
        <div class="form-group">
            <x-adminlte-input type="text" label="URL" name="url1" id="url1" placeholder="URL" required />
        </div>
        <div class="form-group">
            <x-adminlte-input type="text" label="Icon" name="icon1" id="icon1" placeholder="Icon" required />
        </div>
    </form>
    <x-slot name="footerSlot">
        <x-adminlte-button form="editFormMenu" type="submit" class="mr-auto" theme="success" label="Save" />
        <x-adminlte-button theme="danger" label="Close" data-dismiss="modal" />
    </x-slot>

</x-adminlte-modal>

<script>
// Menambahkan sweetalert2 untuk konfirmasi hapus role
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delet-menu');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Mencegah form terkirim langsung saat tombol klik
            event.preventDefault();
            const form = this.closest('form');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                icon: 'warning',
                text: "Data yang dihapus termasuk juga dengan hak akses!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.update-menu');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.key;
            // Ambil data via AJAX
            fetch(`edit-menu/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert('Data tidak ditemukan');
                        return;
                    }
                    // set data;
                    document.getElementById('kelompok_menu1').value = data.kelompok_menu;
                    document.getElementById('header1').value = data.header;
                    document.getElementById('menu1').value = data.menu;
                    document.getElementById('url1').value = data.url;
                    document.getElementById('icon1').value = data.icon;

                    // Set form action
                    const form = document.getElementById('editFormMenu');
                    form.action = `update-menu/${id}`;

                    // Tampilkan modal
                    $('#modalUpdateMenu').modal('show');
                })
                .catch(error => {
                    toastr.error("Terjadi kesalahan ketika mengambil data");
                });
        });
    });
});
</script>
@endsection