@extends('dashboard.home')

@section('title', 'Dashboard Hak Akses')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Daftar Pengguna Hak Akses</h3>
    </div>
    <div class="card-body">
        <a href="#" class="btn btn-primary mb-1" data-toggle="modal" data-target="#exampleModal"><i
                class="fa-solid fa-plus"></i> Tambahkan Role</a>
        <br><br>
        {{-- Setup data for datatables --}}
        @php $heads=[ '#' , 'Nama Role' , ['label'=> 'Actions', 'no-export' =>
        true, 'width' => 5],
        ];

        $config = [
        'data' => $dataRoleFormatted,
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

        {{-- Modal Untuk Menambahkan Role --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Role Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('store-role') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <label for="nama_role">Nama Role Baru</label>
                            <input type="text" class="form-control" id="nama_role" name="nama_role"
                                placeholder="Nama Role" required>
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