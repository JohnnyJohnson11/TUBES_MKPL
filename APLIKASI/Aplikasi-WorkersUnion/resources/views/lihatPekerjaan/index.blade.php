<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Workers Union - Login</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/lihatPekerjaan.css') }}">
</head>
<body>
  <nav class="navbar">
    <h1><span class="highlight">Workers</span> Union</h1>
    <ul class="nav-list">
      <li><a href="#">Home</a></li>
      <li><a href="#">Pekerjaan</a></li>
      <li><a href="#">Perusahaan</a></li>
      <li><a href="#">Tentang</a></li> 
      <li><a href="#">John</a></li> 
      <li><a href="#" class="post-job-btn">+ Posting Pekerjaan</a></li>
    </ul>
  </nav>
  
  <!-- Top bar for search and filters -->
  <div class="top-bar">
    <input type="text" placeholder="Jabatan, kata kunci, perusahaan">
    <input type="text" placeholder="Daerah, kota atau kabupaten">
    <button>Cari</button>
  </div>

  <!-- Job list and details -->
  <div style="display:flex">
    <div class="job-list"></div>
    <div class="job-details" id="jobDetailsContainer">
      <h2 style="padding-left: 20px; padding-top: 20px;">Ada {{ $pekerjaandisplay[0]['totalCount'] }} lowongan untuk kamu.</h2>
      <p style="padding-left: 20px;">Pilih lowongan untuk melihat lebih detil</p>
    </div>
  </div>
  
  <!-- Bottom bar for pagination -->
  <div style="padding: 10px;" class="bottom-bar">
    <button>Sebelumnya</button>
    <select style="padding: 8px; border: 1px solid black; border-radius: 5px; font-size: 14px;"></select>
    <button>Lanjut</button>
  </div>

  <script>
    let currentPage = 1; 
    const itemsPerPage = 5;
    const totalJobs = {{ $pekerjaandisplay[0]['totalCount'] }}; 
    const totalPages = Math.ceil(totalJobs / itemsPerPage); 

    const jobData = {!! json_encode($pekerjaandisplay) !!};

    const pageSelect = document.querySelector(".bottom-bar select");
    for (let i = 1; i <= totalPages; i++) {
      const option = document.createElement("option");
      option.value = i;
      option.textContent = i;
      pageSelect.appendChild(option);
    }

    function loadJobs() {
      const jobListContainer = document.querySelector(".job-list");
      jobListContainer.innerHTML = ""; 

      const startIndex = (currentPage - 1) * itemsPerPage;
      const endIndex = startIndex + itemsPerPage;

      const jobsToDisplay = jobData.slice(startIndex, endIndex);

      jobsToDisplay.forEach((pekerjaan) => {
        const jobItem = document.createElement("div");
        jobItem.className = "job-list-item";
        jobItem.onclick = () => showJobDetails(pekerjaan.idPekerjaan);

        const jobLogo = document.createElement("img");
        jobLogo.src = pekerjaan.logoPerusahaan;
        jobLogo.id = pekerjaan.idPekerjaan;
        jobLogo.style.cssText = "margin:auto; max-height: 50px;";
        jobItem.appendChild(jobLogo);

        const jobTitle = document.createElement("h4");
        jobTitle.textContent = pekerjaan.kategoriJabatan;
        jobItem.appendChild(jobTitle);

        const jobLocation = document.createElement("p");
        jobLocation.textContent = pekerjaan.lokasiPekerjaan;
        jobItem.appendChild(jobLocation);

        const jobSalary = document.createElement("p");
        jobSalary.innerHTML = `<strong>${pekerjaan.kisaranGaji} ${pekerjaan.jenisGaji}</strong>`;
        jobItem.appendChild(jobSalary);

        jobListContainer.appendChild(jobItem);
      });
    }

    document.querySelector(".bottom-bar button:first-child").addEventListener("click", () => {
      if (currentPage > 1) {
        currentPage--;
        pageSelect.value = currentPage;
        loadJobs();
      }
    });

    document.querySelector(".bottom-bar button:last-child").addEventListener("click", () => {
      if (currentPage < totalPages) {
        currentPage++;
        pageSelect.value = currentPage;
        loadJobs();
      }
    });

    pageSelect.addEventListener("change", (event) => {
      currentPage = parseInt(event.target.value, 10);
      loadJobs();
    });

    // Function to display job details
    function showJobDetails(idPekerjaan) {
      fetch(`{{ route("workersunion.getPekerjaanById") }}`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
        body: JSON.stringify({ idPekerjaan }),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Network response was not ok");
          }
          return response.json();
        })
        .then((data) => {
          if (data.success && data.pekerjaans) {
            const pekerjaan = data.pekerjaans[0];
            const jobDetailsContainer = document.getElementById("jobDetailsContainer");

            jobDetailsContainer.innerHTML = "";

            const banner = document.createElement("img");
            banner.src = pekerjaan.bannerPerusahaan;
            banner.style.cssText = "width: 100%; height: 20%; margin-bottom: 20px;";
            jobDetailsContainer.appendChild(banner);

            const logoPerusahaan = document.createElement("img");
            const logo = document.getElementById(idPekerjaan.toString());
            if (logo) {
              logoPerusahaan.src = logo.src;
            }
            logoPerusahaan.style.cssText = "max-width: 50px; height: auto; margin-left: 20px; display: block; margin-bottom: 20px;";
            jobDetailsContainer.appendChild(logoPerusahaan);

            const timePosted = document.createElement("p");
            timePosted.textContent = "Pekerjaan dibuat " + pekerjaan.created_at.substr(0,10);
            timePosted.style.cssText = "display: block; margin-bottom: 10px; font-size: 18px; padding-left:20px";
            jobDetailsContainer.appendChild(timePosted);

            const descriptionTitle = document.createElement("strong");
            descriptionTitle.textContent = "Description";
            descriptionTitle.style.cssText = "display: block; margin-bottom: 3px; font-size: 18px; padding-left:20px";
            jobDetailsContainer.appendChild(descriptionTitle);

            const description = document.createElement("p");
            description.textContent = pekerjaan.deskripsiPerusahaan;
            description.style.cssText = "margin-bottom: 20px; font-size: 16px; line-height: 1.5; padding: 20px; padding-top:5px;";
            jobDetailsContainer.appendChild(description);

            // Add "Lamar Sekarang" button
            const applyButton = document.createElement("button");
            applyButton.textContent = "Lamar Sekarang";
            applyButton.style.cssText = "background-color: #75402b; color: white; padding: 10px 20px; border: none; cursor: pointer; font-size: 16px; border-radius: 5px; margin-left: 20px;";
            applyButton.onclick = function () {
                applyForJob(idPekerjaan);
            };
            jobDetailsContainer.appendChild(applyButton);
          } else {
            console.error("No pekerjaan found or invalid response format.");
          }
        })
        .catch((error) => {
          console.error("Error loading pekerjaan:", error);
        });
    }

    loadJobs();

    function applyForJob(idPekerjaan) {
    fetch(`{{ route('workersunion.storeJobSession') }}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
        body: JSON.stringify({ idPekerjaan }),
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error("Failed to store job ID in session.");
        }
        return response.json();
    })
    .then((data) => {
        if (data.success) {
            // Redirect to another page
            window.location.href = "{{ route('workersunion.halamanResume') }}";
        } else {
            console.error("Failed to store job ID:", data.message);
        }
    })
    .catch((error) => {
        console.error("Error storing job ID:", error);
    });
}
  </script>
</body>
</html>
