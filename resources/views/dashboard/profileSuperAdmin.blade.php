@extends('dashboard.home')

@section('title', 'Profil Super Admin')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">{{ $titleHeader }}</h3>
    </div>
    <div class="card-body">
        <div class="container">
            <h5>Ubah Password</h5>
            <div class="mt-3">
                <form action="{{ route('password-super-admin-update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Lama</label>
                                <input type="password" class="form-control" placeholder="Password Lama" name="current_password" id="current_password">
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control mb-1" placeholder="Password Baru" name="new_password" id="new_password">
                                <span style="font-size: 13px;">Password baru minimal 8 karakter</span>
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
@endsection
