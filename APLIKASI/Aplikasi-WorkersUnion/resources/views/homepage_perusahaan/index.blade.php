<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Workers Union - Pekerjaan Perusahaan</title>
    <link rel="stylesheet" href="{{ asset('css/homepage_perusahaan.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <h1><span class="highlight">Seek</span> Employer</h1>
        <ul class="nav-list">
          <li><a href="{{ route('workersunion.homepagePerusahaanIndex') }}">Home</a></li>
          <li><a href="{{ route('workersunion.pekerjaanPerusahaan') }}">Pekerjaan</a></li>
          <li><a href="{{ route('workersunion.akunPerusahaanIndex') }}">{{$perusahaans['namaBisnis']}}</a></li> 
          <li><a href="{{ route('workersunion.postingPekerjaanPage1') }}" class="post-job-btn">+ Posting Pekerjaan</a></li>
        </ul>
      </nav>

    <main>
        <section class="intro">
            <h2>Temukan orang terbaik untuk lowongan Anda</h2>
            <div class="features">
                <div class="feature">
                    <img src="./images/person.png" alt="Create Job Icon">
                    <h3>Buat iklan pekerjaan</h3>
                    <p>Panduan langkah demi langkah kami membuat pengeposan iklan lowongan Anda menjadi cepat dan mudah.</p>
                </div>
                <div class="feature">
                    <img src="./images/note1.png" alt="Select Type Icon" style="
                    padding-bottom: 10px;
                ">
                    <h3>Pilih jenis iklan Anda</h3>
                    <p>Kami memiliki tiga jenis iklan berbeda untuk memenuhi semua kebutuhan Anda.</p>
                </div>
                <div class="feature">
                    <img src="./images/note2.png" alt="Manage Candidates Icon" style="max-width: 35%;padding-top: 30px;padding-bottom: 16px;">
                    <h3>Kelola kandidat Anda</h3>
                    <p>Kami memudahkan Anda mengidentifikasi kandidat terbaik yang melamar peran Anda.</p>
                </div>
            </div>
        </section>

        <section class="job-listings">
            <h3>Iklan pekerjaan terbaru saya</h3> <!-- Tampilkan tabel pelamar -->
            <table id="pekerjaan">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Pekerjaan</th>
                        <th>Jumlah Kandidat</th>
                        <th>Tindakan pekerjaan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="cta-section">
            <div class="cta" style="background-color: #004DAE">
                <img src="./images/rocket.png" alt="Select Type Icon">
                <div style="
                margin-right: 60px;
            ; ">
                    <h4 style="color: #fff; margin-bottom: 15px; margin-top: 15px;">Tingkatkan perekrutan Anda dengan rekomendasi kandidat</h4>
                    <p style="color: #fff">Saat Anda memasang iklan pekerjaan, kami akan mencocokkan Anda dengan kandidat yang relevan dari database kami.</p>
                    <a href="{{ route('workersunion.postingPekerjaanPage1') }}" class="cta-button">Pasang iklan pekerjaan</a>
                </div>
            </div>
            <div class="cta" style="background-color: #BDDFFF; margin-right: 60px; ">
                <img src="./images/coupon.png" alt="Select Type Icon">
                <div>
                    <h4 style="margin-bottom: 15px; margin-top: 15px;">Bayar di muka dan hemat!</h4>
                    <p>Bayar di muka dan dapatkan diskon untuk iklan Anda.</p>
                    <a href="#" class="cta-button">Lihat diskon</a>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <button>Tentang SEEK</button> | <button>Mitra Internasional</button> | <button>Layanan Mitra</button> | 
        <button>Keamanan</button> | <button>Syarat & Ketentuan</button> | <button>Kunjungi Kami</button> | 
        <button>Pusat Bantuan</button> | <button>Workers Union</button>
    </footer>
</body>
<script>
    document.addEventListener("DOMContentLoaded", () => {
    const idPerusahaan = {{ json_encode(session('idPerusahaan')) }};
    const pekerjaanTableBody = document.querySelector("#pekerjaan tbody");

    fetch(`{{ route("workersunion.getPekerjaan") }}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
        body: JSON.stringify({ idPerusahaan }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            if (data.success && data.pekerjaans) {
                pekerjaanTableBody.innerHTML = ""; 
                data.pekerjaans.forEach((pekerjaan) => {
                    const row = document.createElement("tr");
                    const statusCell = document.createElement("td");
                    statusCell.innerHTML = `<span class="status active">Aktif</span>`;
                    
                    const judulCell = document.createElement("td");
                    judulCell.innerHTML = `${pekerjaan.judulPekerjaan}<br><span>${pekerjaan.lokasiPekerjaan || "-"}</span>`;

                    fetch(`{{ route("workersunion.getPekerjaanAndLamaran") }}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        },
                        body: JSON.stringify({ idPerusahaan, idPekerjaan: pekerjaan.idPekerjaan }), 
                    })
                        .then((response) => {
                            if (!response.ok) {
                                throw new Error("Network response was not ok");
                            }
                            return response.json();
                        })
                        .then((lamaranData) => {
                            const kandidatCell = document.createElement("td");
                            kandidatCell.textContent = lamaranData['pekerjaan'].totalResumes || "-";

                            const tindakanCell = document.createElement("td");
                            tindakanCell.textContent = lamaranData['pekerjaan'].totalResumes - parseInt(lamaranData['pekerjaan'].pendingResumes) ; 

                            row.appendChild(statusCell);
                            row.appendChild(judulCell);
                            row.appendChild(kandidatCell);
                            row.appendChild(tindakanCell);
                        })
                        .catch((error) => {
                            console.error("Error fetching lamaran data:", error);
                        });

                    pekerjaanTableBody.appendChild(row);
                });
            } else {
                console.error("No pekerjaan found or invalid response format.");
            }
        })
        .catch((error) => {
            console.error("Error loading pekerjaan:", error);
        });
});


</script>
</html>
