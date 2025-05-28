@extends('dashboard.home')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    <div class="d-flex justify-content-between pt-4">
        <h2>Transkrip Nilai Sementara</h2>
        <button type="button" class="btn btn-primary align-self-start" data-toggle="modal" data-target="#transkripModal">
            Buat Transkrip &plus;
        </button>
    </div>
    @include('mahasiswa.transkrip-nilai.modal.create')
    <div class="d-flex justify-content-center mt-3">
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Keperluan</th>
                <th>Status</th>
                <th>Alasan Ditolak</th>
                <th>Aksi</th>
            </tr>
            @forelse ($transkrip as $key => $detail)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $detail->keperluan }}</td>
                    <td>{{ $detail->status }}</td>
                    <td>{{ $detail->alasan_ditolak != '' ? $detail->alasan_ditolak : 'Tidak ada' }}</td>
                    <td>
                        @if($detail->status == 'Penerbitan')
                        @foreach ($detail->filePermohonan as $file)
                            <a href="{{ asset('storage/transkrip/'. basename($file->path)) }}" target="_blank">
                                Lihat File
                            </a>
                        @endforeach
                        @elseif($detail->status == 'Ditolak')
                        <button type="button" class="btn btn-primary align-self-start" data-toggle="modal" data-target="#editTranskripModal-{{ $detail->id_transkrip }}">
                            Edit
                        </button>
                        @include('mahasiswa.transkrip-nilai.modal.edit')
                        @else
                        <i>Sedang di proses</i>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-secondary text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </table>
    </div>
@endsection