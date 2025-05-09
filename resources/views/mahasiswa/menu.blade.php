@extends('dashboard.home')

@section('title', 'Dashboard Mahasiswa')

@section('content')

    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Menu Pengajuan Surat</h3>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <!-- Ulangi card ini untuk setiap layanan -->
                @foreach ($menuSurat as $menu)
                    <div class="col-md-3 mb-4">
                        <div class="card shadow-sm h-100 rounded-lg">
                            <div class="card-body">
                                <h5 class="card-title font-weight-bold">{{ $menu->menu }}</h5>

                                {{-- URL ada tambahan -mahasiswa yang menginisialisasi bahwa url tersebut untuk mahasiswa --}}
                                <a href="{{ route($menu->url.'-mahasiswa') }}" class="btn btn-primary font-weight-bold">
                                    Liat Surat<i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

@endsection
