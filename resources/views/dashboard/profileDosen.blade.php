@extends('dashboard.home')

@section('title', 'Profil Dosen')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">{{ $titleHeader }}</h3>
    </div>
    <div class="card-body">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="biodata-tab" data-toggle="tab" data-target="#biodata" type="button"
                        role="tab" aria-controls="biodata" aria-selected="true">Biodata</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="password-tab" data-toggle="tab" data-target="#password" type="button"
                        role="tab" aria-controls="password" aria-selected="false">Ubah Password</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="biodata" role="tabpanel" aria-labelledby="biodata-tab">
                    <div class="mt-3">
                        <form action="{{ route('profil-dosen-update') }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="nidn" class="form-label">NIP</label>
                                        <input type="number" class="form-control" placeholder="NIP" name="nidn" id="nidn"
                                            value={{ old('nidn',$user->nidn) }} readonly disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nip" class="form-label">NUPTK</label>
                                        <input type="number" class="form-control" placeholder="NUPTK" name="nip" id="nip"
                                            value={{ old('nip',$user->nip) }} required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" placeholder="Nama Lengkap" name="nama" id="nama"
                                            value={{ old('nama',$user->nama) }}>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" placeholder="Email" name="email" id="email"
                                            value={{ old('email',$user->email) }}>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" placeholder="Tempat Lahir" name="tempat_lahir"
                                            id="tempat_lahir" value={{ old('tempat_lahir',$user->tempat_lahir) }}>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" placeholder="Tanggal Lahir" name="tanggal_lahir"
                                            id="tanggal_lahir" value={{ old('tanggal_lahir',$user->tanggal_lahir) }}>
                                    </div>
                                    <div class="mb-3">
                                        <label for="prodiId" class="form-label">Program Studi</label>
                                        <x-adminlte-select name="id_prodi" id="prodiId" class="form-select">
                                            <option>Pilih Program Studi</option>
                                            @foreach ($dataProdis as $prodi)
                                            @if (old('id_prodi',$user->id_prodi) == $prodi->id)
                                            <option value="{{ $prodi->id }}" selected>{{ $prodi->nama }}</option>
                                            @else
                                            <option value="{{ $prodi->id }}">{{ $prodi->nama }}</option>
                                            @endif
                                            @endforeach
                                        </x-adminlte-select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_hp" class="form-label">No HP</label>
                                        <input type="text" class="form-control" placeholder="No HP" name="no_hp" id="no_hp"
                                            value={{ old('no_hp',$user->no_hp) }}>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <button class="btn btn-primary btn-sm" type="submit">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                    <div class="mt-3">
                        <form action="{{ route('password-dosen-update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Password Lama</label>
                                        <input type="password" class="form-control" placeholder="Password Lama" name="current_password" id="current_password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Password Baru</label>
                                        <input type="password" class="form-control" placeholder="Password Baru" name="new_password" id="new_password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password_confirmation" class="form-label">Password Konfirmasi</label>
                                        <input type="password" class="form-control" placeholder="Password Konfirmasi" name="new_password_confirmation" id="new_password_confirmation">
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <button class="btn btn-primary btn-sm" type="submit">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
