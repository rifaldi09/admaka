@extends('dashboard.home')

@section('title', 'Data Master')

@section('content')
<p class="pt-3">Tes halaman data master</p>
<p>{{ Auth::user()->data }}</p>
@endsection