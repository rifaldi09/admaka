@extends('dashboard.home')

@section('title', 'Permohonan Surat Magang')

@section('content')
    <div class="d-flex justify-content-between pt-4">
        <h2>Permohonan Surat Magang</h2>
        <button type="button" class="btn btn-primary align-self-start" data-toggle="modal" data-target="#permohonanModal">
            Buat Surat
        </button>
    </div>
    @include('mahasiswa.permohonan-magang.permohonan-modal')
    <div class="d-flex justify-content-center mt-3">
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Tujuan Surat</th>
                <th>Alamat Surat</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Alasan Ditolak</th>
                <th>Aksi</th>
            </tr>
            @forelse ($pengajuan as $key => $detail)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $detail->tujuan_surat }}</td>
                    <td>{{ $detail->alamat_surat }}</td>
                    <td>{{ $detail->tanggal_mulai }}</td>
                    <td>{{ $detail->tanggal_selesai }}</td>
                    <td>{{ $detail->status }}</td>
                    <td>{{ $detail->alasan_ditolak != '' ? $detail->alasan_ditolak : 'Tidak ada' }}</td>
                    <td>
                        @if($detail->status == 'Penerbitan')
                        @foreach ($detail->filePengajuan as $file)
                            <a href="{{ Storage::url('public/permohonan-magang/'. basename($file->path)) }}" target="_blank">
                                Lihat File
                            </a>
                        @endforeach
                        @elseif($detail->status == 'Ditolak')
                        <button type="button" class="btn btn-primary align-self-start" data-toggle="modal" data-target="#editPermohonanModal-{{ $detail->id_permohonan_magang }}">
                            Edit
                        </button>
                        @include('mahasiswa.permohonan-magang.edit-permohonan-modal')
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