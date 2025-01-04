document.addEventListener("DOMContentLoaded", () => {
  // === DOM Elements ===
  const customCategoryRadio = document.querySelector("#custom-category"); // Radio "Pilih Kategori Berbeda"
  const customInputContainer = document.querySelector(
    ".custom-input-container"
  ); // Wrapper input custom
  const customCategoryInput = document.querySelector("#custom-category-input"); // Input custom
  const categoryRadios = document.querySelectorAll('input[name="category"]'); // Semua radio button kategori
  const currencyDropdown = document.getElementById("currency"); // Dropdown mata uang
  const salaryMinInput = document.getElementById("salary-min"); // Input gaji minimum
  const salaryMaxInput = document.getElementById("salary-max"); // Input gaji maksimum

  // === Fungsi untuk menampilkan input jika "Pilih Kategori Berbeda" dipilih ===
  function showCustomInput() {
    if (customCategoryRadio.checked) {
      customInputContainer.style.display = "block"; // Tampilkan container input custom
    }
  }

  // === Fungsi untuk menyembunyikan input jika kategori lain dipilih ===
  function hideCustomInput() {
    if (!customCategoryInput.value.trim()) {
      customInputContainer.style.display = "none"; // Sembunyikan container jika kosong
    }
  }

  // === Event Listener untuk semua kategori radio button ===
  categoryRadios.forEach((radio) => {
    radio.addEventListener("change", () => {
      if (radio.id === "custom-category") {
        showCustomInput(); // Tampilkan input custom
      } else {
        hideCustomInput(); // Sembunyikan jika kategori lain dipilih
      }
    });
  });

  // === Event Listener tambahan agar input tetap ditampilkan jika ada isi ===
  customCategoryInput.addEventListener("input", () => {
    if (customCategoryInput.value.trim()) {
      customInputContainer.style.display = "block"; // Tetap tampil jika ada isi
    }
  });

  // === Fungsi untuk memperbarui placeholder berdasarkan mata uang ===
  function updateSalaryPlaceholders() {
    if (currencyDropdown.value === "IDR") {
      salaryMinInput.placeholder = "4.900.000";
      salaryMaxInput.placeholder = "6.900.000";
    } else if (currencyDropdown.value === "USD") {
      salaryMinInput.placeholder = "300";
      salaryMaxInput.placeholder = "450";
    }
  }

  // === Event Listener untuk mendeteksi perubahan mata uang ===
  currencyDropdown.addEventListener("change", updateSalaryPlaceholders);

  // === Memastikan placeholder sesuai saat halaman dimuat ===
  updateSalaryPlaceholders();
});
