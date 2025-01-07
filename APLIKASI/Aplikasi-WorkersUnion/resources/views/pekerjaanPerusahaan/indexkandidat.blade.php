<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kandidat</title>
    <link rel="stylesheet" href="{{ asset('css/pekerjaanPerusahaan.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <div class="tabs">
            <a href="{{ route('workersunion.pekerjaanPerusahaan') }}">Buka</a>
            <a href="{{ route('workersunion.pekerjaanPerusahaanKandidat') }}" class="active">Kandidat</a>
        </div>
        <div class="content">
            <h1>Kandidat</h1>
            <p>Cari kandidat terbaru dan sebelumnya</p>
            <div class="search-bar">
                <input type="text" placeholder="Cari berdasarkan nama, jabatan, email">
            </div>
            <div class="candidate-list" id="candidateList">
                <!-- Candidate cards will be dynamically injected here -->
            </div>
        </div>
    </main>

    <!-- QA Dialog -->
    <div id="dialog" class="dialog-overlay" style="display: none;">
        <div class="dialog-content">
            <button id="close-dialog" style="float: right;">✖</button>
            <h3>Pertanyaan dan Jawaban</h3>
            <div id="dialog-qa">
                <!-- Questions and answers will be dynamically added here -->
            </div>
        </div>
    </div>

    <!-- Profile Dialog -->
    <div id="profile-dialog" class="dialog-overlay" style="display: none;">
        <div class="dialog-content">
            <button id="close-profile-dialog" style="float: right;">✖</button>
            <h3>Profil Kandidat</h3>
            <div id="profile-content">
                <!-- Profile details will be dynamically added here -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const idPekerja = {{ json_encode(session('idPekerja')) }};
    
            const candidateList = document.getElementById("candidateList");
            const dialog = document.getElementById("dialog");
            const dialogQA = document.getElementById("dialog-qa");
            const closeDialog = document.getElementById("close-dialog");

            const profileDialog = document.getElementById("profile-dialog");
            const profileContent = document.getElementById("profile-content");
            const closeProfileDialog = document.getElementById("close-profile-dialog");

            // Mapping of pertanyaan numbers to actual questions
            const questionMap = {
                1: "Berapa gaji bulanan yang Anda inginkan?",
                2: "Berapa tahun pengalaman Anda sebagai Staff Administrasi?",
                3: "Produk Microsoft apa saja yang bisa Anda gunakan?",
                4: "Bagaimana Anda menilai kemampuan bahasa Inggris Anda?",
                5: "Apakah Anda bersedia bepergian untuk pekerjaan ini saat dibutuhkan?",
                6: "Bahasa apa saja yang fasih Anda gunakan?",
                7: "Apakah Anda bersedia menjalani pemeriksaan latar belakang?",
            };

            fetch(`{{ route('workersunion.getLamaran') }}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.lamaran) {
                    candidateList.innerHTML = "";
                    data.lamaran.forEach(item => {
                        if(item.status=="pending"){
                        const candidateCard = document.createElement("div");
                        candidateCard.classList.add("candidate-card");

                        candidateCard.innerHTML = `
                            <h3>${item.username}</h3>
                            <p>${item.judulPekerjaan}</p>
                            <p style="display: flex; justify-content: space-between;">
                                Jawaban
                                <a href="#" class="view-qa" data-pertanyaan="${item.pertanyaan}" data-jawaban="${item.jawaban}" style="margin-left: auto;">Lihat di sini</a>
                            </p>
                            <p style="display: flex; justify-content: space-between;">
                                Profil
                                <a href="#" class="view-profile" data-id="${item.idPekerja}" style="margin-left: auto;">Lihat di sini</a>
                            </p>
                            <div class="candidate-actions">
                                <button class="accept-btn" data-id="${item.idLamaran}">Terima</button>
                                <button class="reject-btn" data-id="${item.idLamaran}">Tolak</button>
                            </div>
                        `;

                        candidateList.appendChild(candidateCard);
                        }
                    });

                    // Add click event to "Lihat di sini" links for QA
                    document.querySelectorAll(".view-qa").forEach(link => {
                        link.addEventListener("click", (event) => {
                            event.preventDefault();

                            const pertanyaan = event.target.getAttribute("data-pertanyaan").split(",");
                            const jawaban = event.target.getAttribute("data-jawaban").split("~");

                            // Clear previous dialog content
                            dialogQA.innerHTML = "";

                            // Display each question and its corresponding answer
                            pertanyaan.forEach((q, index) => {
                                const questionElement = document.createElement("p");
                                questionElement.innerHTML = `<strong>Pertanyaan:</strong> ${questionMap[q]}`;

                                const answerElement = document.createElement("p");
                                answerElement.innerHTML = `<strong>Jawaban:</strong> ${jawaban[index] || "-"}`;

                                dialogQA.appendChild(questionElement);
                                dialogQA.appendChild(answerElement);
                            });

                            // Show dialog
                            dialog.style.display = "flex";
                        });
                    });

                    // Add click event to "Lihat di sini" links for Profile
                    document.querySelectorAll(".view-profile").forEach(link => {
                        link.addEventListener("click", (event) => {
                            event.preventDefault();

                            const idPekerja = event.target.getAttribute("data-id");
                            showProfileDialog(idPekerja);
                        });
                    });

                    // Attach event listeners for accept and reject buttons
                    document.querySelectorAll(".accept-btn").forEach(button => {
                        button.addEventListener("click", () => {
                            const idLamaran = button.getAttribute("data-id");
                            handleLamaranAction(idLamaran, "diterima");
                        });
                    });

                    document.querySelectorAll(".reject-btn").forEach(button => {
                        button.addEventListener("click", () => {
                            const idLamaran = button.getAttribute("data-id");
                            handleLamaranAction(idLamaran, "ditolak");
                        });
                    });
                } else {
                    candidateList.innerHTML = "<p>Tidak ada kandidat untuk ditampilkan.</p>";
                }
            })
            .catch(error => {
                console.error("Error fetching lamaran data:", error);
            });

            // Close QA dialog
            closeDialog.addEventListener("click", () => {
                dialog.style.display = "none";
            });

            // Close Profile dialog
            closeProfileDialog.addEventListener("click", () => {
                profileDialog.style.display = "none";
            });

            function showProfileDialog(idPekerja) {
                
                fetch(`{{ route('workersunion.getDataPekerja') }}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                    body: JSON.stringify({ idPekerja })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.data &&) {
                        const pekerja = data.data;
                        profileContent.innerHTML = `
                            <div class="section">
                                <h4>Riwayat Pekerjaan</h4>
                                <p> Posisi: ${pekerja.posisiPekerjaan || "Tidak ada data"}</p>
                                <p> Nama Perusahaan: ${pekerja.namaPerusahaan || "Tidak ada data"}</p>
                                <p> Waktu Kerja: ${parseInt(pekerja.tahunBerakhirPekerjaan.substring(0, 4)) - parseInt(pekerja.tahunMulaiPekerjaan.substring(0, 4))} Tahun</p>
                            </div>
                            <div class="section">
                                <h4>Pendidikan</h4>
                                <p>Kursus Pendidikan: ${pekerja.kursusPendidikan || "Tidak ada data"}</p>
                                <p>Lembaga Pendidikan: ${pekerja.lembagaPendidikan || "Tidak ada data"}</p>
                                <p>Tahun Lulus: ${pekerja.statusKualifikasiPendidikan=="qualified" ? pekerja.tahunSelesaiPendidikan.substring(0, 4) : "Diharapkan selesai pada "+pekerja.tahunSelesaiPendidikan.substring(0, 4)}</p>
                            </div>
                            <div class="section">
                                <h4>Lisensi & Sertifikasi</h4>
                                <p>Nama Lisensi: ${pekerja.namaLisensi || "Tidak ada data"}</p>
                                <p>Organisasi Penerbit Lisensi: ${pekerja.organisasiPenerbitLisensi || "Tidak ada data"}</p>
                                <p>Status Lisensi: ${pekerja.statusLisensi=="kadaluwarsa" ? "Kadaluwarsa" : "Kadaluwarsa "+pekerja.tanggalKadaluwarsaLisensi.substring(0, 4) }</p>
                                <p>Deskripsi Lisensi: ${pekerja.deskripsiLisensi || "Tidak ada data"}</p>
                            </div>
                            <div class="container">
                                <h4 class="section-title">Skill</h2>
                                <p id="skills"></p>
                            </div>
                            <div class="container">
                                <h4 class="section-title">Resume</h4>
                                <a id="namaResume" target="_blank" download>${pekerja.namaResume}</a>
                            </div>
                        `;
                        profileDialog.style.display = "flex"; // Show the dialog
                        const skillsContainer = document.getElementById("skills");

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
                            fetch(`{{ route("workersunion.getResume") }}`, {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
    },
    body: JSON.stringify({ idPekerja }),
})
    .then(response => {
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        return response.json();
    })
    .then(resume => {
        const resumeLink = document.getElementById("namaResume");
        if (resume.success && resume.resume && resumeLink) {
            resumeLink.href = resume.resume['resume']; // Set the file URL
            resumeLink.download = resume.namaResume || "resume.pdf"; // Set filename
            console.log("Resume link set for download:", resume.resume);
        } else {
            console.error("Failed to set resume link or URL is missing.", resume);
        }
    })
    .catch(error => {
        console.error("Error fetching resume:", error);
    });

                    } else {
                        alert("Gagal memuat data profil.");
                    }
                })
                .catch(error => {
                    console.error("Error fetching profile data:", error);
                });
            }
        });

        function handleLamaranAction(idLamaran, status) {
            fetch(`{{ route('workersunion.handleLamaran') }}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
                body: JSON.stringify({ idLamaran, status })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert("Tindakan berhasil dilakukan.");
                    location.reload();
                } else {
                    alert("Gagal melakukan tindakan.");
                }
            })
            .catch(error => {
                console.error("Error handling lamaran:", error);
            });
        }
    </script>
</body>
</html>
