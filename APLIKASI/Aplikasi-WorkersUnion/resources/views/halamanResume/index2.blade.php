<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jawaban Pertanyaan Perusahaan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/lamarPekerjaan2.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <h1 style="color: #FC766A;"><span class="highlight">Workers</span> Union</h1>
        <ul class="nav-list">
            <li><a href="#">Home</a></li>
            <li><a href="#">Pekerjaan</a></li>
            <li><a href="#">Perusahaan</a></li>
            <li><a href="#">Tentang</a></li>
            <li><a href="#" class="post-job-btn">+ Posting Pekerjaan</a></li>
        </ul>
    </nav>

    <!-- Header -->
    <div class="header">
        <img src="{{$pekerjaan['logoPerusahaan']}}" alt="Company Logo">
        <div>
            <h2><strong>{{$pekerjaan['kategoriJabatan']}}</strong></h2>
            <p>{{$pekerjaan['namaBisnis']}}</p>
        </div>
    </div>
    
    <div class="stepper">
        <div class="step">
            <span>1</span>
            <p>Jawab Pertanyaan Perusahaan</p>
          </div>
          <img
            src="images/progress_line.png"
            alt="progress line"
            class="progress-line"
          />
          <div class="step active">
            <span>2</span>
            <p>Upload Profil</p>
          </div>
          <img
            src="images/progress_line.png"
            alt="progress line"
            class="progress-line"
          />
          <div class="step">
            <span>3</span>
            <p>Tinjau dan Kirim</p>
          </div>

        
    </div>
    <div class="container" style="background:none; box-shadow: 0 2px 5px rgba(0, 0, 0, 0); padding:0px;" >
    <div class="add-button" onclick="window.location.href='{{ route('workersunion.profilePage') }}';">Ubah Profil</div>
        <button onclick="window.location.href='{{ route('workersunion.lamarPekerjaanPage3') }}';">Berikutnya</button>
    </div>
    <div class="container">
        <h3>Riwayat pekerjaan</h3>
        @if ($pekerjas['posisiPekerjaan']==null)
            <p id="posisi">Semakin banyak Anda memberi tahu pemberi kerja tentang pengalaman Anda, semakin Anda bisa menonjol.</p>
        @else
            <p id="posisi">{{$pekerjas['posisiPekerjaan']}}</p>
        @endif
        <p id="perusahaan">{{$pekerjas['namaPerusahaan']}}</p>
        <p id="tahunkerja">{{ \Carbon\Carbon::parse($pekerjas['tahunMulaiPekerjaan'])->year }}-{{ \Carbon\Carbon::parse($pekerjas['tahunBerakhirPekerjaan'])->year }} ({{ \Carbon\Carbon::parse($pekerjas['tahunBerakhirPekerjaan'])->year - \Carbon\Carbon::parse($pekerjas['tahunMulaiPekerjaan'])->year }} tahun)</p>
    </div>

    <!-- Education Section -->
    <div class="container">
        <h2 class="section-title">Pendidikan</h2>
        <div class="education-item">
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
        </div>
    </div>

    <!-- Licenses & Certifications -->
    <div class="container">
        <h2 class="section-title">Lisensi & Sertifikasi</h2>
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
    </div>

    <div class="container">
        <h2 class="section-title">Skill</h2>
        <p id="ifnullskill">Biarkan pemberi kerja tahu betapa berharganya Anda bagi mereka.</p>
        <p id="skills"></p>
    </div>
</body>
<script>
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
</script>
</html>