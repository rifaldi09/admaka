@extends('dashboard.home')

@section('title', 'Profil Mahasiswa')

@section('content')
{{-- <p>{{ Auth::user()->data }}</p> --}}
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">{{ $titleHeader }}</h3>
    </div>
    <div class="card-body">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="biodata-tab" data-toggle="tab" data-target="#biodata"
                        type="button" role="tab" aria-controls="biodata" aria-selected="true">Biodata</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="password-tab" data-toggle="tab" data-target="#password" type="button"
                        role="tab" aria-controls="password" aria-selected="false">Ubah Password</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="biodata" role="tabpanel" aria-labelledby="biodata-tab">
                    <div class="mt-3">
                        <form action="{{ route('profil-mahasiswa-update') }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-6">
                                    <input type="hidden" name="nim" value="{{ old('nim',$user->nim) }}">
                                    <div class="mb-3">
                                        <label for="nim" class="form-label">NIM</label>
                                        <input type="text" class="form-control" placeholder="NIM" required readonly
                                            disabled value="{{ old('nim',$user->nim) }}">
                                    </div>
                                    <div class=" mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" placeholder="Nama Lengkap" name="nama"
                                            required id="nama" value="{{ old('nama',$user->nama) }}">
                                    </div>
                                    <div class=" mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" placeholder="Email" name="email"
                                            required id="email" value="{{ old('email',$user->email) }}">
                                    </div>
                                    <div class=" mb-3">
                                        <label for="prodiId" class="form-label">Program Studi</label>
                                        <x-adminlte-select name="id_prodi" id="prodiId" class="form-select" required>

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
                                        <label for="semester" class="form-label">Semester</label>
                                        <input type="number" class="form-control" placeholder="Semester" name="semester"
                                            id="semester" required value="{{ old('semester',$user->semester) }}">
                                    </div>
                                    <div class=" mb-3">
                                        <label for="ipk" class="form-label">IPK</label>
                                        <input type="text" class="form-control" placeholder="IPK" name="ipk" required
                                            id="ipk" value="{{ old('ipk',$user->ipk) }}">
                                    </div>
                                </div>
                                <div class=" col-6">
                                    <div class="mb-3">
                                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" placeholder="Tempat Lahir"
                                            name="tempat_lahir" id="tempat_lahir" required
                                            value="{{ old('tempat_lahir',$user->tempat_lahir) }}">
                                    </div>
                                    <div class=" mb-3">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" placeholder="Tanggal Lahir"
                                            name="tanggal_lahir" id="tanggal_lahir" required
                                            value="{{ old('tanggal_lahir',$user->tanggal_lahir) }}">
                                    </div>
                                    <div class=" mb-3">
                                        <label for="no_hp" class="form-label">No HP</label>
                                        <input type="text" class="form-control" placeholder="No HP" required
                                            name="no_hp" id="no_hp" value="{{ old('no_hp',$user->no_hp) }}">
                                    </div>
                                    <div class=" mb-3">
                                        <label for="jenjang_studi" class="form-label">Jenjang Studi</label>
                                        <x-adminlte-select name="jenjang" id="jenjang_studi" class="form-select"
                                            required>
                                            <!-- <select name="jenjang" id="jenjang_studi" class="form-select"> -->
                                            <option>Pilih Jenjang Studi</option>
                                            <option value="Strata 1"
                                                {{ old('jenjang', $user->jenjang) == 'Strata 1' ? 'selected' : '' }}>
                                                Strata 1
                                            </option>
                                            <option value="Strata 2"
                                                {{ old('jenjang', $user->jenjang) == 'Strata 2' ? 'selected' : '' }}>
                                                Strata 2
                                            </option>
                                            <!-- </select> -->
                                        </x-adminlte-select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tahun_akademik" class="form-label">Tahun Akademik</label>
                                        <input type="text" class="form-control" placeholder="Tahun Akademik"
                                            name="tahun_akademik" id="tahun_akademik" required
                                            value="{{ old('tahun_akademik',$user->tahun_akademik) }}">
                                    </div>
                                    <div class=" mb-3">
                                        <label for="sks" class="form-label">Jumlah SKS yang Telah Ditempuh</label>
                                        <input type="number" class="form-control" placeholder="Jumlah SKS" name="sks"
                                            required id="sks" value="{{ old('sks',$user->sks) }}">
                                    </div>
                                </div>
                                <div class=" col-12 mt-3">
                                    <button class="btn btn-primary btn-sm" type="submit">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                    <div class="mt-3">
                        <form action="{{ route('password-mahasiswa-update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Password Lama</label>
                                        <input type="password" class="form-control" placeholder="Password Lama"
                                            name="current_password" id="current_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Password Baru</label>
                                        <input type="password" class="form-control mb-1" placeholder="Password Baru"
                                            name="new_password" id="new_password" required>
                                        <span style="font-size: 13px;">Password baru minimal 8 karakter</span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password_confirmation" class="form-label">Password
                                            Konfirmasi</label>
                                        <input type="password" class="form-control" placeholder="Password Konfirmasi"
                                            name="new_password_confirmation" id="new_password_confirmation" required>
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