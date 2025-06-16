<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Aktif Kuliah</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            margin: 50px;
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
            margin-top: 30px;
            line-height: 1.8;
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
            <td width="100">
                <img src="{{ public_path('assets/img/logoumrah.png') }}" alt="Logo" width="90">
            </td>
            <td class="header-text">
                <div>KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</div>
                <div>UNIVERSITAS MARITIM RAJA ALI HAJI</div>
                <div class="bold">FAKULTAS TEKNIK DAN TEKNOLOGI KEMARITIMAN</div>
                <div>Jalan Politeknik Senggarang, Tanjungpinang 29100</div>
                <div>Telepon (0771) 4500097, Faksimile (0771) 4500097, Kotak Pos 155</div>
                <div>
                    Laman <a href="http://ft.umrah.ac.id">http://ft.umrah.ac.id</a> Posel <a href="mailto:ft@umrah.ac.id">ft@umrah.ac.id</a>
                </div>
            </td>
        </tr>
    </table>

    <div class="content">
        <p style="text-align: center;"><strong>SURAT KETERANGAN</strong><br>
            No: {{ $nomor_surat }}</p>

        <p>Dekan Fakultas Teknik dan Teknologi Kemaritiman Universitas Maritim Raja Ali Haji dengan ini menerangkan:</p>

        <p>
            NIM: {{ $nim }}<br>
            Nama: {{ $nama }}<br>
            Tempat, Tanggal Lahir: {{ $tempat_lahir }}, {{ $tanggal_lahir }}<br>
            Program Studi/Jenjang: {{ $prodi }} / {{ $jenjang }}<br>
            Semester/Tahun Akademik: {{ $semester }} / {{ $genap_ganjil }} / T.A {{ $tahun_akademik }}<br>
            Nomor HP: {{ $no_hp }}
        </p>

        <p>
            Adalah benar Mahasiswa {{ $status }} di Fakultas Teknik dan Teknologi Kemaritiman Universitas Maritim Raja Ali
            Haji pada semester {{ $semester_awal }} dan semester {{ $semester_akhir }} Tahun Akademik {{ $tahun_akademik }} dan
            {{ $tahun_akademik }} dengan jumlah {{ $sks }} SKS yang telah diambil dan {{ $ipk }} IPK Sementara. <br><br>
            Demikian Surat Keterangan ini dibuat, sebagai kelengkapan syarat pengajuan beasiswa KEPRI {{ $tahun_now }}.
        </p>

        <div class="footer">
            Tanjungpinang, {{ $tanggal_now }}<br><br><br><br>
            Dekan,<br><br><br><br>
            <strong>Martaleli Bettiza, S.Si., M.Sc</strong><br>
            NIP. 197508282012122006
        </div>
    </div>

</body>

</html>
