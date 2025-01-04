<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workers Union - Login</title>
    <link rel="stylesheet" href="{{ asset('css/halaman_utama_perusahaan.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
</head>

<body>
    <nav class="navbar">
        <h1><span class="highlight">Workers</span> Union</h1>
        <ul class="nav-list">
            <li><a href="{{ route('workersunion.halamanUtama') }}">Home</a></li>
            <li><a href="{{ route('workersunion.halamanUtamaPerusahaan') }}">Perusahaan</a></li>
            <li><a href="#">Tentang</a></li>
            <li><a href="{{route('workersunion.daftarPerusahaanIndex')}}" class="masuk"> Daftar Perusahaan</a></li>
            <li><a href="#" class="post-job-btn">+ Posting Pekerjaan</a></li>
        </ul>
    </nav>
    <section class="hero">
        <div class="hero-content">
            <h2>Temukan lebih dari sekedar tempat kerja</h2>
            <div class="search-bar">
                <input type="text" placeholder="Cari perusahaan...">
                <button>Cari</button>
            </div>
        </div>
    </section>


    <h3 style="text-align: center; margin-top: 15px;">Perusahaan Unggulan</h3>

<section class="featured-company">
    
    <div class="company-highlight">
        <img src="./images/company-highlight.png" alt="Perusahaan Unggulan">
        <div class="company-info">
            <h4>PT. Icon Central Prima</h4>
            <p class="job-title">Customer Service Officer</p>
            <p>Kami menyediakan lingkungan kerja dinamis untuk mendukung pertumbuhan Anda.</p>
            <div class="additional-info">
                <p><strong>Rating:</strong> ⭐⭐⭐⭐⭐ (4.8)</p>
                <p><strong>Lokasi:</strong> Jakarta, Indonesia</p>
                <p><strong>Kategori:</strong> Layanan Pelanggan</p>
            </div>
            <a href="#" class="see-more-btn">Lihat lebih banyak</a>
        </div>
    </div>
</section>

    

    <!-- Perusahaan Populer -->
    <section class="popular-companies">
        <div style="display: flex;">
            <h3>Perusahaan Populer</h3>
            <button style="margin-left: 1180px;">Tulis Ulasan</button>
        </div>

        <div class="company-grid">
            <!-- Baris pertama -->
            <div class="row">
                <div class="company-card">
                    <img src="./images/mandiri-logo.png" alt="Mandiri">
                    <p>PT. Bank Mandiri (Persero) Tbk</p>
                </div>
                <div class="company-card">
                    <img src="./images/bca-logo.png" alt="BCA">
                    <p>PT. Bank Central Asia Tbk</p>
                </div>
                <div class="company-card">
                    <img src="./images/indomaret-logo.png" alt="Indomaret">
                    <p>Indomaret Group</p>
                </div>
                <div class="company-card">
                    <img src="./images/alfamart-logo.png" alt="Alfamart">
                    <p>PT. Sumber Alfaria Trijaya Tbk</p>
                </div>
            </div>
            <!-- Baris kedua -->
            <div class="row">
                <div class="company-card">
                    <img src="./images/danamon-logo.png" alt="Danamon">
                    <p>PT. Bank Danamon Indonesia Tbk</p>
                </div>
                <div class="company-card">
                    <img src="./images/honda-logo.png" alt="Honda">
                    <p>PT. Astra Honda Motor</p>
                </div>
                <div class="company-card">
                    <img src="./images/mnc-logo.png" alt="MNC">
                    <p>PT. MNC Investama Tbk</p>
                </div>
                <div class="company-card">
                    <img src="./images/adira-logo.png" alt="Adira">
                    <p>PT. Adira Dinamika Multi Finance Tbk</p>
                </div>
            </div>
        </div>
        <div style="display: flex;">
            <button style="text-align: center; margin-top: 20px; margin-left: 625px;">Lihat Ulasan Perusahaan Lain</button>
        </div>
    </section>
    

    <!-- Informasi Karier -->
    <section class="career-info">
        <img src="./images/keputusankarier.png" alt="Perusahaan Unggulan">
    </section>

</body>
</html>

