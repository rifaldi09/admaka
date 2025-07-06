@extends('dashboard.home')

@section('title', 'Data Master')
@php
use Illuminate\Support\Facades\Validator;
use App\Models\Dosen;

$errorCount = 0;
@endphp
@section('content')
<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Preview Data Dosen</h3>
    </div>
    <div class="card-body">
        @php
        $totalErrors = 0;
        $dataMhsFormatted = [];
        $dataHeaderFormat =[];
        foreach ($header as $col) {
        $dataHeaderFormat[] = $col;
        }

        foreach ($data as $row) {
        $formattedRow = [];
        foreach ($row as $cell) {
        if ($cell['error']) {
        $formattedRow[] = '<span class="text-danger">' . e($cell['value']) . '<br><small><i
                    class="fas fa-exclamation-circle"></i> Error</small></span>';
        $totalErrors++;
        } else {
        $formattedRow[] = e($cell['value']);
        }
        }


        $dataDosenFormatted[] = $formattedRow;
        }

        $heads =$dataHeaderFormat;

        $config = [
        'data' => $dataDosenFormatted,
        'order' => [[1, 'asc']],
        'columns' => [null, null, null, null,null,null,null, ['orderable' => false]],
        ];
        @endphp

        {{-- Info jumlah error --}}
        @if ($totalErrors > 0)
        <div class="alert alert-danger">
            ⚠️ Ditemukan <strong>{{ $totalErrors }}</strong> kesalahan dalam data. Silakan perbaiki file CSV Anda.
        </div>
        @else
        <div class="alert alert-success">
            ✅ Data valid. Anda dapat mengimpor data ke sistem.
        </div>
        @endif

        {{-- Datatable --}}
        <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" striped hoverable bordered compressed>
            {{-- Baris ditampilkan otomatis dari config['data'] --}}
        </x-adminlte-datatable>

        {{-- Tombol tindakan --}}
        @if ($totalErrors === 0)
        <form id="insertDosen" action="{{ route('import-dosen') }}" method="POST">
            @csrf
            <input type="hidden" name="file" value="{{ $file }}">
            <div class="mt-3">
                <button type="submit" class="btn btn-success">Import Data</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
        @else
        <div class="mt-3">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
        </div>
        @endif
    </div>
</div>

@endsection