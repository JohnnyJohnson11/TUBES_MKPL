<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Seek Employer - Konfirmasi Lowongan</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset("css/posting_pekerjaan_1.5_styles.css")}}" />
    <style>
      .back-to-home {
        display: inline-block;
        font-size: 16px;
        color: #007bff;
        font-weight: 500;
        text-decoration: none; /* Tidak ada underline secara default */
        margin-top: 10px;
      }

      .back-to-home:hover {
        text-decoration: underline; /* Menambahkan underline saat hover */
      }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <div class="navbar">
      <h1><span class="highlight">Seek</span> Employer</h1>
      <ul class="nav-list">
        <li><a href="{{ route('workersunion.homepagePerusahaanIndex') }}">Home</a></li>
        <li><a href="#">Pekerjaan</a></li>
        <li><a href="#">Produk</a></li>
        <li><a href="{{ route('workersunion.akunPerusahaanIndex') }}">{{$perusahaans['namaBisnis']}}</a></li> 
        <li><button class="post-job-btn">+ Posting Pekerjaan</button></li>
      </ul>
    </div>
    <!-- Navbar End -->

    <!-- Container Utama -->
    <div class="container">
      <!-- Step Header -->
      <div class="step-header">
        <h2 class="kelola_peran">Buat Iklan Lowongan Kerja</h2>
      </div>

      <!-- Stepper -->
      <div class="stepper">
        <div class="step completed">
          <span>✔</span>
          <p>Klasifikasi</p>
        </div>
        <div class="progress-line"></div>
        <div class="step completed">
          <span>✔</span>
          <p>Jenis Iklan</p>
        </div>
        <div class="progress-line"></div>
        <div class="step completed">
          <span>✔</span>
          <p>Tulis</p>
        </div>
        <div class="progress-line"></div>
        <div class="step completed">
          <span>✔</span>
          <p>Kelola</p>
        </div>
      </div>
      <!-- Stepper End -->

      <!-- Confirmation Section -->
      <div class="confirmation-section">
        <img
          src="images/add_file_image.png"
          alt="Lowongan berhasil diposting"
          class="confirmation-image"
        />
        <h3 style="text-align: center; font-size: 24px; font-weight: 600">
          Anda telah mengirimkan lowongan Anda
        </h3>
        <p style="text-align: center; margin: 20px 0">
          <a href="{{ route('workersunion.homepagePerusahaanIndex') }}" class="back-to-home">Kembali ke halaman utama</a>
        </p>
      </div>
    </div>
    <!-- Container Utama End -->

    <!-- Footer -->
    <footer class="footer">
      <a href="#">Tentang SEEK</a>
      <a href="#">Mitra International</a>
      <a href="#">Layanan Mitra</a>
      <a href="#">Keamanan</a>
      <a href="#">Syarat dan Ketentuan</a>
      <a href="#">Kunjungi Pusat Bantuan Kami</a>
    </footer>

    <!-- JavaScript -->
    <script src="posting_pekerjaan_1.5_script.js"></script>
  </body>
</html>
