{{-- https://jeroennoten.github.io/Laravel-AdminLTE dokumentasi admin LTE --}}

{{-- Penggunaan layout dari Admin LTE jadi terdapat file layout --}}
{{-- Configuration ada di config/adminlte.php --}}
@extends('adminlte::page')

{{-- Logo title Umrah --}}
<link href="{{ asset('assets/img/logoumrah.png') }}" rel="icon">
{{-- Title --}}
@section('title', 'ADMAKA - FTTK UMRAH')

{{-- Content --}}
@section('content')
{{-- isi Sementara --}}
    <div class="card mt-3">
        <div class="card-body">
            {{-- teks nya diganti buat test kalo method user dari Auth tetep bisa dipake --}}
            {{-- karena table users nya di ganti jadi mahasiswa --}}
            Ini adalah isi dashboard {{ Auth::user()->username }}.
        </div>
    </div>
@endsection
