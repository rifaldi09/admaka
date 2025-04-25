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
    <div class="card">
        <div class="card-body">
            Ini adalah isi dashboard kamu.
        </div>
    </div>
@endsection
