<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
        <a href="index.html" class="logo d-flex align-items-center me-auto">
            <img src="{{ asset('assets/img/logoadmaka.png') }}" alt="">
            <h1 class="sitename">ADMAKA</h1>
        </a>
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="#hero" class="active">Home</a></li>
                <li class="dropdown"><a href="#"><span>Template Surat</span> <i
                            class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="{{ asset('FORM_AKADEMIK/BO.FT.01_SURAT_PERSETUJUAN_SIDANG_SKRIPSI.docx') }}">Surat
                                Persetujuan Sidang Skripsi</a></li>
                        <li><a href="{{ asset('FORM_AKADEMIK/BO.FT.02 FORM PERMOHONAN SIDANG SKRIPSI.docx') }}">Form
                                Permohonan Sidang Skripsi</a></li>
                        <li><a
                                href="{{ asset('FORM_AKADEMIK/BO.FT.03 FORM PERMOHONAN SEMINAR PROPOSAL SKRIPSI.docx') }}">Form
                                Permohonan Sminar Proposal Skripsi</a></li>
                        <li><a
                                href="{{ asset('FORM_AKADEMIK/BO.FT.BO.FT.04 SURAT PERSETUJUAN SEMINAR PROPOSAL SKRIPSI.docx') }}">Surat
                                Persetujuan Seminar Proposal Skripsi</a></li>
                        <li><a href="{{ asset('FORM_AKADEMIK/Borang Pengurusan Mahasiswa Cuti_Pindah.docx') }}">Form
                                Cuti
                                Akademik</a></li>
                        <li><a href="{{ asset('FORM_AKADEMIK/Borang Permasalahan SIPA.pdf') }}">Borang
                                Laporan Permasalahan
                                SIPA</a></li>
                        <li><a href="{{ asset('FORM_AKADEMIK/FORMULIR PENGURUSAN KTM.docx') }}">Formulir
                                Pengurusan KTM</a>
                        </li>
                        <li><a href="{{ asset('FORM_AKADEMIK/PERMOHONAN MENGIKUTI KEGIATAN MBKM.docx') }}">Permohonan
                                Mengikuti MBKM</a></li>
                    </ul>
                </li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        {{-- mengubah tombol ketika user sudah login --}}
        @if (!Auth::check())
        <a class="btn-getstarted" href="{{ route('login') }}">Login</a>
        @else
        {{-- Belum ada Route --}}
        <a class="btn-getstarted" href="">Dashboard</a>
        @endif
    </div>
</header>
