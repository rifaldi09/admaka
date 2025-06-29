<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Permohonan Pengambilan Data - Skripsi</title>
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
    }

    .table-info td {
        padding: 2px 0;
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
        <div class="info clearfix">
            <div class="info-left">
                <p style="margin: 0;">Nomor: {{ $no_surat }}</p>
                <p style="margin: 0;">Hal: Permohonan Pengambilan Data</p>
            </div>
            <div class="info-right">
                <p style="margin: 0;">{{ $created_at }}</p>
            </div>
        </div>
        <p style="margin-top: 40px;">Kepada Yth:<br>
            {{ $tujuan_surat }}<br>
            {{ $alamat_surat }}</p>

        <p>Dengan hormat,</p>

        <p>Kami menginformasikan bahwa Mahasiswa Fakultas Teknik dan Teknologi Kemaritiman Universitas Maritim Raja Ali
            Haji sebagai berikut:</p>

        <table class="table-info">
            <tr>
                <td style="width: 200px;">Nama</td>
                <td>: {{ $nama }}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>: {{ $tempat }}, {{ $tanggal_lahir }}</td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>: {{ $nim }}</td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td>: {{ $prodi }}</td>
            </tr>
            <tr>
                <td>No. Telepon</td>
                <td>: {{ $no_hp }}</td>
            </tr>
        </table>

        <p>Akan mengadakan penelitian sebagai salah satu syarat menyelesaikan penyusunan skripsi dengan judul:</p>

        <p style="text-align: center; font-style: italic;">"{{ $judul_skripsi }}"</p>

        <p>Berhubungan dengan ini, diharapkan untuk dapat memberikan kesempatan serta membantu memfasilitasi mahasiswa
            sesuai dengan kondisi yang ada.</p>

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