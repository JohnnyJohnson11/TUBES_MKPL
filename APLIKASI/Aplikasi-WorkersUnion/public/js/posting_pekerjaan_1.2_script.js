document.addEventListener("DOMContentLoaded", () => {
  // === DOM Elements ===
  const adOptions = document.querySelectorAll(".ad-option");
  const nextButton = document.querySelector(".btn-next");

  let selectedOption = null;

  // === Fungsi untuk mengatur opsi yang dipilih ===
  function selectAd(option) {
    // Hapus kelas 'selected' dari semua opsi
    adOptions.forEach((ad) => {
      ad.classList.remove("selected");
    });

    // Tambahkan kelas 'selected' pada opsi yang dipilih
    const selectedAd = document.querySelector(`.${option}`);
    selectedAd.classList.add("selected");

    // Perbarui opsi yang dipilih
    selectedOption = option;
  }

  // === Tambahkan event listener pada setiap opsi ===
  adOptions.forEach((ad) => {
    ad.addEventListener("click", () => {
      const optionClass = ad.classList.contains("basic")
        ? "basic"
        : ad.classList.contains("premium")
        ? "premium"
        : "premium-plus";
      selectAd(optionClass);
    });
  });

  // === Tombol Berikutnya ===
  nextButton.addEventListener("click", () => {
    if (!selectedOption) {
      alert("Silakan pilih jenis iklan terlebih dahulu.");
      return;
    }

    // Arahkan ke langkah berikutnya
    console.log(`Opsi terpilih: ${selectedOption}`);
    // Tambahkan logika untuk melanjutkan ke langkah berikutnya
  });
});
