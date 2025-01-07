<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Job Listings</title>
    <link rel="stylesheet" href="{{ asset('css/pekerjaanPerusahaan.css') }}">
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
            <a href="{{ route('workersunion.pekerjaanPerusahaan') }}" class="active">Buka</a>
            <a href="{{ route('workersunion.pekerjaanPerusahaanKandidat') }}" id="kandidat-link">Kandidat</a>
        </div>
        <div class="content">
            <h1>1 Iklan lowongan kerja</h1>
            <div class="search-bar">
                <input type="text" placeholder="Cari jabatan pekerjaan atau nomor referensi">
                <button class="search-btn">Buat iklan lowongan pekerjaan</button>
            </div>
            <table class="job-table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Pekerjaan</th>
                        <th>Kandidat</th>
                        <th>Tindakan pekerjaan</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
    const idPerusahaan = {{ json_encode(session('idPerusahaan')) }};
    const pekerjaanTableBody = document.querySelector(".job-table tbody");

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
                pekerjaanTableBody.innerHTML = ""; // Clear any existing rows
                data.pekerjaans.forEach((pekerjaan) => {
                    const row = document.createElement("tr");

                    // Create the status cell
                    const statusCell = document.createElement("td");
                    statusCell.innerHTML = `<span class="status active">Aktif</span>`;

                    // Create the job title cell
                    const judulCell = document.createElement("td");
                    judulCell.innerHTML = `<strong>${pekerjaan.judulPekerjaan}</strong><br>${pekerjaan.lokasiPekerjaan || "-"}`;

                    // Fetch the lamaran data for the current pekerjaan
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
                            kandidatCell.textContent = lamaranData.pekerjaan.totalResumes || "-"; // Total resumes

                            const tindakanCell = document.createElement("td");
                            const pendingResumes = parseInt(lamaranData.pekerjaan.pendingResumes, 10) || 0;
                            const totalResumes = parseInt(lamaranData.pekerjaan.totalResumes, 10) || 0;
                            tindakanCell.textContent = totalResumes - pendingResumes || "-"; // Resumes not pending

                            // Append all cells to the row
                            row.appendChild(statusCell);
                            row.appendChild(judulCell);
                            row.appendChild(kandidatCell);
                            row.appendChild(tindakanCell);
                        })
                        .catch((error) => {
                            console.error("Error fetching lamaran data:", error);
                        });

                    // Append the row to the table body
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
</body>
</html>
