<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Rekomendasi</title>
    <style>
    @page {
        margin-top: 0cm;
        margin-bottom: 0 cm;
        margin-left: 0, 2 cm;
        margin-right: 0, 1 cm;
    }

    body {
        font-family: "Times New Roman", serif;
        font-size: 12pt;
        margin: 10px;
        line-height: 1.4;
    }

    .header-table {
        width: 100%;
        border-bottom: 3px solid black;
        padding-bottom: 10px;
    }

    .header-table td {
        vertical-align: top;
    }

    .header-table img {
        width: 100px;
        height: 100px;
    }

    .header-text {
        text-align: center;
        line-height: 1.5;
    }

    .header-text .bold {
        font-weight: bold;
    }

    .content {
        text-align: justify;
        margin-left: 40px;
        line-height: 1.8;
    }

    .signature {
        margin-top: 40px;
        text-align: right;
        page-break-inside: avoid;
    }

    .signature p {
        margin: 2px 0;
    }

    a {
        color: #0000EE;
        text-decoration: none;
    }
    </style>
</head>

<body>

    <table class="header-table">
        <tr>
            <td width="80">
                <img src="{{ public_path('assets/img/logoumrah.png') }}" alt="Logo" width="80"
                    style="margin-top: 20px;">
            </td>
            <td class=" header-text">
                <div style="font-size: 14pt;">KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</div>
                <div style="font-size: 14pt;">UNIVERSITAS MARITIM RAJA ALI HAJI</div>
                <div style="font-size: 13pt;" class="bold">FAKULTAS TEKNIK DAN TEKNOLOGI KEMARITIMAN</div>
                <div style="font-size: 12pt;">Jalan Politeknik Senggarang, Tanjungpinang 29100</div>
                <div style="font-size: 12pt;">Telepon (0771) 4500097, Faksimile (0771) 4500097, Kotak Pos 155</div>
                <div style="font-size: 12pt;">
                    Laman <a href="http://ft.umrah.ac.id">http://ft.umrah.ac.id</a> Posel <a
                        href="mailto:ft@umrah.ac.id">ft@umrah.ac.id</a>
                </div>
            </td>
        </tr>
    </table>

    <div class="content">
        <p style="text-align: center;"><strong>SURAT REKOMENDASI</strong><br>
            Nomor: {{ $nomor_surat }}</p>

        <p>Saya yang bertanda tangan di bawah ini:</p>
        <table class="table-info">
            <tr>
                <td style="width: 200px;"> Nama</td>
                <td>: Martaleli Bettiza, S.Si., M.Sc</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>: Dekan Fakultas Teknik dan Teknologi Kemaritiman</td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>: 197508282012122006</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>: ft@umrah.ac.id</td>
            </tr>
            <tr>
                <td> No Tlp / Whatsapp</td>
                <td>: +62 813-6477-7280</td>
            </tr>
        </table>

        <p>
            Dengan ini memberikan rekomendasi dan persetujuan kepada mahasiswa/i kami:<br>
        </p>
        <table class="table-info">
            <tr>
                <td style="width: 200px;">Nama</td>
                <td>: {{ $nama_mahasiswa }}</td>
            </tr>
            <tr>
                <td> NIM</td>
                <td>: {{ $nim }}</td>
            </tr>
            <tr>
                <td>Program Studi/Jurusan</td>
                <td>: {{ $prodi }}</td>
            </tr>
            <tr>
                <td>Fakultas</td>
                <td>: Fakultas Teknik dan Teknologi Kemaritiman</td>
            </tr>
            <tr>
                <td>Semester</td>
                <td>: {{ $semester }}</td>
            </tr>
            <tr>
                <td> IPK</td>
                <td>: {{ $ipk }}</td>
            </tr>
        </table>

        <p>{{ $perihal }} - {{ $tempat_perihal }}</p>

        <p>
            Dengan ini kami menyatakan bahwa yang bersangkutan benar-benar terdaftar sebagai mahasiswa aktif pada
            program studi {{ $prodi }}, Fakultas Teknik dan Teknologi Kemaritiman Tahun Akademik {{ $tahun_akademik }}.
        </p>

        <p>Kami menyatakan kesediaan untuk: </p>

        <table class="table-info">
            <tr>
                <td></td>
                <td style="text-align: left; vertical-align: top;">-</td>
                <td>Memberikan dukungan sepenuhnya serta bertanggung jawab bilamana terjadi sesuatu hal selama
                    mengikuti
                    program {{ $tempat_perihal }} sejak awal sampai akhir program</td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: left; vertical-align: top;">-</td>
                <td>Mendukung proses belajar mahasiswa/i kami melalui pengalaman {{ $tempat_perihal }}</td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: left; vertical-align: top;">-</td>
                <td>Memberikan pengakuan dan konversi {{ $konversi_sks }} sks dalam sistem akademik yang berlaku di
                    Universitas Maritim Raja Ali Haji sesuai peraturan dari Kemendikbud Ristek untuk dapat
                    berpartisipasi dalam
                    program {{ $tempat_perihal }}.</td>
            </tr>
        </table>

        <div class="signature">
            <table style="float: right;">
                <tr>
                    <td style="padding: 2px 0; line-height: 1.2;">Tanjungpinang, {{ $tanggal_now }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px 0; line-height: 1.2;">Dekan,</td>
                </tr>
                <tr>
                    <td style="height: 70px;"></td>
                </tr>
                <tr>
                    <td style="padding: 2px 0; line-height: 1.2;"><strong>Martaleli Bettiza, S.Si., M.Sc</strong></td>
                </tr>
                <tr>
                    <td style="padding: 2px 0; line-height: 1.2;">NIP. 197508282012122006</td>
                </tr>

            </table>
        </div>
    </div>

</body>

</html>