<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Seek Employer - Tulis Info Lowongan</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset("css/posting_pekerjaan_1.3_styles.css")}}" >
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
        <h2>Tulis Info Lowongan Kerja Anda</h2>
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
        <div class="step active">
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

      <!-- Form Lowongan -->
      <div class="form-section">
        <!-- Upload Logo -->
        <div class="upload-logo">
          <h3>Tampilkan branding perusahaan Anda</h3>
          <p>
            Upload brand pertama Anda dengan mengunggah logo perusahaan Anda.
          </p>
          <div class="logo-upload-box">
            <img
              src="images/search-icon.png"
              alt="Tampilkan branding perusahaan Anda"
              class="logo-preview"
              id="logoPreview"
            />
          </div>
          <button class="add_logo" id="addLogoButton">Tambah Logo</button>
          <input
            type="file"
            id="logoUploader"
            accept="image/*"
            style="display: none"
          />
        </div>

        <!-- Deskripsi Pekerjaan -->
        <div class="job-description">
          <h3>Deskripsi pekerjaan</h3>
          <p>
            Masukkan detail pekerjaan atau panduan tentang apa saja yang harus
            ditulis.
          </p>
          <textarea
            id="jobDescription"
            class="description-editor"
            rows="10"
            placeholder="Deskripsi pekerjaan..."
          ></textarea>
        </div>

        <!-- Video -->
        <div class="video-section">
          <h3>Video (Opsional)</h3>
          <p>Tambahkan video ke iklan Anda dengan link YouTube.</p>
          <input
            id="link"
            type="url"
            class="video-input"
            placeholder="https://www.youtube.com/watch?v=abc123"
          />
        </div>
      </div>
      <!-- Form Lowongan End -->

      <!-- Tombol Berikutnya -->
      <div class="button-container">
        <button id="next" class="btn-next">Berikutnya</button>
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
    <script src="{{ asset("js/posting_pekerjaan_1.3_script.js")}}"></script>
    <script>
      window.onload = function() {
        document.getElementById("next").addEventListener("click", buttonClicked)
      }
      function buttonClicked(event) {
      event.preventDefault();
      var bannerPerusahaan=document.getElementById("logoPreview").src;
      var deskripsiPerusahaan=document.getElementById("jobDescription").value.trim();
      var linkReferensi=document.getElementById("link").value.trim();
        
      const store = { bannerPerusahaan: bannerPerusahaan, deskripsiPerusahaan: deskripsiPerusahaan, linkReferensi:linkReferensi}; 
      fetch('{{ route("workersunion.postingPekerjaanStorePage3") }}', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
    body: JSON.stringify({
        bannerPerusahaan: bannerPerusahaan,
        deskripsiPerusahaan: deskripsiPerusahaan,
        linkReferensi: linkReferensi,
    }),
})
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error with fetch operation:', error);
    });

      }
    </script>
  </body>
</html>
