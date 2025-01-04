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

    <!-- Left side job list -->

    <div style="display:flex">
        <div class="job-list">
            @foreach ($pekerjaandisplay as $pekerjaan)
                <div  class="job-list-item" onclick="showJobDetails('{{ $pekerjaan['idPekerjaan'] }}')">
                    <img id="{{ $pekerjaan['idPekerjaan'] }}" src="{{ $pekerjaan['logoPerusahaan'] }}" style="margin:auto; max-height: 50px;">
                    <h4>{{ $pekerjaan['kategoriJabatan'] }}</h4>
                    <p>{{ $pekerjaan['lokasiPekerjaan'] }}</p>
                    <p><strong>{{ $pekerjaan['kisaranGaji'] }} {{ $pekerjaan['jenisGaji'] }}</strong></p>
                </div>
            @endforeach
        </div>
        <div class="job-details" id="jobDetailsContainer">
            <h2 style="padding-left: 20px; padding-top: 20px;">Ada {{ $pekerjaandisplay[0]['totalCount'] }} lowongan untuk kamu.</h2>
            <p style="padding-left: 20px;">Pilih lowongan untuk melihat lebih detil</p>
        </div>
    </div>
    <div style="padding: 10px;" class="bottom-bar">
        <button>Sebelumnya</button>
        <select style="padding: 8px; border: 1px solid black; border-radius: 5px; font-size: 14px;">
            <option>1</option>
        </select>
        <button>Lanjut</button>
    </div>
</body>
<script>
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

    // Clear previous details
    jobDetailsContainer.innerHTML = "";

    // Add banner
    const banner = document.createElement("img");
    banner.src = pekerjaan.bannerPerusahaan;
    banner.style.cssText = "width: 100%; height: 20%; margin-bottom: 20px;";
    jobDetailsContainer.appendChild(banner);

    // Add logo
    const logoPerusahaan = document.createElement("img");
    const logo = document.getElementById(idPekerjaan.toString()); // Get the image element
    if (logo) {
        const logoSrc = logo.src; // Get the src attribute of the image
        console.log("Logo Source:", logoSrc); // Debugging: Ensure the src value is correct
        logoPerusahaan.src = logoSrc; 
    } else {
        console.error(`Element with id ${idPekerjaan} not found.`);
    }

    logoPerusahaan.style.cssText = "max-width: 50px; height: auto; margin-left: 20px; display: block; margin-bottom: 20px;";
    jobDetailsContainer.appendChild(logoPerusahaan);

    // Add description title
    const descriptionTitle = document.createElement("strong");
    descriptionTitle.textContent = "Description";
    descriptionTitle.style.cssText = "display: block; margin-bottom: 10px; font-size: 18px; padding-left:20px";
    jobDetailsContainer.appendChild(descriptionTitle);

    // Add description
    const description = document.createElement("p");
    description.textContent = pekerjaan.deskripsiPerusahaan;
    description.style.cssText = "margin-bottom: 20px; font-size: 16px; line-height: 1.5; padding: 20px";
    jobDetailsContainer.appendChild(description);

    // Add "Lamar Sekarang" button
    const applyButton = document.createElement("button");
    applyButton.textContent = "Lamar Sekarang";
    applyButton.style.cssText = "background-color: #75402b; color: white; padding: 10px 20px; border: none; cursor: pointer; font-size: 16px; border-radius: 5px; margin-left: 20px;";
    jobDetailsContainer.appendChild(applyButton);

} else {
    console.error("No pekerjaan found or invalid response format.");
}

        })
        .catch((error) => {
            console.error("Error loading pekerjaan:", error);
        });
}

</script>
</html>

