<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Workers Union - Login</title>
    <link rel="stylesheet" href="{{ asset('css/lihat_profil.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
</head>

<body>
    <nav class="navbar">
        <h1><span class="highlight">Workers</span> Union</h1>
        <ul class="nav-list">
            <li><a href="#">Home</a></li>
            <li><a href="#">Pekerjaan</a></li>
            <li><a href="#">Perusahaan</a></li>
            <li><a href="#">Tentang</a></li>
            <li><a href="#" class="masuk">{{$pekerjas['username']}}</a></li>
            <li><a href="#" class="post-job-btn">+ Posting Pekerjaan</a></li>
        </ul>
    </nav>

    <main>
        <section class="profile">
            <div class="profile-card">
                <h2 id="nama">{{$pekerjas['username']}}</h2>
                <p id="lokasi">{{$pekerjas['lokasi']}}</p>
                <p id="email">{{$pekerjas['email']}}</p>
                <button id="ubahinformasipribadi">Edit</button>
                <button>Bagikan</button>
            </div>
        </section>

        <div id="popup" class="popup">   
                <div class="popup-content">
                    <form id="ringkasanForm" action="{{ route('workersunion.addRingkasan') }}" method="POST" style="margin-top: 20px;">
                    @csrf
                        <span id="closePopup" class="close-btn">&times;</span>
                        <h2>Tambahkan ringkasan pribadi</h2>
                        <label for="summary">Ringkasan</label>
                        <p>Tunjukkan pengalaman unik, ambisi, dan kelebihan Anda.</p>
                        <textarea id="summary" rows="4" cols="50"></textarea>
                        <p class="note" style="margin-bottom: 15px;">Jaga diri Anda. Jangan sertakan informasi pribadi sensitif
                            seperti dokumen identitas, kesehatan, ras, agama, atau data keuangan.</p>
                        <button type="button" class="save-btn" id="simpanbutton">Simpan</button>
                        <button class="cancel-btn" onclick="closePopup()">Batal</button>
                    </form>
                </div>
        </div>

        <div id="popupRiwayat" class="popup">
            <div class="popup-content">
              <form id="riwayatForm" action="{{ route('workersunion.addInformasiPekerjaan') }}" method="POST" style="margin-top: 20px;">
              @csrf
                <span id="closePopupRiwayat" class="close-btn">&times;</span>
                <h2>Riwayat Pekerjaan</h2>
                <label for="summaryPosisi">Posisi pekerjaan</label>
                <textarea id="summaryPosisi" rows="1" cols="50"></textarea>
                <small>Silakan tambahkan Posisi pekerjaan</small>

                <label for="summaryPerusahaan">Nama perusahaan</label>
                <textarea id="summaryPerusahaan" rows="1" cols="50"></textarea>
                <small>Silakan tambahkan Nama perusahaan</small>

                <label for="summaryMulai">Tahun Mulai</label>
                <textarea id="summaryMulai" rows="1" cols="100" placeholder="yyyy"></textarea>

                <label for="summaryBerakhir">Tahun Berakhir</label>
                <textarea id="summaryBerakhir" rows="1" cols="100" placeholder="yyyy"></textarea>

                <input type="checkbox" id="masihJabatanIni"> Masih dalam jabatan ini

                <label for="deskripsi">Deskripsi (direkomendasikan)</label>
                <textarea id="deskripsi"></textarea>
                <small style="display:flex">Deskripsikan tanggung jawab, keahlian, dan pencapaian kamu.</small>

                <button id="simpanriwayatbutton" class="save-btn">Simpan</button>
                <button id="batalRiwayat" class="cancel-btn">Batal</button>
              </form>
            </div>
        </div>

        <div id="popuppendidikan" class="popup">
            <div class="popup-content">
              <form id="riwayatPendidikan" action="{{ route('workersunion.addInformasiPendidikan') }}" method="POST" style="margin-top: 20px;">
              @csrf
                <span id="closePopuppendidikan" class="close-btn">&times;</span>
                <h2>Tambahkan pendidikan</h2>
                <label for="summarykursus">Kursus atau kualifikasi</label>
                <textarea id="summarykursus" rows="1" cols="50"></textarea>
                <label for="summarylembaga">Lembaga</label>
                <textarea id="summarylembaga" rows="1" cols="50"></textarea>
                <div class="checkbox-group" style="display: flex;">
                    <input type="checkbox" id="remember" style="margin-right: 5px;">
                    <p id="kualifikasi" for="remember" style="margin-top: 0px;">Kualifikasi selesai</p>
                </div>
                <label for="summarytahun">Selesai<span style="font-weight: lighter;">(opsional)</span></label>
                <textarea id="summarytahun" rows="1" style="width: 200px;" placeholder="Masukkan tahun"></textarea>
                <label for="summarypoin">Poin penting kursus<span
                        style="font-weight: lighter;">(opsional)</span></label>
                <p class="note" style="margin-bottom: 15px;">Tambahkan kegiatan, proyek, penghargaan, atau pencapaian
                    selama masa akademi kamu.</p>
                <textarea id="summarypoin" rows="4" cols="50"></textarea>
                <p class="note" style="margin-bottom: 15px;">Jaga diri Anda. Jangan sertakan informasi pribadi sensitif
                    seperti dokumen identitas, kesehatan, ras, agama, atau data keuangan.</p>
                <button class="save-btn" id="simpanpendidikanbutton">Simpan</button>
                <button class="cancel-btn" id="batalpendidikan">Batal</button>
              </form>
            </div>
        </div>

        <div id="popuplisensi" class="popup">
            <div class="popup-content">
                <span id="closePopuplisensi" class="close-btn">&times;</span>
                <h2>Tambahkan lisensi atau sertifikasi</h2>
                <p class="note" style="margin-bottom: 15px;">Tunjukkan lisensi, sertifikat, keanggotaan, dan akreditasi anda</p>
                <label for="summarylisensi">Nama Lisensi</label>
                <textarea id="summarylisensi" rows="1" cols="50" placeholder="cth. Surat Izin Mengemudi"></textarea>
                <label for="summarypenerbit">Organisasi penerbit <span class="note">(opsional)</span></label>
                <textarea id="summarypenerbit" rows="1" cols="50"></textarea>
                <label for="tanggalterbit" >Tanggal diterbitkan <span class="note">(opsional)</span></label>
                <div class="form-group" style="display: flex; margin-top: 5px; max-width:20.44625rem">                   
                    <select id="bulantanggalterbit">
                      <option>Bulan</option>
                      <option>Januari</option>
                      <option>Februari</option>
                      <option>Maret</option>
                      <option>April</option>
                      <option>Mei</option>
                      <option>Juni</option>
                      <option>Juli</option>
                      <option>Agustus</option>
                      <option>September</option>
                      <option>Oktober</option>
                      <option>November</option>
                      <option>Desember</option>
                    </select>
                    <select id="tahuntanggalterbit">
                      <option>Tahun</option>
                    </select>
                </div>
                <label for="tanggalkadaluwarsa">Tanggal kadaluwarsa <span class="note" style="text-decoration: none;">(direkomendasikan)</span></label>
                <div class="form-group" style="display: flex; margin-top: 5px;">
                    <select id="bulantanggalkadaluwarsa">
                      <option>Bulan</option>
                      <option>Januari</option>
                      <option>Februari</option>
                      <option>Maret</option>
                      <option>April</option>
                      <option>Mei</option>
                      <option>Juni</option>
                      <option>Juli</option>
                      <option>Agustus</option>
                      <option>September</option>
                      <option>Oktober</option>
                      <option>November</option>
                      <option>Desember</option>
                    </select>
                    <select id="tahuntanggalkadaluwarsa" style="margin-right:50px;">
                      <option>Tahun</option>
                    </select>
                    <div class="checkbox-group"></div>
                        <input type="checkbox" id="no-expiry" style="max-width:15px; margin:5px">Tidak kadaluwarsa</label>
                    </div>
                    <div class="form-group">
                        <label for="summarydescription">Deskripsi <span class="note">(opsional)</span></label>
                        <p class="note" style="margin-bottom: 15px;">Jelaskan kredensial ini secara singkat - kamu juga dapat menambahkan jenis atau URL jika berlaku</p>
                        <textarea id="summarydescription"></textarea>
                    </div>
                    
                    <button class="save-btn" id="simpanlisensibutton">Simpan</button>
                    <button class="cancel-btn" id="batallisensi">Batal</button>
                </div>
                </div> 
        </div>

        <div id="popupkeahlian" class="popup">
            <div class="popup-content">
                <span id="closePopupkeahlian" class="close-btn">&times;</span>
                <h2>Tambahkan Keahlian</h2>
                <p class="note">Bantu perusahaan menemukan Anda dengan menampilkan semua keahlian anda.</p>
                <label for="summary">Tambah keahlian baru</label>
                <textarea id="summarykeahlian" rows="1" cols="50" placeholder="cth. Membangun tim"></textarea>
                <button class="save-btn" id="tambahkeahlianbutton">Tambah</button>
                <p class="note" style="margin-bottom: 15px;">Klik tambahkan atau tekan enter</p>
                <p>Keahlian yang ditambahkan</p>
                <div id="skillsContainer">
                    <p class="note" id="noSkillsMessage">Tidak ada keahlian yang ditambahkan</p>
                  </div>
                <p class="note" style="margin-top: 15px;">Jaga diri Anda. Jangan sertakan informasi pribadi sensitif
                    seperti dokumen identitas, kesehatan, ras, agama, atau data keuangan.</p>
                <button class="save-btn" id="simpankeahlianbutton">Simpan</button>
                <button class="cancel-btn" id="batalkeahlian">Batal</button>
            </div>
        </div>

        <div id="popupbahasa" class="popup">
            <div class="popup-content">
                <span id="closePopupbahasa" class="close-btn">&times;</span>
                <h2>Tambahkan Bahasa</h2>
                <label for="summary">Bahasa</label>
                <textarea id="summarybahasa" rows="1" cols="50" placeholder="cth. Bahasa Inggris, Mandarin, Jerman"></textarea>
                <button class="save-btn" id="simpanbahasabutton">Simpan</button>
                <button class="cancel-btn" id="batalbahasa">Batal</button>
            </div>
        </div>

        <div id="popupresume" class="popup">
            <div class="popup-content">
                <span id="closePopupresume" class="close-btn">&times;</span>
                <h2>Tambah resume</h2>
                <p class="note">
                    Tambahkan hingga 10 resume. Jenis file yang diterima: doc, docx, pdf, txt dan rtf (batas 2MB).
                </p>
                
                <!-- Drag-and-drop upload area -->
                <div class="upload-area" id="upload-area">
                    <div class="upload-content">
                        <img src="{{ asset('images/icon.png') }}" alt="Upload Icon" class="upload-icon">
                        <p>Untuk menambahkan resume, geser dan lepas di sini atau cukup telusuri file.</p>
                        <button class="browse-btn" id="browse-btn">Telusuri</button>
                        <input type="file" id="file-input" accept=".doc,.docx,.pdf,.txt,.rtf" multiple style="display: none;">
                    </div>
                </div>
        
                <!-- Display Uploaded Files -->
                <div id="file-list" class="file-list"></div>
        
                <!-- Privacy notice -->
                <p class="privacy-note">
                    Jaga diri Anda. Jangan sertakan informasi sensitif dalam dokumen Anda. <br>
                    <a href="#" class="privacy-link">Selengkapnya tentang privasi dan penggunaan data</a>
                </p>
        
                <!-- Action buttons -->
                <button class="save-btn" id="simpanresumebutton">Selesai</button>
                <button class="cancel-btn" id="batalresume">Batal</button>
            </div>
        </div>
        
        <div id="popupinformasipribadi" class="popup">
            <div class="popup-content">
                <span id="closePopupinformasipribadi" class="close-btn">&times;</span>
                <h2>Ubah informasi pribadi</h2>

            <!-- Input Fields -->
             <div style="display: flex;">
                <div>
                    <label for="summarynamadepan">Nama Depan</label>
                    <textarea id="summarynamadepan" rows="1" cols="50"></textarea>
                </div>
                <div>
                    <label for="summarynamabelakang">Nama Belakang</label>
                    <textarea id="summarynamabelakang" rows="1" cols="50"></textarea>
                </div>
            </div>
            <label for="summarylokasi">Lokasi Rumah</label>
            <textarea id="summarylokasi" rows="1" cols="50"></textarea>

            <!-- Phone Number -->
            <div class="input-group phone-group">
                <label>Nomor telepon <span class="note">(direkomendasikan)</span></label>
                <div class="phone-inputs">
                    <select id="countryCode">
                        <option value="+62" selected>Indonesia (+62)</option>
                        <option value="+1">United States (+1)</option>
                        <option value="+44">United Kingdom (+44)</option>
                        <option value="+91">India (+91)</option>
                        <option value="+81">Japan (+81)</option>
                        <option value="+86">China (+86)</option>
                        <option value="+61">Australia (+61)</option>
                        <option value="+49">Germany (+49)</option>
                        <option value="+33">France (+33)</option>
                        <option value="+65">Singapore (+65)</option>
                    </select>
                    <input type="text" id="phoneNumber">
                </div>
            </div>

            <!-- Email Section -->
                <label for="summaryemail">Email</label>
                <textarea id="summaryemail" rows="1" cols="50"></textarea>
                <button class="save-btn" id="simpaninformasipribadibutton">Selesai</button>
                <button class="cancel-btn" id="batalinformasipribadi">Batal</button>
            </div>
        </div>

        <section class="content">
            <div class="section">
                <h3>Ringkasan pribadi</h3>
                @if ($pekerjas['ringkasan']==null)
                    <p id="ringkasan">Tambahkan ringkasan pribadi ke profil Anda sebagai cara untuk memperkenalkan siapa anda.</p>
                @else
                    <p id="ringkasan">{{$pekerjas['ringkasan']}}</p>
                @endif
                <button class="add-button" id="tambahringkasan">Tambah Ringkasan</button>
            </div>

            <div class="section">
                <h3>Riwayat pekerjaan</h3>
                @if ($pekerjas['posisiPekerjaan']==null)
                  <p id="posisi">Semakin banyak Anda memberi tahu pemberi kerja tentang pengalaman Anda, semakin Anda bisa menonjol.</p>
                @else
                  <p id="posisi">{{$pekerjas['posisiPekerjaan']}}</p>
                @endif
                <p id="perusahaan">{{$pekerjas['namaPerusahaan']}}</p>
                <p id="tahunkerja">{{ \Carbon\Carbon::parse($pekerjas['tahunMulaiPekerjaan'])->year }}-{{ \Carbon\Carbon::parse($pekerjas['tahunBerakhirPekerjaan'])->year }} ({{ \Carbon\Carbon::parse($pekerjas['tahunBerakhirPekerjaan'])->year - \Carbon\Carbon::parse($pekerjas['tahunMulaiPekerjaan'])->year }} tahun)</p>
                <button class="add-button" id="bukaPopupRiwayat">Tambah Pekerjaan</button>
            </div>

            <div class="section">
                <h3>Pendidikan</h3>
                @if ($pekerjas['kursusPendidikan']==null)
                  <p id="posisi">Semakin banyak Anda memberi tahu pemberi kerja tentang pendidikan Anda, semakin Anda bisa menonjol.</p>
                @else
                  <div class="education-card">
                      <p id="kursus"><strong>{{$pekerjas['kursusPendidikan']}}</strong></p>
                      <p id="lembaga">{{$pekerjas['lembagaPendidikan']}}</p>
                      @if ($pekerjas['statusKualifikasiPendidikan']=="qualified")
                        <p id="tahun">{{ \Carbon\Carbon::parse($pekerjas['tahunSelesaiPendidikan'])->year }}</p>
                      @else
                        <p id="tahun">Diharapkan selesai pada {{ \Carbon\Carbon::parse($pekerjas['tahunSelesaiPendidikan'])->year }}</p>
                      @endif
                      <p id="poin">{{$pekerjas['poinPentingPendidikan']}}</p>
                  </div>
                @endif
                <button class="add-button" id="tambahpendidikan">Tambah Pendidikan</button>
            </div>

            <div class="section">
                <h3>Lisensi & sertifikasi</h3>
                @if ($pekerjas['namaLisensi']==null)
                  <p id="ifnulllisensi">Tunjukkan kredensial profesional Anda. Tambahkan lisensi, sertifikat, keanggotaan, dan akreditasi
                  Anda yang relevan di sini.</p>
                @else
                  <p id="lisensi">{{$pekerjas['namaLisensi']}}</p>
                  <p id="penerbit">{{$pekerjas['organisasiPenerbitLisensi']}}</p>
                  @if($pekerjas['statusLisensi']=="kadaluwarsa")
                    <p id="kadaluwarsa">Kadaluwarsa</p>
                  @else
                    <p id="kadaluwarsa">Kadaluwarsa {{ \Carbon\Carbon::parse($pekerjas['tanggalKadaluwarsaLisensi'])->format('F Y') }}</p>
                  @endif
                  <p id="description">{{$pekerjas['deskripsiLisensi']}}</p>
                @endif
                <button class="add-button" id="tambahlisensi">Tambah Lisensi atau sertifikasi</button>
            </div>

            <div class="section">
                <h3>Skill</h3>
                <p id="ifnullskill">Biarkan pemberi kerja tahu betapa berharganya Anda bagi mereka.</p>
                <p id="skills"></p>
                <button class="add-button" id="tambahkeahlian">Tambah Skill</button>
                <button class="add-button" id="hapuskeahlian" style="background-color:red">Hapus Skill</button>
            </div>

            <div class="section">
                <h3>Bahasa</h3>
                <p id="ifnullbahasa">Tambahkan bahasa untuk menarik lebih banyak perusahaan dan pemberi kerja.</p>
                <p id="bahasa"></p>
                <button class="add-button" id="tambahbahasa">Tambah Bahasa</button>
            </div>

            <div class="section">
                <h3>Resume atau CV</h3>
                <p>Unggah resume atau CV agar mudah melamar dan mengakses di mana pun Anda berada.</p>
                <p id="resumefile"></p>
                <button class="add-button" id="tambahresume">Tambah Resume atau CV</button>
            </div>
        </section>
    </main>
    <script>
        function populateYearOptions(selectId, startYear, endYear) {
  const selectElement = document.getElementById(selectId);
  for (let year = startYear; year <= endYear; year++) {
    const option = document.createElement('option');
    option.value = year;
    option.textContent = year;
    selectElement.appendChild(option);
  }
}
const currentYear = new Date().getFullYear();
populateYearOptions('tahuntanggalterbit', 1900, currentYear); 
populateYearOptions('tahuntanggalkadaluwarsa', 1900, currentYear + 10);

document.getElementById("tambahringkasan").addEventListener("click", function() {
  document.getElementById("popup").classList.add("active");
});

document.getElementById("closePopup").addEventListener("click", function() {
  document.getElementById("popup").classList.remove("active");
});

document.getElementById("tambahpendidikan").addEventListener("click", function() {
  document.getElementById("popuppendidikan").classList.add("active");
});

document.getElementById("closePopuppendidikan").addEventListener("click", function() {
  document.getElementById("popuppendidikan").classList.remove("active");
});

document.getElementById("batalpendidikan").addEventListener("click", function() {
  document.getElementById("popuppendidikan").classList.remove("active");
});

document.getElementById("simpanbutton").addEventListener("click", function(event) {
  event.preventDefault(); // Prevent default form submission
  const ringkasanText = document.getElementById("summary").value.trim();

  if (ringkasanText === "") {
      alert("Ringkasan tidak boleh kosong.");
      return;
  }

  fetch('{{ route("workersunion.addRingkasan") }}', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      },
      body: JSON.stringify({ ringkasan: ringkasanText }),
  })
  .then((response) => {
      if (!response.ok) {
          throw new Error('Network response was not ok');
      }
      return response.json();
  })
  .then((data) => {
      if (data.success) {
          const ringkasanElement = document.getElementById("ringkasan");
          ringkasanElement.textContent = ringkasanText;
          document.getElementById("popup").classList.remove("active");
          document.getElementById("summary").value = "";
      } else {
          alert('Error: ' + data.message);
      }
  })
  .catch((error) => {
      console.error('There was a problem with the fetch operation:', error);
  });
});


document.getElementById("simpanpendidikanbutton").addEventListener("click", function (event) {
    event.preventDefault();

    // Collect form data
    const summaryKursusText = document.getElementById("summarykursus").value.trim();
    const summaryLembagaText = document.getElementById("summarylembaga").value.trim();
    const summaryTahunText = document.getElementById("summarytahun").value.trim();
    const summaryPoinText = document.getElementById("summarypoin").value.trim();
    const kualifikasiSelesai = document.getElementById('remember').checked ? "qualified" : "notqualified";

    // Validate required fields
    if (!summaryKursusText || !summaryLembagaText || !summaryTahunText) {
        alert("Bidang wajib harus diisi.");
        return;
    }

    // Prepare the payload
    const informasiPendidikan = {
        kursusPendidikan: summaryKursusText,
        lembagaPendidikan: summaryLembagaText,
        statusKualifikasiPendidikan: kualifikasiSelesai,
        tahunSelesaiPendidikan: parseInt(summaryTahunText, 10),
        poinPentingPendidikan: summaryPoinText,
    };

    // Send data via fetch
    fetch('{{ route("workersunion.addInformasiPendidikan") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(informasiPendidikan),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`Network response was not ok: ${response.statusText}`);
            }
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                // Update UI
                document.getElementById("kursus").innerHTML = `<strong>${summaryKursusText}</strong>`
                document.getElementById("lembaga").textContent = summaryLembagaText;
                if (kualifikasiSelesai=="qualified"){
                  document.getElementById("tahun").textContent = summaryTahunText;
                } else {
                  document.getElementById("tahun").textContent = `Diharapkan selesai pada `+summaryTahunText;
                }
                document.getElementById("poin").textContent = summaryPoinText;

                // Clear popup and reset fields
                document.getElementById("popuppendidikan").classList.remove("active");
                document.getElementById("summarykursus").value = "";
                document.getElementById("summarylembaga").value = "";
                document.getElementById("summarytahun").value = "";
                document.getElementById("summarypoin").value = "";
                document.getElementById("remember").checked = false;
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch((error) => {
            console.error('There was a problem with the fetch operation:', error);
        });
});




document.getElementById("simpanriwayatbutton").addEventListener("click", function(event) {
    event.preventDefault();

    var summaryPosisiText = document.getElementById("summaryPosisi").value.trim();
    var summaryPerusahaanText = document.getElementById("summaryPerusahaan").value.trim();
    var summaryMulaiText = parseInt(document.getElementById("summaryMulai").value, 10);
    var summaryBerakhirText = parseInt(document.getElementById("summaryBerakhir").value, 10);
    var deskripsiText = document.getElementById("deskripsi").value.trim();

    var statusJabatan = document.getElementById('masihJabatanIni').checked ? "Masih dalam jabatan" : "Tidak dalam jabatan";
    if (!summaryPosisiText || !summaryPerusahaanText || !summaryMulaiText || !summaryBerakhirText || !deskripsiText) {
        alert("Semua bidang harus diisi.");
        return;
    }
    const informasiPekerjaan = {
        posisiPekerjaan: summaryPosisiText,
        namaPerusahaan: summaryPerusahaanText,
        tahunMulaiPekerjaan: summaryMulaiText,
        tahunBerakhirPekerjaan: summaryBerakhirText, 
        statusJabatanPekerjaan: statusJabatan,
        deskripsiPekerjaan: deskripsiText
    };

    fetch('{{ route("workersunion.addInformasiPekerjaan") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(informasiPekerjaan),
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.statusText}`);
        }
        return response.json();
    })
    .then((data) => {
        if (data.success) {
            const posisiElement = document.getElementById("posisi");
            posisiElement.textContent = summaryPosisiText;
            const perusahaanElement = document.getElementById("perusahaan");
            perusahaanElement.textContent = summaryPerusahaanText;
            const tahunElement = document.getElementById("tahunkerja");
            tahunElement.textContent = summaryMulaiText + "-" + summaryBerakhirText + " (" +(summaryBerakhirText-summaryMulaiText)+" tahun)";
            document.getElementById("popupRiwayat").classList.remove("active");
            document.getElementById("summary").value = "";
        } else {
            alert(`Error: ${data.message}`);
        }
    })
    .catch((error) => {
        console.error('There was a problem with the fetch operation:', error);
    });
});


document.getElementById("bukaPopupRiwayat").addEventListener("click", function() {
  document.getElementById("popupRiwayat").classList.add("active");
});


document.getElementById("closePopupRiwayat").addEventListener("click", function() {
  document.getElementById("popupRiwayat").classList.remove("active");
});

document.getElementById("batalRiwayat").addEventListener("click", function() {
  document.getElementById("popupRiwayat").classList.remove("active");
});



document.getElementById("simpanlisensibutton").addEventListener("click", function() {
  event.preventDefault();

    var summaryLisensiText = document.getElementById("summarylisensi").value.trim();
    var summaryPenerbitText = document.getElementById("summarypenerbit").value.trim();
    var summaryTanggalTerbit = document.getElementById("tahuntanggalterbit").value + "-" + document.getElementById("bulantanggalterbit").selectedIndex.toString().padStart(2, '0') + "-05";
    var summaryTanggalKadaluwarsa = document.getElementById("tahuntanggalkadaluwarsa").value + "-" + document.getElementById("bulantanggalkadaluwarsa").selectedIndex.toString().padStart(2, '0') + "-05";
    var statusKadaluwarsa = document.getElementById("no-expiry").checked ? "notkadaluwarsa" : "kadaluwarsa";
    var deskripsiLisensi = document.getElementById("summarydescription").value.trim();
    if (!summaryLisensiText) {
        alert("Semua bidang harus diisi.");
        return;
    }
    if (document.getElementById("bulantanggalterbit").selectedIndex.toString().padStart(2, '0')=="00"||document.getElementById("bulantanggalkadaluwarsa").selectedIndex.toString().padStart(2, '0')=="00"){
      alert("pilih bulan");
      return;
    }
    const informasiLisensi = {
        namaLisensi: summaryLisensiText,
        organisasiPenerbitLisensi: summaryPenerbitText,
        tanggalTerbitLisensi: summaryTanggalTerbit,
        tanggalKadaluwarsaLisensi: summaryTanggalKadaluwarsa, 
        statusLisensi: statusKadaluwarsa,
        deskripsiLisensi: deskripsiLisensi
    };

    fetch('{{ route("workersunion.addInformasiLisensi") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(informasiLisensi),
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.statusText}`);
        }
        return response.json();
    })
    .then((data) => {
        if (data.success) {
            const lisensiElement = document.getElementById("lisensi");
            lisensiElement.textContent = summaryLisensiText;
            const penerbitElement = document.getElementById("penerbit");
            penerbitElement.textContent = summaryPenerbitText;
            if (statusKadaluwarsa=="notkadaluwarsa"){
              document.getElementById("kadaluwarsa").textContent="Kadaluwarsa "+document.getElementById("bulantanggalterbit").options[document.getElementById("bulantanggalterbit").selectedIndex].text+" "+document.getElementById("tahuntanggalkadaluwarsa").value;
            } else {
              document.getElementById("kadaluwarsa").textContent="Kadaluwarsa";
            }
            const descriptionElement = document.getElementById("description");
            descriptionElement.textContent = deskripsiLisensi;
            document.getElementById("popupRiwayat").classList.remove("active");
            document.getElementById("summary").value = "";
        } else {
            alert(`Error: ${data.message}`);
        }
    })
    .catch((error) => {
        console.error('There was a problem with the fetch operation:', error);
    });
});

document.getElementById("tambahlisensi").addEventListener("click", function() {
  document.getElementById("popuplisensi").classList.add("active");
});

document.getElementById("closePopuplisensi").addEventListener("click", function() {
  document.getElementById("popuplisensi").classList.remove("active");
});

document.getElementById("batallisensi").addEventListener("click", function() {
  document.getElementById("popuplisensi").classList.remove("active");
});

document.getElementById("tambahkeahlian").addEventListener("click", function() {
  document.getElementById("popupkeahlian").classList.add("active");
});

document.getElementById("closePopupkeahlian").addEventListener("click", function() {
  document.getElementById("popupkeahlian").classList.remove("active");
});

document.getElementById("batalkeahlian").addEventListener("click", function() {
  document.getElementById("popupkeahlian").classList.remove("active");
});

//bagian skill
document.getElementById("tambahkeahlianbutton").addEventListener("click", function () {
  const skillInput = document.getElementById("summarykeahlian");
  const skillsContainer = document.getElementById("skillsContainer");
  const noSkillsMessage = document.getElementById("noSkillsMessage");

  const skillValue = skillInput.value.trim();
  if (skillValue === "") {
    alert("Masukkan keahlian terlebih dahulu.");
    return;
  }
  if (noSkillsMessage) {
    noSkillsMessage.remove();
  }
  const skillBox = document.createElement("div");
  skillBox.className = "skill-box";
  skillBox.innerHTML = `
    <span style="display:flex;">${skillValue}</span>
    <button class="remove-skill-btn" title="Hapus keahlian">&times;</button>
  `;
  skillBox.querySelector(".remove-skill-btn").addEventListener("click", function () {
    skillsContainer.removeChild(skillBox);
    if (skillsContainer.children.length === 0) {
      const message = document.createElement("p");
      message.className = "note";
      message.id = "noSkillsMessage";
      message.textContent = "Tidak ada keahlian yang ditambahkan";
      skillsContainer.appendChild(message);
    }
  });
  skillsContainer.appendChild(skillBox);
  skillInput.value = "";
});
document.getElementById("simpankeahlianbutton").addEventListener("click", function () {
  const popupSkillsContainer = document.getElementById("skillsContainer");
  const mainSkillsContainer = document.getElementById("skills");
  const skillBoxes = popupSkillsContainer.querySelectorAll(".skill-box");

  const skills = [];

  skillBoxes.forEach(function (skillBox) {
    const skillText = skillBox.querySelector("span").textContent.trim();
    skills.push(skillText); // Add skill to the array

    // Create skill box for the main container
    const newSkillBox = document.createElement("p");
    newSkillBox.className = "skill-box";
    newSkillBox.innerHTML = skillBox.innerHTML;

    // Add remove button functionality
    newSkillBox.querySelector(".remove-skill-btn").addEventListener("click", function () {
      mainSkillsContainer.removeChild(newSkillBox);
      if (mainSkillsContainer.children.length === 0) {
        const message = document.createElement("p");
        message.className = "note";
        message.id = "noSkillsMessage";
        message.textContent = "Tidak ada keahlian yang ditambahkan";
        mainSkillsContainer.appendChild(message);
      }
    });

    mainSkillsContainer.appendChild(newSkillBox);
  });

  // Close popup
  document.getElementById("popupkeahlian").classList.remove("active");

  // Handle no skills message
  const noSkillsMessage = document.getElementById("noSkillsMessage");
  if (mainSkillsContainer.children.length > 0) {
    if (noSkillsMessage) {
      noSkillsMessage.remove();
    }
  } else {
    if (!noSkillsMessage) {
      const message = document.createElement("p");
      message.className = "note";
      message.id = "noSkillsMessage";
      message.textContent = "Tidak ada keahlian yang ditambahkan";
      mainSkillsContainer.appendChild(message);
    }
  }

  // Send collected skills to the server
  fetch('{{ route("workersunion.addSkills") }}', {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
    },
    body: JSON.stringify({ skills }),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Network response was not ok: ${response.statusText}`);
      }
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        alert("Skills saved successfully!");
      } else {
        alert(`Error: ${data.message}`);
      }
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
    });
});


document.getElementById("tambahbahasa").addEventListener("click", function() {
  document.getElementById("popupbahasa").classList.add("active");
});

document.getElementById("closePopupbahasa").addEventListener("click", function() {
  document.getElementById("popupbahasa").classList.remove("active");
});

document.getElementById("batalbahasa").addEventListener("click", function() {
  document.getElementById("popupbahasa").classList.remove("active");
});

document.getElementById("simpanbahasabutton").addEventListener("click", function() {
  var summarybahasaText = document.getElementById("summarybahasa").value;

  if (summarybahasaText.trim() === "") {
      alert("Data tidak boleh kosong.");
      return;
  }

  document.getElementById("ifnullbahasa").innerHTML = "";
  document.getElementById("bahasa").innerHTML = summarybahasaText;
  
  var existingSummary = summarySection.querySelector("p.summary-text");
  if (existingSummary) {
      existingSummary.innerHTML = summaryText; 
  } else {
      var newSummary = document.createElement("p");
      newSummary.innerHTML = summaryText; 
      newSummary.classList.add("summary-text");
      content.innerHTML = ""; 
      summarySection.insertBefore(newSummary, summarySection.querySelector(".add-button"));
  }
  document.getElementById("popup").classList.remove("active");
  document.getElementById("summary").value = ""; 
});

document.getElementById("tambahresume").addEventListener("click", function() {
  document.getElementById("popupresume").classList.add("active");
});

document.getElementById("closePopupresume").addEventListener("click", function() {
  document.getElementById("popupresume").classList.remove("active");
});

document.getElementById("batalresume").addEventListener("click", function() {
  document.getElementById("popupresume").classList.remove("active");
});


const uploadArea = document.getElementById("upload-area");
const browseBtn = document.getElementById("browse-btn");
const fileInput = document.getElementById("file-input");
const fileList = document.getElementById("file-list");


let uploadedFiles = [];


browseBtn.addEventListener("click", () => {
    fileInput.click();
});


fileInput.addEventListener("change", (event) => {
    handleFiles(event.target.files);
});


uploadArea.addEventListener("dragover", (event) => {
    event.preventDefault(); 
    uploadArea.style.borderColor = "#007bff";
});

uploadArea.addEventListener("dragleave", () => {
    uploadArea.style.borderColor = "#ccc"; 
});

uploadArea.addEventListener("drop", (event) => {
    event.preventDefault();
    uploadArea.style.borderColor = "#ccc"; 
    const files = event.dataTransfer.files;
    handleFiles(files);
});


function handleFiles(files) {
    const allowedTypes = ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "text/plain"];
    const maxFileSize = 2 * 1024 * 1024; // 

    Array.from(files).forEach((file) => {
        if (uploadedFiles.length >= 10) {
            alert("Anda hanya dapat mengunggah hingga 10 file.");
            return;
        }

        if (!allowedTypes.includes(file.type)) {
            alert(`Jenis file tidak didukung: ${file.name}`);
        } else if (file.size > maxFileSize) {
            alert(`Ukuran file terlalu besar (maks 2MB): ${file.name}`);
        } else {
            uploadedFiles.push(file);
            displayFiles();
        }
    });
}


function displayFiles() {
    fileList.innerHTML = ""; 
    uploadedFiles.forEach((file, index) => {
        const fileItem = document.createElement("div");
        fileItem.className = "file-item";
        fileItem.innerHTML = `
            <span>${file.name} (${(file.size / 1024).toFixed(1)} KB)</span>
            <button class="remove-btn" data-index="${index}">Hapus</button>
        `;
        fileList.appendChild(fileItem);
    });


    document.querySelectorAll(".remove-btn").forEach((btn) => {
        btn.addEventListener("click", removeFile);
    });
}


function removeFile(event) {
    const fileIndex = event.target.getAttribute("data-index");
    uploadedFiles.splice(fileIndex, 1);
    displayFiles();
}

document.getElementById("simpanresumebutton").addEventListener("click", function () {
  const uploadedFilesContainer = document.getElementById("file-list"); 
  const mainResumeContainer = document.getElementById("resumefile");   


  mainResumeContainer.innerHTML = "";


  const fileItems = uploadedFilesContainer.querySelectorAll(".file-item");

  if (fileItems.length === 0) {
      const message = document.createElement("p");
      message.className = "note";
      message.textContent = "Tidak ada resume yang ditambahkan";
      mainResumeContainer.appendChild(message);
      return;
  }


  fileItems.forEach(function (fileItem) {
      const fileName = fileItem.querySelector("span").textContent; // 

      const fileDisplay = document.createElement("p");
      fileDisplay.className = "uploaded-resume";
      fileDisplay.textContent = fileName;

      mainResumeContainer.appendChild(fileDisplay);
  });

  document.getElementById("popupresume").classList.remove("active");

  const noResumeMessage = document.getElementById("noResumeMessage");
  if (noResumeMessage) {
      noResumeMessage.remove();
  }
});

document.getElementById("ubahinformasipribadi").addEventListener("click", function() {
  document.getElementById("popupinformasipribadi").classList.add("active");
});

document.getElementById("closePopupinformasipribadi").addEventListener("click", function() {
  document.getElementById("popupinformasipribadi").classList.remove("active");
});

document.getElementById("batalinformasipribadi").addEventListener("click", function() {
  document.getElementById("popupinformasipribadi").classList.remove("active");
});

document.getElementById("simpaninformasipribadibutton").addEventListener("click", function() {
  var summaryNamaText = document.getElementById("summarynamadepan").value+" "+document.getElementById("summarynamabelakang").value;
  var summaryLokasiText = document.getElementById("summarylokasi").value;
  var summaryEmailText = document.getElementById("summaryemail").value;

  if (summaryNamaText.trim() === ""||summaryLokasiText.trim() === ""||summaryEmailText.trim() === "") {
      alert("Data tidak boleh kosong.");
      return;
  }

  document.getElementById("nama").innerHTML = summaryNamaText;
  document.getElementById("lokasi").innerHTML = summaryLokasiText;
  document.getElementById("email").innerHTML = summaryEmailText;

  var existingSummary = summarySection.querySelector("p.summary-text");
  if (existingSummary) {
      existingSummary.innerHTML = summaryText; 
  } else {
      var newSummary = document.createElement("p");
      newSummary.innerHTML = summaryText; 
      newSummary.classList.add("summary-text");
      content.innerHTML = ""; 
      summarySection.insertBefore(newSummary, summarySection.querySelector(".add-button"));
  }
  document.getElementById("popup").classList.remove("active");
  document.getElementById("summary").value = ""; 
});

document.addEventListener("DOMContentLoaded", () => {
    const idPekerja = {{ json_encode(session('idPekerja')) }};
    const skillsContainer = document.getElementById("skills");
    const ifNullMessage = document.getElementById("ifnullskill");

    fetch(`{{ route("workersunion.getSkills") }}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
        body: JSON.stringify({ idPekerja }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            if (data.success && data.skills) {
                skillsContainer.innerHTML = "";
                data.skills.forEach((skill) => {
                    const skillBox = document.createElement("div");
                    skillBox.className = "skill-box";
                    skillBox.textContent = skill.skill;
                    skillsContainer.appendChild(skillBox);
                });
                if (data.skills.length > 0 && ifNullMessage) {
                    ifNullMessage.style.display = "none";
                }
            } else {
                console.error("No skills found or invalid response format.");
            }
        })
        .catch((error) => {
            console.error("Error loading skills:", error);
        });
});
document.getElementById("hapuskeahlian").addEventListener("click", function () {
  

  fetch('{{ route("workersunion.deleteSkills") }}', {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
    }
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Network response was not ok: ${response.statusText}`);
      }
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        alert("Skills deleted successfully!");
        const skillsContainer = document.getElementById('skills');
        skillsContainer.remove();
        document.getElementById("ifNullSkill").textContent= 'Biarkan pemberi kerja tahu betapa berharganya Anda bagi mereka.';
      } else {
        alert(`Error: ${data.message}`);
      }
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
    });
});


    </script>
    
</body>

</html>