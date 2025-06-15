<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Permohonan Pengambilan Data - MK</title>
  <style>
    body {
      font-family: "Times New Roman", serif;
      font-size: 12pt;
      margin: 50px;
      line-height: 1.4;
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
      margin-top: 20px;
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
  <table class="kop-table">
    <tr>
      <td class="kop-left">
        <img src="{{ public_path('assets/img/logoumrah.png') }}" alt="Logo" width="90">
      </td>
      <td class="kop-center">
        <p>KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</p>
        <p>UNIVERSITAS MARITIM RAJA ALI HAJI</p>
        <p>FAKULTAS TEKNIK DAN TEKNOLOGI KEMARITIMAN</p>
        <p class="subheader">
          Jalan Politeknik Senggarang, Tanjungpinang 29100<br>
          Telepon (0771) 4500097, Faksimile (0771) 4500097, Kotak Pos 155<br>
          Laman: http://ft.umrah.ac.id | Email: ft@umrah.ac.id
        </p>
      </td>
    </tr>
  </table>

  <hr style="border: 1px solid black; margin-top: 20px; margin-bottom: 20px;">

  <div class="info clearfix">
    <div class="info-left">
      <p style="margin: 0;">Nomor: {{ $no_surat }}</p>
      <p style="margin: 0;">Hal: Permohonan Pengambilan Data</p>
    </div>
    <div class="info-right">
      <p style="margin: 0;">{{ $created_at }}</p>
    </div>
  </div>

  <!-- Isi Surat -->
  <div class="content">
    <p style="margin-top: 40px;">Kepada Yth:<br>
    {{ $tujuan_surat }}<br>
    {{ $alamat_surat }}</p>

    <p>Dengan hormat,</p>

    <p>Kami menginformasikan bahwa Mahasiswa Fakultas Teknik dan Teknologi Kemaritiman Universitas Maritim Raja Ali Haji sebagai berikut:</p>

    <table class="table-info">
      <tr>
        <td>Nama</td>
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

    <p>Akan mengadakan penelitian sebagai salah satu syarat menyelesaikan mata kuliah.</p>

    <p>Berhubungan dengan ini, diharapkan untuk dapat memberikan kesempatan serta membantu memfasilitasi mahasiswa sesuai dengan kondisi yang ada.</p>

    <p>Demikian surat ini disampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>

    <div class="signature">
      <p>Hormat kami,</p>
      <p style="margin-bottom: 40px;">Dekan,</p>
    </div>
  </div>

</body>
</html>
