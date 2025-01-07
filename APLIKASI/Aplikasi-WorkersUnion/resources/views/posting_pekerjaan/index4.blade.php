<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Seek Employer - Kelola Lamaran Kandidat</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset("css/posting_pekerjaan_1.4_styles.css")}}" />
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
        <div class="step active">
          <span>4</span>
          <p>Kelola</p>
        </div>
      </div>
      <!-- Stepper End -->

      <!-- Kelola Lamaran Kandidat -->
      <div class="section-header">
        <h2>
          Kelola lamaran kandidat <span class="optional">(opsional)</span>
        </h2>
      </div>

        <div class="question-section">
          <h4 class="section-title">Rekomendasi pertanyaan</h4>
          <div class="question-options">
            <div class="question-item">
              <input type="checkbox" id="question1" />
              <label for="question1"
                >Berapa gaji bulanan yang Anda inginkan?</label
              >
            </div>
            <div class="question-item">
              <input type="checkbox" id="question2" />
              <label for="question2"
                >Berapa tahun pengalaman Anda sebagai Staff Administrasi?</label
              >
            </div>
            <div class="question-item">
              <input type="checkbox" id="question3" />
              <label for="question3"
                >Produk Microsoft apa saja yang bisa Anda gunakan?</label
              >
            </div>
            <div class="question-item">
              <input type="checkbox" id="question4" />
              <label for="question4"
                >Bagaimana Anda menilai kemampuan bahasa Inggris Anda?</label
              >
            </div>
            <div class="question-item">
              <input type="checkbox" id="question5" />
              <label for="question5"
                >Apakah Anda bersedia bepergian untuk pekerjaan ini saat
                dibutuhkan?</label
              >
            </div>
            <div class="question-item">
              <input type="checkbox" id="question6" />
              <label for="question6"
                >Bahasa apa saja yang fasih Anda gunakan?</label
              >
            </div>
            <div class="question-item">
              <input type="checkbox" id="question7" />
              <label for="question7"
                >Apakah Anda bersedia menjalani pemeriksaan latar
                belakang?</label
              >
            </div>
          </div>
        </div>

      <!-- Submit Button -->
      <div class="button-container">
        <button id="next" class="btn-submit">Pasang Iklan Saya →</button>
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
    <script>
      window.onload = function() {
        document.getElementById("next").addEventListener("click", buttonClicked)
      }
      function buttonClicked(event) {
      event.preventDefault();
      const checkboxes = document.querySelectorAll(".question-options input[type='checkbox']");
      const selectedQuestions = [];
      checkboxes.forEach((checkbox, index) => {
          if (checkbox.checked) {
              selectedQuestions.push(index + 1); 
          }
      });
      const selectedString = selectedQuestions.join(",");
      console.log("Selected questions:", selectedString);

      const store = { selectedString}; 
      fetch('{{ route("workersunion.postingPekerjaanStorePage4") }}', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
    body: JSON.stringify({
        pertanyaan: selectedString,
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
