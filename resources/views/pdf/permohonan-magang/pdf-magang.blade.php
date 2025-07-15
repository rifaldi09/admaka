<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan Magang</title>
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

    .kop-table {
        width: 100%;
    }

    .kop-table td {
        vertical-align: top;
        text-align: center;
    }

    .kop-left {
        width: 90px;
        text-align: left;
    }

    .kop-center {
        width: 100%;
    }

    .kop-center p {
        margin: 0;
        font-size: 14pt;
        font-weight: bold;
    }

    .subheader {
        font-size: 10pt;
        font-weight: normal;
    }

    .info {
        margin-top: 20px;
        font-size: 11pt;
    }

    .info-left {
        float: left;
    }

    .info-right {
        float: right;
    }

    .clearfix::after {
        content: "";
        display: table;
        clear: both;
    }

    .table-info {
        margin-top: 10px;
        margin-bottom: 20px;
        border-collapse: collapse;
        width: 100%;
    }

    .table-info th,
    .table-info td {
        border: 1px solid #000;
        padding: 5px;
        text-align: center;
    }

    .content {
        text-align: justify;
        margin-left: 40px;
        line-height: 1.5;
    }

    .signature {
        margin-top: 40px;
        text-align: right;
        page-break-inside: avoid;
    }

    .signature p {
        margin: 2px 0;
    }

    .table-ku tr {
        margin: 0 !important;
        padding: 0 !important;
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

    <!-- <div class="kop-line"></div> -->
    <div class="content">
        <div class="info-surat">
            <table class="table-ku" style="width:100%;">
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

        <p>Sehubungan dengan pelaksanaan mata kuliah kerja praktik mahasiswa sesuai dengan kurikulum Program Studi yang
            berada di lingkungan Fakultas Teknik dan Teknologi Kemaritiman Universitas Maritim Raja Ali Haji, maka
            dengan
            ini kami sampaikan mahasiswa berikut ini:</p>


        <table class="table-info">
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


        <p>Mengajukan magang di instansi Bapak/Ibu. Adapun pelaksanaan waktu magang akan dilaksanakan mulai dari tanggal
            <strong>{{ $tanggal_mulai }}</strong> s.d <strong>{{ $tanggal_selesai }}</strong>. Besar harapan kami pada
            Bapak/Ibu untuk dapat memberikan kesempatan serta membantu memfasilitasi mahasiswa sesuai dengan kondisi
            yang
            ada.
        </p>

        <p>Demikian surat ini disampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>

        <div class="signature">
            <table style="float: right;">
                <tr>
                    <td style="padding: 2px 0; line-height: 1.2;">Hormat kami,</td>
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
    </div>

</body>

</html>