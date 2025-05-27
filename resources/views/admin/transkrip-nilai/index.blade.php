@extends('dashboard.home')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    <div class="text-center pt-3">
        <h2>Daftar Transkrip Nilai Sementara</h2>
    </div>
    <div class="d-flex justify-content-center">
        <div class="mt-2">
            <button class="btn btn-outline-primary mr-3" onclick="onShowTable('Belum Diterima')">Belum Diterima</button>
            <button class="btn btn-outline-primary" onclick="onShowTable('Diterima')">Diterima dan Penerbitan</button>
        </div>
    </div>
    <div class="mt-3" id="Belum Diterima">
        @include('admin.transkrip-nilai.table.belum-diterima')
    </div>
    <div class="mt-3 d-none" id="Diterima">
        @include('admin.transkrip-nilai.table.diterima')
    </div>
    
@endsection
@push('js')
<script>
    let diterima = document.getElementById("Diterima");
    let draft = document.getElementById("Belum Diterima");

    function onShowTable(status) {
        if(status == "Diterima") {
            diterima.classList.remove('d-none');
            draft.classList.add('d-none');
        } else {
            draft.classList.remove('d-none');
            diterima.classList.add('d-none');
        }
    }
</script>
@endpush