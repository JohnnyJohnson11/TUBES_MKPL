<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Seek Employer - Pilih Jenis Iklan</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset("css/posting_pekerjaan_1.2_styles.css")}}" >
  </head>
  <body>
    <!-- Navbar -->
    <div class="navbar">
      <h1><span class="highlight">Seek</span> Employer</h1>
      <ul class="nav-list">
        <li><a href="{{ route('workersunion.homepagePerusahaanIndex') }}">Home</a></li>
        <li><a href="{{ route('workersunion.pekerjaanPerusahaan') }}">Pekerjaan</a></li>
        <li><a href="{{ route('workersunion.akunPerusahaanIndex') }}">{{$perusahaans['namaBisnis']}}</a></li> 
        <li><button class="post-job-btn">+ Posting Pekerjaan</button></li>
      </ul>
    </div>
    <!-- Navbar End -->

    <!-- Container Utama -->
    <div class="container">
      <!-- Step Header -->
      <div class="step-header">
        <h2 class="klasifikasi_peran">Buat Iklan Lowongan Kerja</h2>
      </div>

      <!-- Stepper -->
      <div class="stepper">
        <div class="step completed">
          <span>✔</span>
          <p>Klasifikasi</p>
        </div>
        <div class="progress-line"></div>
        <div class="step active">
          <span>2</span>
          <p>Jenis Iklan</p>
        </div>
        <div class="progress-line"></div>
        <div class="step">
          <span>3</span>
          <p>Tulis</p>
        </div>
        <div class="progress-line"></div>
        <div class="step">
          <span>4</span>
          <p>Kelola</p>
        </div>
      </div>
      <!-- Stepper End -->

      <!-- Pilihan Iklan -->
      <div class="ads-selection">
        <div class="ad-option basic" onclick="selectAd('basic')">
          <h3 class="ad-title">Basic</h3>
          <p class="ad-price">Rp 0</p>
          <p>Temukan kandidat terbaik dengan Basic Ad</p>
          <button class="choose-btn">Pilih</button>
          <!-- Pindahkan tombol di sini -->
          <ul>
            <li>Pemasangan iklan selama 30 hari</li>
            <li>Visibilitas tinggi ke kandidat</li>
            <li>Dapatkan kandidat secara cepat</li>
            <li>Kredit akses database kandidat</li>
            <li>Akses laporan dan analisa iklan</li>
            <li>Sertakan logo perusahaan Anda</li>
          </ul>
        </div>
        <div class="ad-option premium" onclick="selectAd('premium')">
          <h3 class="ad-title">Premium</h3>
          <p class="ad-price">Rp 1,46 jt</p>
          <p>Temukan kandidat terbaik dengan Premium Ad</p>
          <button class="choose-btn">Pilih</button>
          <!-- Pindahkan tombol di sini -->
          <ul>
            <li>Pemasangan iklan selama 30 hari</li>
            <li>Visibilitas tinggi ke kandidat</li>
            <li>Dapatkan kandidat secara cepat</li>
            <li>Kredit akses database kandidat</li>
            <li>Akses laporan dan analisa iklan</li>
            <li>Tambahkan gambar perusahaan untuk mempromosikan brand</li>
            <li>Tampilkan 3 poin utama perusahaan untuk menarik kandidat</li>
            <li>Pencantuman prioritas di halaman pencarian</li>
          </ul>
        </div>
        <div class="ad-option premium-plus" onclick="selectAd('premium-plus')">
          <h3 class="ad-title">Premium Plus</h3>
          <p class="ad-price">Rp 2,53 jt</p>
          <p>Temukan kandidat terbaik dengan Premium Plus</p>
          <button class="choose-btn">Pilih</button>
          <!-- Pindahkan tombol di sini -->
          <ul>
            <li>Pemasangan iklan selama 30 hari</li>
            <li>Visibilitas tinggi ke kandidat</li>
            <li>Dapatkan kandidat secara cepat</li>
            <li>Kredit akses database kandidat</li>
            <li>Akses laporan dan analisa iklan</li>
            <li>Tambahkan gambar perusahaan untuk mempromosikan brand</li>
            <li>Tampilkan 3 poin utama perusahaan untuk menarik kandidat</li>
            <li>Pencantuman prioritas di halaman pencarian</li>
            <li>Account manager berdedikasi untuk Anda</li>
            <li>Penulisan iklan lowongan kerja khusus untuk Anda</li>
            <li>Temukan kandidat yang relevan</li>
          </ul>
        </div>
      </div>
      <!-- Pilihan Iklan End -->

      <!-- Tombol Berikutnya -->
      <div class="button-container">
        <button class="btn-next" onclick=changePage()>Berikutnya</button>
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
    <script src="{{ asset("js/posting_pekerjaan_1.2_script.js")}}"></script>
    <script>
      function changePage(){
        window.location.href="{{ route("workersunion.postingPekerjaanPage3")}}";
      }
    </script>
  </body>
</html>
