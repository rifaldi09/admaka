@extends('adminLTE.home')

@section('title', 'Dashboard Hak Akses')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Daftar Pengguna Hak Akses</h3>
        </div>
        <div class="card-body">
            <table id="example" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIM / NIDN</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataMhs as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $data->nim }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>Mahasiswa</td>
                            <td class="text-center">
                                {{-- sementara hanya ada tombol edit, yang lain menyusul --}}
                                <form action="{{ route('edit-hak-akses') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    {{-- menggunakan post untuk mmenjaga keamaan data user --}}
                                    <input type="hidden" name="id_user" value="{{ $data->nim }}">
                                    <button class="btn btn-warning btn-sm">Edit</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @foreach ($dataDsn as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $data->nidn }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>Dosen</td>
                            <td class="text-center">
                                {{-- sementara hanya ada tombol edit, yang lain menyusul --}}
                                <form action="{{ route('edit-hak-akses') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    {{-- menggunakan post untuk mmenjaga keamaan data user --}}
                                    <input type="hidden" name="id_user" value="{{ $data->nidn }}">
                                    <button class="btn btn-warning btn-sm">Edit</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection