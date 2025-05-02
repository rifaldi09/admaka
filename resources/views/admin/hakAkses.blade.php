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
            <table id="example" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Mengambil dataRole dari AdminController --}}
                    @foreach ($dataRole as $key => $data)
                        <tr>
                            <td class="col-1">{{ $key + 1 }}</td>
                            <td class="col-7">{{ $data->name_role }}</td>
                            <td class="d-flex justify-content-around">

                                {{-- sementara hanya ada tombol edit dan hapus, yang lain menyusul --}}
                                {{-- Tombol Edit Role --}}
                                <form class="m-0 p-0" action="{{ route('edit-hak-akses', encrypt($data->id)) }}"
                                    method="get" enctype="multipart/form-data">
                                    @csrf
                                    {{-- menggunakan post untuk mmenjaga keamaan data user --}}
                                    <button class="btn btn-warning btn-sm" title="Edit"><i class="fa-solid fa-pencil"></i>
                                        Edit</button>
                                </form>

                                {{-- Tombol Hapus Role --}}
                                {{-- data dikirim dengan di enkripsikan untuk menjaga keamanan --}}
                                <form class="m-0 p-0" action="{{ route('destroy-role', encrypt($data->id)) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    <button type="button" class="btn btn-danger btn-sm" title="Hapus"><i
                                            class="fa-solid fa-trash fa-sm"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

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
