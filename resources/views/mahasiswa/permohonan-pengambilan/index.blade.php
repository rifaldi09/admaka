@extends('dashboard.home')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    <div class="d-flex justify-content-between pt-4">
        <h2>Permohonan Pengambilan Data</h2>
        <button type="button" class="btn btn-primary align-self-start" data-toggle="modal" data-target="#permohonanModal">
            Buat Permohonan &plus;
        </button>
    </div>
    @include('mahasiswa.permohonan-pengambilan.modal.create-permohonan-modal')
    <div class="d-flex justify-content-center mt-3">
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Tujuan Surat</th>
                <th>Alamat Surat</th>
                <th>Judul Skripsi</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Alasan Ditolak</th>
                <th>Aksi</th>
            </tr>
            @forelse ($permohonan as $key => $detail)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $detail->tujuan_surat }}</td>
                    <td>{{ $detail->alamat_surat }}</td>
                    <td>{{ $detail->judul_skripsi }}</td>
                    <td>{{ \Carbon\Carbon::parse($detail->tanggal_mulai)->translatedFormat('j F Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($detail->tanggal_selesai)->translatedFormat('j F Y') }}</td>
                    <td>{{ $detail->status }}</td>
                    <td>{{ $detail->alasan_ditolak != '' ? $detail->alasan_ditolak : 'Tidak ada' }}</td>
                    <td>
                        @if($detail->status == 'Penerbitan')
                        @foreach ($detail->filePermohonan as $file)
                            <a href="{{ asset('storage/permohonan-pengambilan/'. basename($file->path)) }}" target="_blank">
                                Lihat File
                            </a>
                        @endforeach
                        @elseif($detail->status == 'Ditolak')
                        <button type="button" class="btn btn-primary align-self-start" data-toggle="modal" data-target="#editPermohonanModal-{{ $detail->id_permohonan }}">
                            Edit
                        </button>
                        @include('mahasiswa.permohonan-pengambilan.modal.edit-permohonan-modal')
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