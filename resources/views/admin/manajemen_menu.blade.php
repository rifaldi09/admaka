@extends('dashboard.home')

@section('title', 'Dashboard Manajemen Menu')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Daftar Menu</h3>
    </div>
    <div class="card-body">
        <a href="#" class="btn btn-primary mb-1" data-toggle="modal" data-target="#exampleModal"><i
                class="fa-solid fa-plus"></i> Tambahkan Menu</a>
        <br><br>

        {{-- Setup data for datatables --}}
        @php $heads=[ '#' , 'Kelompok Menu' , 'Header', 'Nama Menu', ['label'=> 'Actions', 'no-export' =>
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

        {{-- Modal Untuk Menambahkan Menu --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Menu Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('store-menu') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <label for="kelompok_menu">Kelompok Menu</label>
                            <input type="text" class="form-control" id="kelompok_menu" name="kelompok_menu"
                                placeholder="Kelompok Menu" required>
                        </div>
                        <div class="modal-body">
                            <label for="header">Header</label>
                            <input type="text" class="form-control" id="header" name="header"
                                placeholder="Header" required>
                        </div>
                        <div class="modal-body">
                            <label for="menu">Nama Menu</label>
                            <input type="text" class="form-control" id="menu" name="menu"
                                placeholder="Nama Menu" required>
                        </div>
                        <div class="modal-body">
                            <label for="url">Link</label>
                            <input type="text" class="form-control" id="url" name="url"
                                placeholder="Link Menu" required>
                        </div>
                        <div class="modal-body">
                            <label for="icon">Icon Menu</label>
                            <input type="text" class="form-control" id="icon" name="icon"
                                placeholder="Icon Menu" required>
                        </div>
                        <div class="modal-footer">
                            <button type="sumbit" class="btn btn-primary"><i class="fa-solid fa-plus"></i>
                                Tambahkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Menambahkan sweetalert2 untuk konfirmasi hapus role
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-danger');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
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

@endsection
