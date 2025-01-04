// Ambil elemen-elemen yang dibutuhkan
const addLogoButton = document.getElementById("addLogoButton");
const logoUploader = document.getElementById("logoUploader");
const logoPreview = document.getElementById("logoPreview");

// Ketika tombol "Tambah Logo" diklik, buka dialog upload file
addLogoButton.addEventListener("click", () => {
  logoUploader.click();
});

// Ketika pengguna memilih file
logoUploader.addEventListener("change", (event) => {
  const file = event.target.files[0]; // Ambil file yang diunggah
  if (file) {
    const reader = new FileReader();

    // Ketika file selesai dibaca
    reader.onload = (e) => {
      logoPreview.src = e.target.result; // Ubah sumber gambar ke hasil pembacaan file
    };

    reader.readAsDataURL(file); // Baca file sebagai URL Data
  }
});
