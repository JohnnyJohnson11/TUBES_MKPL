<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workers Union</title>
    <link rel="stylesheet" href="{{ asset('css/home_style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="navbar">
        <h1><span class="highlight">Workers</span> Union</h1>
        <ul class="nav-list">
            <li><a href="#">Home</a></li>
            <li><a href="{{ route('workersunion.lihatPekerjaan') }}">Pekerjaan</a></li>
            <li><a href="{{ route('workersunion.halamanUtamaPerusahaan') }}">Perusahaan</a></li>
            <li><a href="#">Tentang</a></li>
            <li class="user-menu">
                <a href="#" class="username">{{$pekerjas['username']}} <span>&#9662;</span></a>
                <div class="dropdown-menu">
                    <a href='{{ route("workersunion.profilePage") }}'>Lihat Profil</a>
                    <a href="D:\WebPro\TUBES-WEBPRO-Muhammad-Rafi-Nadhif_1302220142\pekerjaan tersimpan\lamar.html">Pekerjaan Tersimpan</a>
                    <a href="#">Lamaran Kerja</a>
                    <a href="#">Pengaturan</a>
                    <a href="{{ route('workersunion.halamanUtama') }}">Keluar</a>
                </div>
            </li>
            <li><button class="post-job-btn">+ Posting Pekerjaan</button></li>
        </ul>
    </div>

    <section class="hero">
        <h1 class="heading">Temukan pekerjaan<br>impianmu di sini</h1>
        <p class="subheading">Selamat datang di Workers Union, pintu gerbang<br>Anda menuju dunia penuh peluang.</p>
        <div class="search-bar">
            <button class="search-btn cari-pekerjaan">Cari Pekerjaan</button>
            <button class="search-btn other-btn">Kata Kunci</button>
            <button class="search-btn other-btn">Lokasi</button>
            <button class="search-btn other-btn">Mencari</button>
        </div>
    </section>

    <section class="categories">
        <a href="link-akuntansi.html" class="category">
            <img src="{{ asset('images/akuntansi.png') }}" alt="Akuntansi">
            <h3>Akuntansi</h3>
            <p>99+ Pekerjaan</p>
        </a>
        <a href="link-keuangan.html" class="category">
            <img src="{{ asset('images/keuangan.png') }}" alt="Keuangan">
            <h3>Keuangan</h3>
            <p>99+ Pekerjaan</p>
        </a>
        <a href="link-grafik-desain.html" class="category">
            <img src="{{ asset('images/grafik_desain.png') }}" alt="Grafik Desain">
            <h3>Grafik Desain</h3>
            <p>99+ Pekerjaan</p>
        </a>
        <a href="link-development.html" class="category">
            <img src="{{ asset('images/development.png') }}" alt="Development">
            <h3>Development</h3>
            <p>99+ Pekerjaan</p>
        </a>
        <a href="link-animasi.html" class="category">
            <img src="{{ asset('images/animasi.png') }}" alt="Animasi">
            <h3>Animasi</h3>
            <p>99+ Pekerjaan</p>
        </a>
        <a href="link-manajemen.html" class="category">
            <img src="{{ asset('images/manajemen.png') }}" alt="Manajemen">
            <h3>Manajemen</h3>
            <p>99+ Pekerjaan</p>
        </a>
        <a href="link-marketing.html" class="category">
            <img src="{{ asset('images/marketing.png') }}" alt="Marketing">
            <h3>Marketing</h3>
            <p>99+ Pekerjaan</p>
        </a>
        <a href="link-hrm.html" class="category">
            <img src="{{ asset('images/hrm.png') }}" alt="HRM">
            <h3>HRM</h3>
            <p>99+ Pekerjaan</p>
        </a>
    </section>

    <section class="jobs">
        <div class="filter">
            <h3>Berdasarkan Lokasi</h3>
            <label><input type="checkbox"> Jakarta Timur</label><br>
            <label><input type="checkbox"> Jakarta Selatan</label><br>
            <label><input type="checkbox"> DKI Jakarta</label><br>
            <label><input type="checkbox"> Jabodetabek</label><br>
            <label><input type="checkbox"> Bandung</label><br>

            <h3>Berdasarkan Kategori</h3>
            <label><input type="checkbox"> Akuntansi</label><br>
            <label><input type="checkbox"> HRM</label><br>
            <label><input type="checkbox"> Grafik Desain</label><br>
            <label><input type="checkbox"> Development</label><br>
            <label><input type="checkbox"> Marketing</label><br>

            <h3>Berdasarkan Gaji</h3>
            <label><input type="radio" name="gaji"> Rp. 1.000.000 - Rp. 2.500.000</label><br>
            <label><input type="radio" name="gaji"> Rp. 2.500.000 - Rp. 3.500.000</label><br>
            <label><input type="radio" name="gaji"> Rp. 3.500.000 - Rp. 5.000.000</label><br>
            <label><input type="radio" name="gaji"> Rp. 5.000.000 - Rp. 6.500.000</label><br>
            <label><input type="radio" name="gaji"> Rp. 5.500.000+</label><br>
        </div>

        <div class="job-listings">
            <div class="job-card">
                <div class="job-buttons">
                    <div class="button-container">
                        <button class="save-btn">Simpan</button>
                        <button class="apply-btn">Lamar</button>
                    </div>
                </div>
                <h4>Consumer Relationship Manager</h4>
                <p>PT Bank Danamon Indonesia Tbk</p>
                <p>Lulusan S1 semua jurusan</p>
                <p><span class="salary">Gaji Rp. 6.000.000</span> <span class="job-type"> Jenis Pekerjaan: Full
                        Time</span></p>
            </div>
            <div class="job-card">
                <div class="job-buttons">
                    <div class="button-container">
                        <button class="save-btn">Simpan</button>
                        <button class="apply-btn">Lamar</button>
                    </div>
                </div>
                <h4>Relationship Manager</h4>
                <p>PT Bank Perkreditan Rakyat Universal Jakarta</p>
                <p>Lulusan S1 semua jurusan</p>
                <p><span class="salary">Gaji Rp. 5.000.000</span> <span class="job-type"> Jenis Pekerjaan: Full
                        Time</span></p>
            </div>
            <div class="job-card">
                <div class="job-buttons">
                    <div class="button-container">
                        <button class="save-btn">Simpan</button>
                        <button class="apply-btn">Lamar</button>
                    </div>
                </div>
                <h4>Desain Grafis</h4>
                <p>Barantum</p>
                <p>Lulusan S1 Art & Design / Creative Multimedia</p>
                <p><span class="salary">Gaji Rp. 6.000.000</span> <span class="job-type"> Jenis Pekerjaan: Full
                        Time</span></p>
            </div>
            <div class="job-card">
                <div class="job-buttons">
                    <div class="button-container">
                        <button class="save-btn">Simpan</button>
                        <button class="apply-btn">Lamar</button>
                    </div>
                </div>
                <h4>WordPress Developer</h4>
                <p>PT. Arenti Advance Solusi</p>
                <p>Lulusan SMA/SMK RPL</p>
                <p><span class="salary">Gaji Rp. 6.000.000</span> <span class="job-type"> Jenis Pekerjaan: Full
                        Time</span></p>
            </div>

            <div class="pagination">
                <button>&laquo;</button>
                <button>1</button>
                <button>2</button>
                <button>3</button>
                <button>&raquo;</button>
            </div>
        </div>
    </section>

    <footer>
        <button>Kebijakan Privasi</button> | <button>Syarat & Ketentuan</button>
    </footer>

    <script src="dropdown_thing.js"></script>
</body>

</html>