<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Workers Union - Login</title>
  <link rel="stylesheet" href="{{ asset('css/daftar.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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
    <li><a href="D:\WebPro\TUBES_WEBPRO bagian sean_1302220069\Halaman login.html" class="masuk">Masuk</a></li>
    <li><a href="#" class="post-job-btn">+ Posting Pekerjaan</a></li>
  </ul>
</nav>

<div class="container">
  <div class="form-title">Calon Pekerja</div>
  <div class="subtitle">Temukan Lowongan Sesuai Gaji Anda</div>

  <form id="registerForm" action="{{ route('workersunion.storePekerja') }}" method="POST" style="margin-top: 20px;">
    @csrf 
    
    <a href="#" class="facebook-btn">
      <img src="./images/FacebookIcon.png" alt="Facebook"> Masuk dengan Facebook
    </a>

    <p class="privacy-notice">Kami tidak akan mengunggah apapun tanpa izin dari Anda</p>

    <div class="divider"><span>Atau</span></div>

    <div class="input-row">
      <input type="text" name="namaDepan" id="namaDepan" placeholder="Nama Depan" style="width: 155px;margin-right: 5px;" required>
      <input type="text" name="namaBelakang" id="namaBelakang" placeholder="Nama Belakang" style="width: 155px;" required>
    </div>
    <div class="input-group" style="margin-bottom: 0px">
      <input type="email" name="email" id="email" placeholder="Email" required>
    </div>
    <div id="message-container" style="margin-bottom: 13px; margin-top: 2px;"></div>
    <div class="input-container" style="margin-bottom: 0px">
      <input type="password" name="password" id="password" placeholder="Enter password" style="padding-right: 31px;" required>
      <span class="tooltip-icon" onclick="toggleTooltip()" style="
        padding-left: 7px;
        padding-right: 7px;
        margin-right: 4px;
        margin-left: 4px;
        margin-top: 0.65rem;
        margin-bottom: 0.65rem;
        right:3px">?</span>
      <div class="tooltip-text" id="tooltipTextInvalid">
        Kata sandi minimal 8 karakter, terdiri dari Huruf Besar, Huruf Kecil dan Angka.
      </div>
      <div class="tooltip-text" id="tooltipTextValid" style="border: 1px solid #3cff5d">
          Kata Sandi Benar.
      </div>
    </div>
    <div id="message-container-PW" style="margin-bottom: 13px; margin-top: 2px;"></div>
    
    <div class="checkbox-group">
      <input type="checkbox" id="remember" name="remember">
      <label for="remember">Terima Promosi WorkersUnion.com</label>
    </div>

    <button type="submit" id="register" class="login-btn">Daftar</button>
  </form>
  <div class="footer">
    Sudah punya akun? <a href="./Halaman login.html">Masuk</a><br>
    <p>Dengan memilih "Daftar Sekarang", saya telah membaca dan menyetujui Persyaratan Penggunaan WorkersUnion.com dan Kebijakan Privasi</p>
  </div>
</div>
<script>
    function toggleTooltip() {
        var tooltipInvalid = document.getElementById("tooltipTextInvalid");
        var tooltipValid = document.getElementById("tooltipTextValid");
        var input = document.getElementById("password");
        var inputValue=input.value;
        var passwordValidity = false;
        var hasUppercase = /[A-Z]/.test(inputValue);
        var hasLowercase = /[a-z]/.test(inputValue);
        var hasNumber = /[0-9]/.test(inputValue);

        if (inputValue.length > 8 && hasUppercase && hasLowercase && hasNumber) {
            passwordValidity=true;
        } 
        if (passwordValidity){
            if (tooltipValid.style.display === "block") {
                tooltipValid.style.display = "none";
            } else {
                tooltipValid.style.display = "block";
                tooltipInvalid.style.display = "none";
            }
        } else {
            if (tooltipInvalid.style.display === "block") {
                tooltipInvalid.style.display = "none";
            } else {
                tooltipInvalid.style.display = "block";
                tooltipValid.style.display = "none";
            }
        }   
    }
    function buttonClicked(event) {
      event.preventDefault();
      var namaDepan=document.getElementById("namaDepan");
      var namaDepanValue=namaDepan.value;

      var namaBelakang=document.getElementById("namaBelakang");
      var namaBelakangValue=namaBelakang.value;

      var email = document.getElementById("email");
      var emailValue = email.value;
      var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      var messageContainer = document.getElementById("message-container");
      messageContainer.innerHTML='';

      var password = document.getElementById("password");
      var passwordValue = password.value;
      var hasUppercase = /[A-Z]/.test(passwordValue);
      var hasLowercase = /[a-z]/.test(passwordValue);
      var hasNumber = /[0-9]/.test(passwordValue);
      var messageContainerPW = document.getElementById("message-container-PW");

      let isValid=true;
      messageContainerPW.innerHTML='';

      if (namaDepanValue.length===0 || namaBelakangValue.length=== 0 || !(passwordValue.length > 8 && hasUppercase && hasLowercase && hasNumber) || !emailPattern.test(emailValue)){
          isValid=false;
          if (namaDepanValue.length===0){
              namaDepan.style.border='1px solid #FF0000';
          }
          if (namaBelakangValue.length===0){
              namaBelakang.style.border='1px solid #FF0000';
          }
          if(!emailPattern.test(emailValue)){
              email.style.border='1px solid #FF0000';
              var failMessage = document.createElement("p");
              failMessage.textContent = "Masukkan Email yang Valid"; 
              failMessage.style.color = "#FF0000";
              failMessage.style.fontSize ="10px"
              messageContainer.appendChild(failMessage);
          }
          if (!(passwordValue.length > 8 && hasUppercase && hasLowercase && hasNumber)) {
              password.style.border='1px solid #FF0000';
              var failMessagePW = document.createElement("p");
              failMessagePW.textContent = "Password tidak memenuhi syarat"; 
              failMessagePW.style.color = "#FF0000";
              failMessagePW.style.fontSize ="10px"
              messageContainerPW.appendChild(failMessagePW);
          }
      } 



      if (!isValid) {
          return; 
      }

      const formData = {
    namaDepan: namaDepanValue,
    namaBelakang: namaBelakangValue,
    email: emailValue,
    password: passwordValue,
};

fetch('{{ route("workersunion.storePekerja") }}', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
    body: JSON.stringify(formData),
})
    .then((response) => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then((data) => {
        if (data.success) {
            alert(data.message); // Handle success
        } else {
            alert('Error: ' + data.message); // Handle validation error
        }
    })
    .catch((error) => {
        console.error('Error submitting form:', error);
        alert('An error occurred while submitting the form.');
    });

    };
    function textFieldClicked(){
        namaDepan.style.border='1px solid #ccc';
        namaBelakang.style.border='1px solid #ccc';
        var messageContainer = document.getElementById("message-container");
        email.style.border='1px solid #ccc';
        messageContainer.innerHTML='';
        var messageContainerPW = document.getElementById("message-container-PW");
        password.style.border='1px solid #ccc';
        messageContainerPW.innerHTML='';
    }
    window.onload = function() {
      const button = document.getElementById("register");
      button.addEventListener("click", buttonClicked);

      const textFieldNamaDepan = document.getElementById("namaDepan");
      textFieldNamaDepan.addEventListener("focus", textFieldClicked);

      const textFieldNamaBelakang = document.getElementById("namaBelakang");
      textFieldNamaBelakang.addEventListener("focus", textFieldClicked);

      const textFieldEmail = document.getElementById("email");
      textFieldEmail.addEventListener("focus", textFieldClicked);

      const textFieldPassword = document.getElementById("password");
      textFieldPassword.addEventListener("focus", textFieldClicked);

      document.getElementById('registerForm').addEventListener('submit', buttonClicked);
    };
    
    
  </script>

</body>
</html>