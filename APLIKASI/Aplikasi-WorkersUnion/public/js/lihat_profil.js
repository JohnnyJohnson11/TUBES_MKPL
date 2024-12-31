function populateYearOptions(selectId, startYear, endYear) {
  const selectElement = document.getElementById(selectId);
  for (let year = startYear; year <= endYear; year++) {
    const option = document.createElement('option');
    option.value = year;
    option.textContent = year;
    selectElement.appendChild(option);
  }
}
const currentYear = new Date().getFullYear();
populateYearOptions('tahuntanggalterbit', 1900, currentYear); 
populateYearOptions('tahuntanggalkadaluwarsa', 1900, currentYear + 10);

document.getElementById("tambahringkasan").addEventListener("click", function() {
  document.getElementById("popup").classList.add("active");
});

document.getElementById("closePopup").addEventListener("click", function() {
  document.getElementById("popup").classList.remove("active");
});

document.getElementById("tambahpendidikan").addEventListener("click", function() {
  document.getElementById("popuppendidikan").classList.add("active");
});

document.getElementById("closePopuppendidikan").addEventListener("click", function() {
  document.getElementById("popuppendidikan").classList.remove("active");
});

document.getElementById("batalpendidikan").addEventListener("click", function() {
  document.getElementById("popuppendidikan").classList.remove("active");
});

document.getElementById("simpanbutton").addEventListener("click", function() {
  var summaryText = document.getElementById("summary").value;

  if (summaryText.trim() === "") {
      alert("Ringkasan tidak boleh kosong.");
      return;
  }

  var summarySection = document.getElementById("ringkasan").parentElement;
  var newSummary = document.createElement("p");
  var content = document.getElementById("ringkasan")
  newSummary.textContent = summaryText;

  var existingSummary = summarySection.querySelector("p.summary-text");
  if (existingSummary) {
      existingSummary.textContent = summaryText;
  } else {
    content.innerHTML = "";
      newSummary.classList.add("summary-text");
      summarySection.insertBefore(newSummary, summarySection.querySelector(".add-button"));
  }

  document.getElementById("popup").classList.remove("active");
  document.getElementById("summary").value = ""; 
  const ringkasan = { summarySection };
    fetch('{{ route("workersunion.addRingkasan") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(ringkasan),
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .catch((error) => {
        console.error('There was a problem with the fetch operation:', error);
    });
});

document.getElementById("simpanpendidikanbutton").addEventListener("click", function() {
  var summaryKursusText = document.getElementById("summarykursus").value;
  var summaryLembagaText = document.getElementById("summarylembaga").value;
  var summaryTahunText = document.getElementById("summarytahun").value;
  var summaryPoinText = document.getElementById("summarypoin").value;

  if (summaryKursusText.trim() === "" || summaryLembagaText.trim() === "") {
      alert("Data tidak boleh kosong.");
      return;
  }

  document.getElementById("kursus").innerHTML = `<strong>${summaryKursusText}</strong>`;
  document.getElementById("lembaga").innerHTML = summaryLembagaText;
  document.getElementById("tahun").innerHTML = summaryTahunText;
  document.getElementById("poin").innerHTML = summaryPoinText;

  
  var existingSummary = summarySection.querySelector("p.summary-text");
  if (existingSummary) {
      existingSummary.innerHTML = summaryText; 
  } else {
      var newSummary = document.createElement("p");
      newSummary.innerHTML = summaryText; 
      newSummary.classList.add("summary-text");
      content.innerHTML = ""; 
      summarySection.insertBefore(newSummary, summarySection.querySelector(".add-button"));
  }
  document.getElementById("popup").classList.remove("active");
  document.getElementById("summary").value = ""; 
});

document.getElementById("simpanriwayatbutton").addEventListener("click", function() {
 var summaryKursusText = document.getElementById("summarykursus").value;
 var summartLembagaText = document.getElementById("summarylembaga").value;
 var summaryKadaluwarsaText = "Kadaluwarsa "+document.getElementById("bulantanggalkadaluwarsa").value+" "+document.getElementById("tahuntanggalkadaluwarsa").value;
})

document.getElementById("bukaPopupRiwayat").addEventListener("click", function() {
  document.getElementById("popupRiwayat").classList.add("active");
});


document.getElementById("closePopupRiwayat").addEventListener("click", function() {
  document.getElementById("popupRiwayat").classList.remove("active");
});

document.getElementById("batalRiwayat").addEventListener("click", function() {
  document.getElementById("popupRiwayat").classList.remove("active");
});



document.getElementById("simpanlisensibutton").addEventListener("click", function() {
  var summaryLisensiText = document.getElementById("summarylisensi").value;
  var summaryPenerbitText = document.getElementById("summarypenerbit").value;
  var summaryKadaluwarsaText = "Kadaluwarsa "+document.getElementById("bulantanggalkadaluwarsa").value+" "+document.getElementById("tahuntanggalkadaluwarsa").value;
  var summaryDeskripsiText = document.getElementById("summarydescription").value;

  if (summaryLisensiText.trim() === "") {
      alert("Data tidak boleh kosong.");
      return;
  }

  document.getElementById("ifnulllisensi").innerHTML = "";
  document.getElementById("lisensi").innerHTML = `<strong>${summaryLisensiText}</strong>`;
  document.getElementById("penerbit").innerHTML = summaryPenerbitText;
  if (document.getElementById("no-expiry").checked){
    document.getElementById("kadaluwarsa").innerHTML=summaryKadaluwarsaText;
  } else {
    document.getElementById("kadaluwarsa").innerHTML="Sudah Kadaluwarsa";
  }
  document.getElementById("description").innerHTML = summaryDeskripsiText;

  var existingSummary = summarySection.querySelector("p.summary-text");
  if (existingSummary) {
      existingSummary.innerHTML = summaryText; 
  } else {
      var newSummary = document.createElement("p");
      newSummary.innerHTML = summaryText; 
      newSummary.classList.add("summary-text");
      content.innerHTML = ""; 
      summarySection.insertBefore(newSummary, summarySection.querySelector(".add-button"));
  }
  document.getElementById("popup").classList.remove("active");
  document.getElementById("summary").value = ""; 
});

document.getElementById("tambahlisensi").addEventListener("click", function() {
  document.getElementById("popuplisensi").classList.add("active");
});

document.getElementById("closePopuplisensi").addEventListener("click", function() {
  document.getElementById("popuplisensi").classList.remove("active");
});

document.getElementById("batallisensi").addEventListener("click", function() {
  document.getElementById("popuplisensi").classList.remove("active");
});

document.getElementById("tambahkeahlian").addEventListener("click", function() {
  document.getElementById("popupkeahlian").classList.add("active");
});

document.getElementById("closePopupkeahlian").addEventListener("click", function() {
  document.getElementById("popupkeahlian").classList.remove("active");
});

document.getElementById("batalkeahlian").addEventListener("click", function() {
  document.getElementById("popupkeahlian").classList.remove("active");
});

//bagian skill
document.getElementById("tambahkeahlianbutton").addEventListener("click", function () {
  const skillInput = document.getElementById("summarykeahlian");
  const skillsContainer = document.getElementById("skillsContainer");
  const noSkillsMessage = document.getElementById("noSkillsMessage");

  const skillValue = skillInput.value.trim();
  if (skillValue === "") {
    alert("Masukkan keahlian terlebih dahulu.");
    return;
  }
  if (noSkillsMessage) {
    noSkillsMessage.remove();
  }
  const skillBox = document.createElement("div");
  skillBox.className = "skill-box";
  skillBox.innerHTML = `
    <span style="display:flex;">${skillValue}</span>
    <button class="remove-skill-btn" title="Hapus keahlian">&times;</button>
  `;
  skillBox.querySelector(".remove-skill-btn").addEventListener("click", function () {
    skillsContainer.removeChild(skillBox);
    if (skillsContainer.children.length === 0) {
      const message = document.createElement("p");
      message.className = "note";
      message.id = "noSkillsMessage";
      message.textContent = "Tidak ada keahlian yang ditambahkan";
      skillsContainer.appendChild(message);
    }
  });
  skillsContainer.appendChild(skillBox);
  skillInput.value = "";
});
document.getElementById("simpankeahlianbutton").addEventListener("click", function () {
  const popupSkillsContainer = document.getElementById("skillsContainer");
  const mainSkillsContainer = document.getElementById("skills");
  const skillBoxes = popupSkillsContainer.querySelectorAll(".skill-box");
  mainSkillsContainer.innerHTML = "";

  skillBoxes.forEach(function (skillBox) {
    const newSkillBox = document.createElement("p");
    newSkillBox.className = "skill-box";
    newSkillBox.innerHTML = skillBox.innerHTML;
    newSkillBox.querySelector(".remove-skill-btn").addEventListener("click", function () {
      mainSkillsContainer.removeChild(newSkillBox);
      if (mainSkillsContainer.children.length === 0) {
        const message = document.createElement("p");
        message.className = "note";
        message.id = "noSkillsMessage";
        message.textContent = "Tidak ada keahlian yang ditambahkan";
        mainSkillsContainer.appendChild(message);
      }
    });

    mainSkillsContainer.appendChild(newSkillBox);
  });

  document.getElementById("popupkeahlian").classList.remove("active");

  const noSkillsMessage = document.getElementById("noSkillsMessage");
  if (mainSkillsContainer.children.length > 0) {
    if (noSkillsMessage) {
      noSkillsMessage.remove();
    }
  } else {
    if (!noSkillsMessage) {
      const message = document.createElement("p");
      message.className = "note";
      message.id = "noSkillsMessage";
      message.textContent = "Tidak ada keahlian yang ditambahkan";
      mainSkillsContainer.appendChild(message);
    }
  }
});

document.getElementById("tambahbahasa").addEventListener("click", function() {
  document.getElementById("popupbahasa").classList.add("active");
});

document.getElementById("closePopupbahasa").addEventListener("click", function() {
  document.getElementById("popupbahasa").classList.remove("active");
});

document.getElementById("batalbahasa").addEventListener("click", function() {
  document.getElementById("popupbahasa").classList.remove("active");
});

document.getElementById("simpanbahasabutton").addEventListener("click", function() {
  var summarybahasaText = document.getElementById("summarybahasa").value;

  if (summarybahasaText.trim() === "") {
      alert("Data tidak boleh kosong.");
      return;
  }

  document.getElementById("ifnullbahasa").innerHTML = "";
  document.getElementById("bahasa").innerHTML = summarybahasaText;
  
  var existingSummary = summarySection.querySelector("p.summary-text");
  if (existingSummary) {
      existingSummary.innerHTML = summaryText; 
  } else {
      var newSummary = document.createElement("p");
      newSummary.innerHTML = summaryText; 
      newSummary.classList.add("summary-text");
      content.innerHTML = ""; 
      summarySection.insertBefore(newSummary, summarySection.querySelector(".add-button"));
  }
  document.getElementById("popup").classList.remove("active");
  document.getElementById("summary").value = ""; 
});

document.getElementById("tambahresume").addEventListener("click", function() {
  document.getElementById("popupresume").classList.add("active");
});

document.getElementById("closePopupresume").addEventListener("click", function() {
  document.getElementById("popupresume").classList.remove("active");
});

document.getElementById("batalresume").addEventListener("click", function() {
  document.getElementById("popupresume").classList.remove("active");
});


const uploadArea = document.getElementById("upload-area");
const browseBtn = document.getElementById("browse-btn");
const fileInput = document.getElementById("file-input");
const fileList = document.getElementById("file-list");


let uploadedFiles = [];


browseBtn.addEventListener("click", () => {
    fileInput.click();
});


fileInput.addEventListener("change", (event) => {
    handleFiles(event.target.files);
});


uploadArea.addEventListener("dragover", (event) => {
    event.preventDefault(); 
    uploadArea.style.borderColor = "#007bff";
});

uploadArea.addEventListener("dragleave", () => {
    uploadArea.style.borderColor = "#ccc"; 
});

uploadArea.addEventListener("drop", (event) => {
    event.preventDefault();
    uploadArea.style.borderColor = "#ccc"; 
    const files = event.dataTransfer.files;
    handleFiles(files);
});


function handleFiles(files) {
    const allowedTypes = ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "text/plain"];
    const maxFileSize = 2 * 1024 * 1024; // 

    Array.from(files).forEach((file) => {
        if (uploadedFiles.length >= 10) {
            alert("Anda hanya dapat mengunggah hingga 10 file.");
            return;
        }

        if (!allowedTypes.includes(file.type)) {
            alert(`Jenis file tidak didukung: ${file.name}`);
        } else if (file.size > maxFileSize) {
            alert(`Ukuran file terlalu besar (maks 2MB): ${file.name}`);
        } else {
            uploadedFiles.push(file);
            displayFiles();
        }
    });
}


function displayFiles() {
    fileList.innerHTML = ""; 
    uploadedFiles.forEach((file, index) => {
        const fileItem = document.createElement("div");
        fileItem.className = "file-item";
        fileItem.innerHTML = `
            <span>${file.name} (${(file.size / 1024).toFixed(1)} KB)</span>
            <button class="remove-btn" data-index="${index}">Hapus</button>
        `;
        fileList.appendChild(fileItem);
    });


    document.querySelectorAll(".remove-btn").forEach((btn) => {
        btn.addEventListener("click", removeFile);
    });
}


function removeFile(event) {
    const fileIndex = event.target.getAttribute("data-index");
    uploadedFiles.splice(fileIndex, 1);
    displayFiles();
}

document.getElementById("simpanresumebutton").addEventListener("click", function () {
  const uploadedFilesContainer = document.getElementById("file-list"); 
  const mainResumeContainer = document.getElementById("resumefile");   


  mainResumeContainer.innerHTML = "";


  const fileItems = uploadedFilesContainer.querySelectorAll(".file-item");

  if (fileItems.length === 0) {
      const message = document.createElement("p");
      message.className = "note";
      message.textContent = "Tidak ada resume yang ditambahkan";
      mainResumeContainer.appendChild(message);
      return;
  }


  fileItems.forEach(function (fileItem) {
      const fileName = fileItem.querySelector("span").textContent; // 

      const fileDisplay = document.createElement("p");
      fileDisplay.className = "uploaded-resume";
      fileDisplay.textContent = fileName;

      mainResumeContainer.appendChild(fileDisplay);
  });

  document.getElementById("popupresume").classList.remove("active");

  const noResumeMessage = document.getElementById("noResumeMessage");
  if (noResumeMessage) {
      noResumeMessage.remove();
  }
});

document.getElementById("ubahinformasipribadi").addEventListener("click", function() {
  document.getElementById("popupinformasipribadi").classList.add("active");
});

document.getElementById("closePopupinformasipribadi").addEventListener("click", function() {
  document.getElementById("popupinformasipribadi").classList.remove("active");
});

document.getElementById("batalinformasipribadi").addEventListener("click", function() {
  document.getElementById("popupinformasipribadi").classList.remove("active");
});

document.getElementById("simpaninformasipribadibutton").addEventListener("click", function() {
  var summaryNamaText = document.getElementById("summarynamadepan").value+" "+document.getElementById("summarynamabelakang").value;
  var summaryLokasiText = document.getElementById("summarylokasi").value;
  var summaryEmailText = document.getElementById("summaryemail").value;

  if (summaryNamaText.trim() === ""||summaryLokasiText.trim() === ""||summaryEmailText.trim() === "") {
      alert("Data tidak boleh kosong.");
      return;
  }

  document.getElementById("nama").innerHTML = summaryNamaText;
  document.getElementById("lokasi").innerHTML = summaryLokasiText;
  document.getElementById("email").innerHTML = summaryEmailText;

  var existingSummary = summarySection.querySelector("p.summary-text");
  if (existingSummary) {
      existingSummary.innerHTML = summaryText; 
  } else {
      var newSummary = document.createElement("p");
      newSummary.innerHTML = summaryText; 
      newSummary.classList.add("summary-text");
      content.innerHTML = ""; 
      summarySection.insertBefore(newSummary, summarySection.querySelector(".add-button"));
  }
  document.getElementById("popup").classList.remove("active");
  document.getElementById("summary").value = ""; 
});