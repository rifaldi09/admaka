<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Rekomendasi</title>
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
                <img src="{{ public_path('assets/img/logoumrah.png') }}" alt="Logo UMRAH">
            </td>
            <td class="header-text">
                <div>KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</div>
                <div>UNIVERSITAS MARITIM RAJA ALI HAJI</div>
                <div class="bold">FAKULTAS TEKNIK DAN TEKNOLOGI KEMARITIMAN</div>
                <div>Jalan Politeknik Senggarang, Tanjungpinang 29100</div>
                <div>Telepon (0771) 4500097, Faksimile (0771) 4500097, Kotak Pos 155</div>
                <div>
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
        <p>
            Nama: Martaleli Bettiza, S.Si., M.Sc<br>
            Jabatan: Dekan Fakultas Teknik dan Teknologi Kemaritiman<br>
            NIP: 197508282012122006<br>
            Email: ft@umrah.ac.id<br>
            No Tlp / Whatsapp: +62 813-6477-7280
        </p>

        <p>
            Dengan ini memberikan rekomendasi dan persetujuan kepada mahasiswa/i kami:<br>
            Nama: {{ $nama_mahasiswa }}<br>
            NIM: {{ $nim }}<br>
            Program Studi/Jurusan: {{ $prodi }}<br>
            Fakultas: Fakultas Teknik dan Teknologi Kemaritiman<br>
            Semester: {{ $semester }}<br>
            IPK: {{ $ipk }}
        </p>

        <p>{{ $perihal }} - {{ $tempat_perihal }}</p>

        <p>
            Dengan ini kami menyatakan bahwa yang bersangkutan benar-benar terdaftar sebagai mahasiswa aktif pada program studi {{ $prodi }}, Fakultas Teknik dan Teknologi Kemaritiman Tahun Akademik {{ $tahun_akademik }}.
        </p>

        <p>
            Kami menyatakan kesediaan untuk:<br>
            - Memberikan dukungan sepenuhnya serta bertanggung jawab bilamana terjadi sesuatu hal selama mengikuti program {{ $tempat_perihal }} sejak awal sampai akhir program<br>
            - Mendukung proses belajar mahasiswa/i kami melalui pengalaman {{ $tempat_perihal }}<br>
            - Memberikan pengakuan dan konversi {{ $konversi_sks }} sks dalam sistem akademik yang berlaku di Universitas Maritim Raja Ali Haji sesuai peraturan dari Kemendikbud Ristek untuk dapat berpartisipasi dalam program {{ $tempat_perihal }}.
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
