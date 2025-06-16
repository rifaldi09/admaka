<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan Magang</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            margin: 50px;
            line-height: 1.6;
        }

        .kop-container {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .kop-row {
            display: table-row;
        }

        .kop-logo, .kop-text {
            display: table-cell;
            vertical-align: middle;
        }

        .kop-logo {
            width: 100px;
            text-align: center;
        }

        .kop-logo img {
            width: 90px;
            height: auto;
        }

        .kop-text {
            text-align: center;
            padding: 0 10px;
        }

        .kop-text h1 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
            line-height: 1.2;
        }

        .kop-text h2 {
            margin: 5px 0;
            font-size: 13pt;
            font-weight: bold;
        }

        .kop-text p {
            margin: 5px 0;
            font-size: 11pt;
            line-height: 1.3;
        }

        .kop-line {
            border-top: 3px double #000;
            margin-top: 5px;
            margin-bottom: 20px;
        }

        .info-surat, .tujuan, .tabel, .ttd {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .tabel th, .tabel td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        .ttd {
            width: 100%;
            text-align: right;
        }

        .ttd p {
            margin-bottom: 70px;
        }

        .small {
            font-size: 10pt;
        }
    </style>
</head>
<body>

    <div class="kop-container">
        <div class="kop-row">
            <div class="kop-logo">
                <img src="{{ public_path('assets/img/logoumrah.png') }}" alt="Logo UMRAH">
            </div>
            <div class="kop-text">
                <h1>KEMENTERIAN PENDIDIKAN TINGGI, SAINS,</h1>
                <h1>DAN TEKNOLOGI UNIVERSITAS MARITIM RAJA ALI HAJI</h1>
                <h2>FAKULTAS TEKNIK DAN TEKNOLOGI KEMARITIMAN</h2>
                <p>
                    Jalan Politeknik Senggarang, Tanjungpinang 29100<br>
                    Telepon (0771) 4500097, Faksimile (0771) 4500097, Kotak Pos 155<br>
                    Laman <u>http://ft.umrah.ac.id</u> Posel <u>ft@umrah.ac.id</u>
                </p>
            </div>
        </div>
    </div>

    <div class="kop-line"></div>

    <div class="info-surat">
        <table style="width:100%;">
            <tr>
                <td style="width: 10%;">No</td>
                <td style="width: 40%;">: {{ $no_surat }}</td>
                <td style="text-align:right;">{{ $created_at }}</td>
            </tr>
            <tr>
                <td>Hal</td>
                <td colspan="2">: Permohonan Magang</td>
            </tr>
        </table>
    </div>

    <div class="tujuan">
        <p>Yth. {{ $tujuan_surat }}<br>
        {{ $alamat_surat }}</p>
    </div>

    <p>Dengan hormat,</p>

    <p>Sehubungan dengan pelaksanaan mata kuliah kerja praktik mahasiswa sesuai dengan kurikulum Program Studi yang berada di lingkungan Fakultas Teknik dan Teknologi Kemaritiman Universitas Maritim Raja Ali Haji, maka dengan ini kami sampaikan mahasiswa berikut ini:</p>

    <div class="tabel">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NAMA</th>
                    <th>NIM</th>
                    <th>Program Studi</th>
                    <th>Nomor HP</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $nama }}</td>
                    <td>{{ $id_user }}</td>
                    <td>{{ $prodi }}</td>
                    <td>{{ $no_hp }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <p>Mengajukan magang di instansi Bapak/Ibu. Adapun pelaksanaan waktu magang akan dilaksanakan mulai dari tanggal <strong>{{ $tanggal_mulai }}</strong> s.d <strong>{{ $tanggal_selesai }}</strong>. Besar harapan kami pada Bapak/Ibu untuk dapat memberikan kesempatan serta membantu memfasilitasi mahasiswa sesuai dengan kondisi yang ada.</p>

    <p>Demikian surat ini disampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>

    <div class="ttd">
        <p>Dekan,</p>
        <p><strong>Martaleli Bettiza, S.Si., M.Sc</strong><br>
        <span class="small">NIP. 197508282021212006</span></p>
    </div>

</body>
</html>
