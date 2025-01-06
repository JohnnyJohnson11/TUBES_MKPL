<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jawaban Pertanyaan Perusahaan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/lamarPekerjaan3.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <h1 style="color: #FC766A;"><span class="highlight">Workers</span> Union</h1>
        <ul class="nav-list">
            <li><a href="#">Home</a></li>
            <li><a href="#">Pekerjaan</a></li>
            <li><a href="#">Perusahaan</a></li>
            <li><a href="#">Tentang</a></li>
            <li><a href="#" class="post-job-btn">+ Posting Pekerjaan</a></li>
        </ul>
    </nav>
    <div id="popupinformasipribadi" class="popup">
            <div class="popup-content">
                <span id="closePopupinformasipribadi" class="close-btn">×</span>
                <h2>Ubah informasi pribadi</h2>

            <!-- Input Fields -->
            <div style="display: flex;">
                <div>
                    <label for="summarynamadepan">Nama Depan</label>
                    <textarea id="summarynamadepan" rows="1" cols="50"></textarea>
                </div>
                <div>
                    <label for="summarynamabelakang">Nama Belakang</label>
                    <textarea id="summarynamabelakang" rows="1" cols="50"></textarea>
                </div>
            </div>
            <label for="summarylokasi">Lokasi Rumah</label>
            <textarea id="summarylokasi" rows="1" cols="50"></textarea>

            <!-- Phone Number -->
            <div class="input-group phone-group">
                <label>Nomor telepon <span class="note">(direkomendasikan)</span></label>
                <div class="phone-inputs">
                    <select id="countryCode">
                        <option value="+62" selected="">Indonesia (+62)</option>
                        <option value="+1">United States (+1)</option>
                        <option value="+44">United Kingdom (+44)</option>
                        <option value="+91">India (+91)</option>
                        <option value="+81">Japan (+81)</option>
                        <option value="+86">China (+86)</option>
                        <option value="+61">Australia (+61)</option>
                        <option value="+49">Germany (+49)</option>
                        <option value="+33">France (+33)</option>
                        <option value="+65">Singapore (+65)</option>
                    </select>
                    <input type="text" id="phoneNumber">
                </div>
            </div>

            <!-- Email Section -->
                <label for="summaryemail">Email</label>
                <textarea id="summaryemail" rows="1" cols="50"></textarea>
                <div id="ifexist"></div>
                <button class="save-btn" id="simpaninformasipribadibutton">Selesai</button>
                <button class="cancel-btn" id="batalinformasipribadi">Batal</button>
            </div>
        </div>
    <!-- Header -->
    <div class="header">
        <img src="images/companylogo.png" alt="Company Logo">
        <div>
            <h2><strong>Staff Administrasi</strong></h2>
            <p>PT Adhigana Perkasa Mandiri</p>
        </div>
    </div>
    <div class="stepper">
        <div class="step">
            <span>1</span>
            <p>Jawab Pertanyaan Perusahaan</p>
          </div>
          <img
            src="images/progress_line.png"
            alt="progress line"
            class="progress-line"
          />
          <div class="step">
            <span>2</span>
            <p>Perbarui Profil</p>
          </div>
          <img
            src="images/progress_line.png"
            alt="progress line"
            class="progress-line"
          />
          <div class="step active">
            <span>3</span>
            <p>Tinjau dan Kirim</p>
          </div>  
    </div>

    <div class="profile-section" style="display: flex;">
        <div class="profile-card" style="border-radius: 15px;">
            <h2 id="nama">{{$pekerjas['username']}}</h2>
            <div style="display: flex;">
                <img style="height:22px; margin:5px;"src="images/location.png">
                <p id="lokasi">{{$pekerjas['lokasi']}}</p>
            </div>
            <div style="display: flex;">
                <img style="height:19px; margin:5px;"src="images/mail.png">
                <p id="email">{{$pekerjas['email']}}</p>
            </div>
            
            <button class="edit-btn" id="ubahinformasipribadi">Edit</button>
        </div>
    </div>

    <div class="profile-section">
    
        <div class="section">
            <h3>Pertanyaan Perusahaan</h3>
            <p id="answerSummary">Anda menjawab 4 dari 4</p>
            <button class="edit-button" onclick="window.location.href='{{ route('workersunion.halamanResume') }}';">Edit</button>
        </div>
    
        <div class="section">
            <h3>Profil WorkersUnion anda</h3>
            <p>
                Saat Anda melamar pekerjaan, Profil WorkersUnion Anda dan kredensial terverifikasi apa pun akan 
                diakses oleh PT Adhigana Perkasa Mandiri sebagai bagian dari lamaran pekerjaan Anda.
            </p>
            <table class="profile-table">
                <tr>
                    <td>Riwayat Pekerjaan</td>
                    <td id="jumlahPekerjaan">0 Peran</td>
                </tr>
                <tr>
                    <td>Pendidikan</td>
                    <td id="jumlahPendidikan">0 kualifikasi</td>
                </tr>
                <tr>
                    <td>Lisensi & sertifikasi</td>
                    <td id="jumlahLisensi">0 kredensial</td>
                </tr>
                <tr>
                    <td>Skill</td>
                    <td id="jumlahSkill">0 skill</td>
                </tr>
            </table>
            <button class="edit-button" style="margin-bottom: 15px;">Edit</button>
            <div class="note" style="margin-bottom: 15px;">Saat Anda melamar di WorkersUnion, Profil WorkersUnion Anda termasuk kredensial terverifikasi akan diakses oleh perusahaan. Jika pengaturan Visibilitas Profil Anda diatur ke Standar atau Terbatas, pemberi kerja dan perekrut lain juga dapat menghubungi Anda terkait peluang kerja. Belajarlah lagi</div>
            <div class="note">Semua informasi pribadi yang Anda kirimkan sebagai bagian dari aplikasi akan kami gunakan sesuai dengan Kebijakan Privasi kami.</div>
            <button style="margin-top: 20px;" id="submitLamaran">Submit Resume</button>
        </div>
    </div>
    
</body>
<script>
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
    document.getElementById("ifexist").innerHTML="";
  var summaryNamaText = document.getElementById("summarynamadepan").value+" "+document.getElementById("summarynamabelakang").value;
  var summaryLokasiText = document.getElementById("summarylokasi").value.trim();
  var summaryEmailText = document.getElementById("summaryemail").value.trim();
  var summaryTeleponText = document.getElementById("phoneNumber").value.trim();

    if (!summaryNamaText||!summaryLokasiText||!summaryEmailText||!summaryTeleponText) {
        alert("Semua bidang harus diisi.");
        return;
    }
    const informasiPekerja = {
        username: summaryNamaText,
        lokasi: summaryLokasiText,
        email: summaryEmailText,
        nomorHP: summaryTeleponText,
    };

    fetch('{{ route("workersunion.updatePekerja") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(informasiPekerja),
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.statusText}`);
        }
        return response.json();
    })
    .then((data) => {
        if (data.dontExist) {
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
            event.preventDefault();
        } else if(!data.dontExist){
            const submitEmail = document.createElement("p");
            submitEmail.textContent = "email telah terdaftar";
            submitEmail.style.cssText = "color:red";
            document.getElementById("ifexist").appendChild(submitEmail);
        }else{
            alert(`Error: ${data.message}`);
        }
    })
    .catch((error) => {
        console.error('There was a problem with the fetch operation:', error);
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const pekerjaan = {!! json_encode($pekerjaan) !!};

    document.getElementById("jumlahPekerjaan").textContent = {{$pekerjaan['namaPerusahaan'] ?? 'null'}} !== 'null' ? "1 Peran" : "0 Peran" ;
    document.getElementById("jumlahPendidikan").textContent = {{$pekerjaan['kursusPendidikan'] ?? 'null'}} !== 'null' ? "1 Kualifikasi" : "0 Kualifikasi" ;
    document.getElementById("jumlahLisensi").textContent = {{$pekerjaan['namaLisensi'] ?? 'null'}} !== 'null' ? "1 Kredensial" : "0 Kredensial" ;

    // Extract the session data
    const lamarPekerjaanPage1 = {!! json_encode(session('lamarPekerjaanPage1', '')) !!};

    console.log("Raw session data:", lamarPekerjaanPage1);

    // Check if lamarPekerjaanPage1 is an object and extract the answers string
    const answersString = typeof lamarPekerjaanPage1 === 'object' && lamarPekerjaanPage1.answersString
        ? lamarPekerjaanPage1.answersString
        : '';

    console.log("Extracted answersString:", answersString);

    // Process the answers string into an array
    const answers = answersString.split("~");
    console.log("Processed answers:", answers);

    // Count only non-empty, non-null answers
    const answeredCount = answers.filter(answer => answer && answer.trim() !== "").length;
    console.log("Number of valid answers:", answeredCount);

    // Assuming the total number of questions
    const totalQuestions = answers.length; // Total questions are derived from the array length
    document.getElementById("answerSummary").textContent = `Anda menjawab ${answeredCount} dari ${totalQuestions}`;
    const idPekerja = {{ json_encode(session('idPekerja')) }};
    const skillsContainer = document.getElementById("skills");
    const ifNullMessage = document.getElementById("ifnullskill");

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
            document.getElementById("jumlahSkill").textContent = `${data.skills.length} Skill`;
        })
        .catch((error) => {
            console.error("Error loading skills:", error);
        });
});

document.getElementById("submitLamaran").addEventListener("click", function() {
    fetch('{{ route("workersunion.createLamaran") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        window.location.href = data.redirect;
                    } else {
                        alert(data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error with fetch operation:', error);
                });
});

</script>
</html>