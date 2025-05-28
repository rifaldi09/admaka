@extends('dashboard.home')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    <div class="text-center pt-3">
        <h2>Transkrip yang diterima</h2>
    </div>
    <div class="mt-3">
        @include('dosen.transkrip-nilai.diterima')
    </div>
@endsection