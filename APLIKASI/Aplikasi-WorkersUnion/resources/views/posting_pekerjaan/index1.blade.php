<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Seek Employer - Buat Iklan Lowongan Kerja</title>
    <!-- Google Fonts: Poppins -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('css/posting_pekerjaan_1.1_styles.css') }}" >
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

    <!-- Tab Bar -->
    <div class="tab-bar">
      <ul class="tab-list">
        <li><a href="#" class="">Buka</a></li>
        <li><a href="#" class="active">Kandidat</a></li>
      </ul>
    </div>
    <!-- Tab Bar End -->

    <!-- Container Utama -->
    <div class="container">
      <!-- Step Header -->
      <div class="step-header">
        <h2 class="klasifikasi_peran">Buat Iklan Lowongan Kerja</h2>
      </div>

      <!-- Stepper -->
      <div class="stepper">
        <div class="step active">
          <span>1</span>
          <p>Klasifikasi</p>
        </div>
        <div class="progress-line"></div>
        <div class="step">
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

      <!-- Form Section -->
      <div class="form-section">
        <!-- Header Klasifikasi Peran -->
        <h2 class="klasifikasi_peran">Klasifikasikan Peran Anda</h2>

        <!-- Informasi Pribadi -->
        <div class="form-box informasi_pribadi">
          <p class="section-title"><strong>Informasi Pribadi</strong></p>
          <div class="form-group">
            <label for="job-title">Judul Pekerjaan</label>
            <input
              type="text"
              id="job-title"
              placeholder="Masukkan jabatan sederhana (misalnya Asisten Penjualan)"
            />
          </div>
          <div class="form-group">
            <label for="location">Lokasi</label>
            <input
              type="text"
              id="location"
              placeholder="Masukkan pinggiran kota, kota atau wilayah"
            />
          </div>
        </div>
        <!-- Informasi Pribadi End -->

        <!-- Kategori -->
        <div class="form-box kategori">
          <p class="section-title"><strong>Kategori</strong></p>
          <p class="category-suggestion">
            Kategori yang disarankan berdasarkan jabatan Anda
          </p>
          <div class="category">
            <label>
              <input type="radio" id="admin" name="category" />
              Administrasi dan Dukungan Perkantoran
            </label>
            <p class="subcategory">&gt; Asisten Administratif</p>
          </div>
          <div class="category">
            <label>
              <input type="radio" id="retail" name="category" />
              Ritel dan Produk Konsumen
            </label>
            <p class="subcategory">&gt; Asisten Ritel</p>
          </div>
          <div class="category">
            <label>
              <input type="radio" id="sales" name="category" />
              Penjualan
            </label>
            <p class="subcategory">&gt; Perwakilan/Konsultan Penjualan</p>
          </div>
          <div class="category">
            <label>
              <input type="radio" id="custom-category" name="category" />
              Pilih Kategori Berbeda
            </label>
            <div class="custom-input-container">
              <input
                type="text"
                id="custom-category-input"
                class="custom-input"
                placeholder="Masukkan kategori"
              />
            </div>
          </div>
        </div>
        <!-- Kategori End -->

        <!-- Detail Pembayaran -->
        <div class="form-box detail_pembayaran">
          <p class="section-title" style="font-size: 18px; font-weight: bold">
            Detail Pembayaran
          </p>
          <!-- Kategori Gaji -->
          <div class="category-group">
            <p><strong>Kategori Gaji</strong></p>
            <div class="category">
              <label>
                <input type="radio" id="fulltime" name="salary-category" />
                Purnawaktu
              </label>
            </div>
            <div class="category">
              <label>
                <input type="radio" id="parttime" name="salary-category" />
                Paruhwaktu
              </label>
            </div>
            <div class="category">
              <label>
                <input type="radio" id="contract" name="salary-category" />
                Kontrak
              </label>
            </div>
            <div class="category">
              <label>
                <input type="radio" id="casual" name="salary-category" />
                Biasa
              </label>
            </div>
          </div>

          <!-- Jenis Pembayaran -->
          <div class="category-group">
            <p><strong>Jenis Pembayaran</strong></p>
            <div class="category">
              <label>
                <input type="radio" id="hourly" name="payment-type" />
                Tarif per jam
              </label>
            </div>
            <div class="category">
              <label>
                <input type="radio" id="monthly" name="payment-type" />
                Gaji perbulan
              </label>
            </div>
            <div class="category">
              <label>
                <input type="radio" id="annual" name="payment-type" />
                Gaji pertahun
              </label>
            </div>
            <div class="category">
              <label>
                <input type="radio" id="commission" name="payment-type" />
                Tahunan dengan komisi
              </label>
            </div>
          </div>

          <!-- Kisaran Gaji -->
          <p><strong>Kisaran Gaji</strong></p>
          <div class="salary-group">
            <label for="currency">Mata Uang</label>
            <div class="salary-range">
              <select id="currency">
                <option value="IDR">IDR</option>
                <option value="USD">USD</option>
              </select>
              <input type="number" id="salary-min" placeholder="4.900.000" />
              <input type="number" id="salary-max" placeholder="6.900.000" />
            </div>
          </div>
        </div>
        <!-- Detail Pembayaran End -->

        <!-- Tombol Berikutnya -->
        <div class="button-container">
          <button id="next"class="btn-next">Berikutnya</button>
        </div>
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
    <script src="{{ asset('js/posting_pekerjaan_1.1_script.js') }}"></script>
    <script>
      document.getElementById("next").addEventListener("click", function (event) {
    event.preventDefault();

    const judulPekerjaan = document.getElementById("job-title").value.trim();
    const lokasiPekerjaan = document.getElementById("location").value.trim();
    const selectedCategory = document.querySelector('input[name="category"]:checked');
    const kategoriJabatan = selectedCategory.id === "custom-category"
        ? document.getElementById("custom-category-input").value.trim()
        : selectedCategory.nextSibling.textContent.trim();

    const kategoriGaji = document.querySelector('input[name="salary-category"]:checked')?.nextSibling.textContent.trim();
    const jenisGaji = document.querySelector('input[name="payment-type"]:checked')?.nextSibling.textContent.trim();
    const kisaranGaji = `${document.getElementById("currency").value}-${document.getElementById("salary-min").value.trim()}-${document.getElementById("salary-max").value.trim()}`;

    const store = {
        judulPekerjaan,
        lokasiPekerjaan,
        kategoriJabatan,
        kategoriGaji,
        jenisGaji,
        kisaranGaji,
    };

    fetch('{{ route("workersunion.postingPekerjaanStorePage1") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(store),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                alert(data.message);
            }
        })
        .catch((error) => {
            console.error('Error with fetch operation:', error);
        });
});

    </script>
  </body>
</html>
