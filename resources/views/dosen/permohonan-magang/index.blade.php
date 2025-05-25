@extends('dashboard.home')

@section('title', 'Permohonan Surat Magang')

@section('content')
    <div class="text-center pt-3">
        <h2>Surat yang diterima</h2>
    </div>
    <div class="mt-3">
        @include('dosen.permohonan-magang.diterima')
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