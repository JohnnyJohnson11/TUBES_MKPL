<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Akun Perusahaan</title>
    <link rel="stylesheet" href="{{ asset('css/akun_perusahaan_styles.css') }}" >
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&amp;display=swap" rel="stylesheet"/>
  </head>

  <body>
    <!-- Navbar -->
    <div class="navbar">
      <h1><span class="highlight">Seek</span> Employer</h1>
      <ul class="nav-list">
        <li><a href="{{ route('workersunion.homepagePerusahaanIndex') }}">Home</a></li>
        <li><a href="{{ route('workersunion.pekerjaanPerusahaan') }}">Pekerjaan</a></li>
        <li><a href="{{ route('workersunion.akunPerusahaanIndex') }}">{{ $perusahaans['namaBisnis'] }}</a></li>
        <li>
          <button class="post-job-btn" onclick="window.location.href='{{ route('workersunion.postingPekerjaanPage1') }}'">+ Posting Pekerjaan</button>
        </li>
      </ul>
    </div>

    <main>
      <!-- Header -->
      <div class="main-header">
        <h1>Detail Akun</h1>
        <div class="new-account-btn-container">
          <button class="new-account-btn" style="background-color:red;" onclick="window.location.href='{{ route('workersunion.halamanUtama') }}'">Log Out</button>
        </div>
      </div>

      <!-- Detail Personal -->
      <div class="card">
        <div class="card-header">
          <!-- Ikon user -->
          @if(!empty($perusahaans['logoPerusahaan']))
              <img alt="User Icon" class="icon" src="{{ $perusahaans['logoPerusahaan'] }}" id="addLogoButton"/>
          @else
              <img alt="User Icon" class="icon" src="https://static-00.iconduck.com/assets.00/profile-default-icon-2048x2045-u3j7s5nj.png" id="addLogoButton"/>
          @endif

          <h2 class="card-title">Detail Personal</h2>
        </div>
        <div class="card-content">
          <p><strong>{{ $perusahaans['username'] }}</strong></p>
          <p>{{ $perusahaans['email'] }}</p>
        </div>
      </div>

      <!-- Detail Perusahaan -->
      <div class="card">
        <div class="card-header">
          <img
            alt="Office Icon"
            class="icon"
            src="images/office_building.png"
          />
          <h2 class="card-title">Detail Perusahaan</h2>
        </div>
        <div class="card-content">
          <p><strong>Nama Perusahaan</strong></p>
          <p>{{ $perusahaans['namaBisnis'] }}</p>
          <hr />
          <div class="contact-section">
            <p><strong>Kontak Utama</strong></p>
            <p>{{ $perusahaans['kontakUtama'] }}</p>
            <p><strong>Telepon:</strong> {{ $perusahaans['nomorHP'] }}</p>
            <a class="edit-link edit-perusahaan-kontak" href="#">Edit</a>
          </div>
          <hr />
          <div class="address-section">
            <p><strong>Alamat Perusahaan</strong></p>
            <p>{{ $perusahaans['alamatPerusahaan'] }}</p>
            <a class="edit-link edit-perusahaan-alamat" href="#">Edit</a>
          </div>
        </div>
      </div>

      <!-- Detail Penagihan -->
      <div class="card">
        <div class="card-header">
          <img alt="Billing Icon" class="icon" src="images/bills_icon.png" />
          <h2 class="card-title">Detail Penagihan</h2>
        </div>
        <div class="card-content">
          <div class="billing-section">
            <p><strong>Alamat Penagihan</strong></p>
            <p>{{ $perusahaans['alamatPerusahaan'] }}</p>
          </div>
          <hr />
          <div class="billing-section">
            <p><strong>Email Penagihan</strong></p>
            <p>
              <a class="contact-link" href="#"
                ><strong>{{ $perusahaans['emailPenagihan'] }}</strong></a
              >
            </p>
            <a class="edit-link edit-penagihan-email" href="#">Edit</a>
          </div>
          <p>
            Semua faktur SEEK untuk perusahaan Anda akan dikirim ke email
            penagihan Anda.
          </p>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
      <a href="#">Tentang SEEK</a>
      <a href="#">Mitra International</a>
      <a href="#">Layanan Mitra</a>
      <a href="#">Keamanan</a>
      <a href="#">Syarat dan Ketentuan</a>
      <a href="#">Kunjungi Pusat Bantuan Kami</a>
    </footer>
  </body>
  <script>
  const perusahaanData = {
    nomorHP: "{{ $perusahaans['nomorHP'] ?? '' }}",
    kontakUtama: "{{ $perusahaans['kontakUtama'] ?? '' }}",
    alamatPerusahaan: "{{ $perusahaans['alamatPerusahaan'] ?? '' }}",
    emailPenagihan: "{{ $perusahaans['emailPenagihan'] ?? '' }}",
    logoPerusahaan: "{{ $perusahaans['logoPerusahaan'] ?? '' }}"
  };

  // Edit Address
  document.querySelector(".edit-perusahaan-alamat").addEventListener("click", function (event) {
    event.preventDefault();
    const addressParagraph = document.querySelector(".address-section p:nth-child(2)");
    const currentAddress = addressParagraph.textContent;
    const addressInput = document.createElement("input");
    addressInput.type = "text";
    addressInput.value = currentAddress;
    addressInput.className = "profile-input";
    addressParagraph.parentNode.replaceChild(addressInput, addressParagraph);

    const saveButton = document.createElement("button");
    saveButton.textContent = "Save";
    saveButton.className = "save-input";
    addressInput.parentNode.appendChild(saveButton);

    saveButton.addEventListener("click", function () {
      const newAddress = addressInput.value.trim();
      perusahaanData.alamatPerusahaan = newAddress;

      updatePerusahaanData(perusahaanData);

      const updatedParagraph = document.createElement("p");
      updatedParagraph.textContent = newAddress;
      addressInput.parentNode.replaceChild(updatedParagraph, addressInput);
      saveButton.remove();
    });
  });

  // Edit Contact Information
  document.querySelector(".edit-perusahaan-kontak").addEventListener("click", function (event) {
    event.preventDefault();

    const contactNameParagraph = document.querySelector(".contact-section p:nth-child(2)");
    const currentContactName = contactNameParagraph.textContent;
    const contactNameInput = document.createElement("input");
    contactNameInput.type = "text";
    contactNameInput.value = currentContactName;
    contactNameInput.className = "profile-input";
    contactNameParagraph.parentNode.replaceChild(contactNameInput, contactNameParagraph);

    const contactPhoneParagraph = document.querySelector(".contact-section p:nth-child(3)");
    const currentContactPhone = contactPhoneParagraph.textContent.replace("Telepon: ", "");
    const contactPhoneInput = document.createElement("input");
    contactPhoneInput.type = "text";
    contactPhoneInput.value = currentContactPhone;
    contactPhoneInput.className = "profile-input";
    contactPhoneParagraph.parentNode.replaceChild(contactPhoneInput, contactPhoneParagraph);

    const saveButton = document.createElement("button");
    saveButton.textContent = "Save";
    saveButton.className = "save-input";
    contactPhoneInput.parentNode.appendChild(saveButton);

    saveButton.addEventListener("click", function () {
      const newContactName = contactNameInput.value.trim();
      const newContactPhone = contactPhoneInput.value.trim();
      perusahaanData.kontakUtama = newContactName;
      perusahaanData.nomorHP = newContactPhone;

      updatePerusahaanData(perusahaanData);

      const updatedNameParagraph = document.createElement("p");
      updatedNameParagraph.textContent = newContactName;
      contactNameInput.parentNode.replaceChild(updatedNameParagraph, contactNameInput);

      const updatedPhoneParagraph = document.createElement("p");
      updatedPhoneParagraph.innerHTML = `<strong>Telepon:</strong> ${newContactPhone}`;
      contactPhoneInput.parentNode.replaceChild(updatedPhoneParagraph, contactPhoneInput);

      saveButton.remove();
    });
  });

  // Edit Billing Email
  document.querySelector(".edit-penagihan-email").addEventListener("click", function (event) {
    event.preventDefault();
    const emailParagraph = document.querySelector(".contact-link strong");
    const currentEmail = emailParagraph.textContent;
    const emailInput = document.createElement("input");
    emailInput.type = "email";
    emailInput.value = currentEmail;
    emailInput.className = "profile-input";
    emailParagraph.parentNode.replaceChild(emailInput, emailParagraph);

    const saveButton = document.createElement("button");
    saveButton.textContent = "Save";
    saveButton.className = "save-input";
    emailInput.parentNode.appendChild(saveButton);

    saveButton.addEventListener("click", function () {
      const newEmail = emailInput.value.trim();
      perusahaanData.emailPenagihan = newEmail;

      updatePerusahaanData(perusahaanData);

      const updatedEmailParagraph = document.createElement("strong");
      updatedEmailParagraph.textContent = newEmail;

      const updatedEmailLink = document.createElement("a");
      updatedEmailLink.className = "contact-link";
      updatedEmailLink.href = `mailto:${newEmail}`;
      updatedEmailLink.appendChild(updatedEmailParagraph);

      emailInput.parentNode.replaceChild(updatedEmailLink, emailInput);
      saveButton.remove();
    });
  });

  // Edit Logo
  const addLogoButton = document.getElementById("addLogoButton");
  const logoUploader = document.createElement("input");
  logoUploader.type = "file";
  logoUploader.accept = "image/*";
  logoUploader.style.display = "none";
  document.body.appendChild(logoUploader);

  addLogoButton.addEventListener("click", () => {
    logoUploader.click();
  });

  logoUploader.addEventListener("change", (event) => {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        const newLogoSrc = e.target.result;
        addLogoButton.src = newLogoSrc;
        perusahaanData.logoPerusahaan = newLogoSrc;

        updatePerusahaanData(perusahaanData);
      };
      reader.readAsDataURL(file);
    }
  });

  // Update Perusahaan Data
  function updatePerusahaanData(data) {
    fetch('{{ route("workersunion.updatePerusahaan") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      },
      body: JSON.stringify(data),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
      })
      .then((result) => {
        if (result.success) {
          
        } else {
          alert(`Error: ${result.message}`);
        }
      })
      .catch((error) => {
        console.error("Error updating data:", error);
      });
  }
</script>

</html>
