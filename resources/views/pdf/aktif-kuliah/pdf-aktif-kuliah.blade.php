<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Aktif Kuliah</title>
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
        margin-left: 40px;
        line-height: 1.5;
    }

    .footer {
        margin-top: 50px;
        text-align: right;
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
        <p style="text-align: center;"><strong>SURAT KETERANGAN</strong><br>
            No: {{ $nomor_surat }}</p>

        <p style="text-align: justify;">Dekan Fakultas Teknik dan Teknologi Kemaritiman Universitas Maritim Raja Ali
            Haji dengan ini menerangkan:</p>

        <table>
            <tr>
                <td style="width: 200px;">NIM</td>
                <td>:</td>
                <td>{{ $nim }}</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $nama }}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>:</td>
                <td>{{ $tempat_lahir }}, {{ $tanggal_lahir }}</td>
            </tr>
            <tr>
                <td>Program Studi/Jenjang</td>
                <td>:</td>
                <td> {{ $prodi }} / {{ $jenjang }}</td>
            </tr>
            <tr>
                <td> Semester/Tahun Akademik</td>
                <td>:</td>
                <td>{{ $semester }} / T.A {{ $tahun_akademik }}</td>
            </tr>
            <tr>
                <td> Nomor HP</td>
                <td>:</td>
                <td>{{ $no_hp }}</td>
            </tr>
        </table>

        <p style="text-align: justify;">
            Adalah benar Mahasiswa {{ $status }} di Fakultas Teknik dan Teknologi Kemaritiman Universitas
            Maritim
            Raja
            Ali
            Haji pada semester {{ $semester }} Tahun Akademik {{ $tahun_akademik }}
            dengan jumlah {{ $sks }} SKS yang telah diambil dan {{ $ipk }} IPK Sementara.
            <br><br>
            Demikian Surat Keterangan ini dibuat, untuk keperluan {{ $keperluan }}.
        </p>

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
                <td style="padding: 2px 0; line-height: 1.2;"><strong>Martaleli Bettiza, S.Si., M.Sc.</strong></td>
            </tr>
            <tr>
                <td style="padding: 2px 0; line-height: 1.2;">NIPPPK. 197508282012122006</td>
            </tr>

        </table>
    </div>

</body>

</html>