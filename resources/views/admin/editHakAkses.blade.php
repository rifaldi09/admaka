@extends('dashboard.home')
@section('title', 'Edit Hak Akses')
@section('content')

    <div class="card mt-3">
        <div class="card-body">
            {{-- masih belum ada route yang dituju --}}
            <form action="{{ route('update-hak-akses') }}" method="POST" enctype="multipart/form-data" id="formEditHakAkses">
                @csrf

                {{-- id_role & nama_role --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="id_role">ID Role</label>
                        <input type="text" class="form-control" id="id_role" name="id_role" value="{{ $dataRole->id }}"
                            readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nama_role">Nama Role</label>
                        <input type="text" class="form-control" id="name_role" name="name_role"
                            value="{{ $dataRole->name_role ?? '' }}" readonly>
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
                                            $isChecked = $menuALL->contains(
                                                fn($akses) => $akses->id_menu == $menu['id'],
                                            );
                                        @endphp

                                        {{-- Checkbox untuk hak akses --}}
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="check_akses[]"
                                                id="akses_{{ $menu['id'] }}"
                                                value="{{ $menu['id'] }}" {{ $isChecked ? 'checked' : '' }}
                                                id="akses_menu{{ $menu['id'] }}">
                                            <label class="form-check-label"
                                                for="akses_{{ $menu['id'] }}">
                                                {{ $menu['text'] }}
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk fa-sm"></i>
                        Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
