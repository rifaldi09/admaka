{{-- https://jeroennoten.github.io/Laravel-AdminLTE dokumentasi admin LTE --}}

{{-- Penggunaan layout dari Admin LTE jadi terdapat file layout --}}
{{-- Configuration ada di config/adminlte.php --}}
@extends('adminlte::page')

{{-- Logo title Umrah --}}
<link href="{{ asset('assets/img/logoumrah.png') }}" rel="icon">

{{-- inject ke layout admin lte soalnya gatau gimana caranya biar bisa dimasukin langsung --}}
@section('plugins.Toastr', true)
@section('plugins.Datatables', true)
@section('plugins.Bootstrap', true)

@push('js')
<script>
        @foreach (['success', 'error', 'warning', 'info'] as $msg)
            @if(session()->has($msg))
                toastr.{{ $msg }}("{{ session($msg) }}");
            @endif
        @endforeach
</script>
@endpush

{{-- Title --}}
@section('title')
@yield('title') ADMAKA - FTTK UMRAH
@endsection

{{-- Content --}}
@section('content')
@yield('content')
@endsection


{{-- Script --}}
@section('script')
@yield('script')
@endsection
