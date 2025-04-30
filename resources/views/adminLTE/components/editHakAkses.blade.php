@extends('adminLTE.home')
@section('title', 'Edit Hak Akses')
@section('content')

    <div class="card mt-3">
        <div class="card-body">
            {{-- masih belum ada route yang dituju --}}
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- NIM & Nama --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim"
                            value="{{ $dataUser->nim ?? $dataUser->nidn }}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="{{ $dataUser->nama ?? '' }}" readonly>
                    </div>
                </div>

                {{-- Hak Akses --}}
                <div class="form-group">
                    <label>Hak Akses</label>
                    <div class="row">

                        {{-- gak tau gimana mau jelasin, yang penting berhasil menampilkan check box yang sesuai dengan user --}}
                        @foreach ($menuHakAkses as $menuIndex => $menus)
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="font-weight-bold">{{ $menus['header'] }}</h6>

                                    @foreach ($menus['menus'] as $itemIndex => $menu)
                                        @php
                                            // pengecekan apakah menu sudah ada di role akses
                                            $isChecked = $dataUserAkses->roleAkses->contains(
                                                fn($akses) => $akses->hakAkses->id_akses == $menu['id'],
                                            );
                                        @endphp

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="hak_akses"
                                                id="akses_{{ $menuIndex }}_{{ $itemIndex }}"
                                                value="{{ $menu['id'] ?? 'read' }}" {{ $isChecked ? 'checked' : '' }}
                                                required>
                                            <label class="form-check-label"
                                                for="akses_{{ $menuIndex }}_{{ $itemIndex }}">
                                                {{ $menu['text'] }}
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Tombol Submit masih belum berfungsi --}}
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>


@endsection
