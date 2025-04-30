@extends('dashboard.home')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<p>{{ Auth::user()->data }}</p>
@endsection