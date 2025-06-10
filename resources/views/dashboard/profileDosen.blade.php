@extends('dashboard.home')

@section('title', 'Profil User')

@section('content')
{{-- <p>{{ Auth::user()->data }}</p> --}}
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">{{ $titleHeader }}</h3>
    </div>
    <div class="card-body">
        <div class="container">
            <form action="#" method="post">
                @method('PUT')
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control" placeholder="NIM" name="nim" id="nim" value={{ old('nim',$user->nim) }} required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" placeholder="Nama Lengkap" name="nama" id="nama" value={{ old('nama',$user->nama) }} >
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" placeholder="Email" name="email" id="email" value={{ old('email',$user->email) }} >
                        </div>
                        <div class="mb-3">
                            <label for="id_prodi" class="form-label">Program Studi</label>
                            <input type="text" class="form-control" placeholder="Program Studi" name="id_prodi" id="id_prodi" value={{ old('id_prodi',$user->prodi->nama) }} >
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <input type="number" class="form-control" placeholder="Semester" name="semester" id="semester" value={{ old('semester',$user->semester) }} >
                        </div>
                        <div class="mb-3">
                            <label for="ipk" class="form-label">IPK</label>
                            <input type="text" class="form-control" placeholder="IPK" name="ipk" id="ipk" value={{ old('ipk',$user->ipk) }} >
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" placeholder="Tempat Lahir" name="tempat_lahir" id="tempat_lahir" value={{ old('tempat_lahir',$user->tempat_lahir) }} >
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" placeholder="Tanggal Lahir" name="tanggal_lahir" id="tanggal_lahir" value={{ old('tanggal_lahir',$user->tanggal_lahir) }} >
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No HP</label>
                            <input type="text" class="form-control" placeholder="No HP" name="no_hp" id="no_hp" value={{ old('no_hp',$user->no_hp) }} >
                        </div>
                        <div class="mb-3">
                            <label for="jenjang" class="form-label">Jenjang Studi</label>
                            <input type="text" class="form-control" placeholder="Jenjang Studi" name="jenjang" id="jenjang" value={{ old('jenjang',$user->jenjang) }} >
                        </div>
                        <div class="mb-3">
                            <label for="tahun_akademik" class="form-label">Tahun Akademik</label>
                            <input type="text" class="form-control" placeholder="Tahun Akademik" name="tahun_akademik" id="tahun_akademik" value={{ old('tahun_akademik',$user->tahun_akademik) }} >
                        </div>
                        <div class="mb-3">
                            <label for="sks" class="form-label">Jumlah SKS yang Telah Ditempuh</label>
                            <input type="number" class="form-control" placeholder="Jumlah SKS" name="sks" id="sks" value={{ old('sks',$user->sks) }} >
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
@endsection
