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
    <li><a href="{{ route('workersunion.halamanUtamaPerusahaan') }}">Perusahaan</a></li>
    <li><a href="#">Tentang</a></li>
    <li><a href="{{ route('workersunion.loginIndex') }}" class="masuk">Masuk</a></li>
    <li><a href="#" class="post-job-btn">+ Posting Pekerjaan</a></li>
  </ul>
</nav>

<div class="container">
  <div class="form-title">Calon Pekerja</div>
  <div class="subtitle">Temukan Lowongan Sesuai Gaji Anda</div>

  <form id="registerForm" action="{{ route('workersunion.storePekerja') }}" method="POST" style="margin-top: 20px;">
    @csrf 
    
    <a href="#" class="facebook-btn">
      <img src="{{ asset('images/FacebookIcon.png') }}" alt="Facebook"> Masuk dengan Facebook
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
    Sudah punya akun? <a href="{{ route('workersunion.loginIndex') }}">Masuk</a><br>
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

    var namaDepan = document.getElementById("namaDepan").value.trim();
    var namaBelakang = document.getElementById("namaBelakang").value.trim();
    var email = document.getElementById("email").value.trim();
    var password = document.getElementById("password").value.trim();

    var messageContainer = document.getElementById("message-container");
    var messageContainerPW = document.getElementById("message-container-PW");

    let isValid = true;
    messageContainer.innerHTML = '';
    messageContainerPW.innerHTML = '';

    if (namaDepan === '' || namaBelakang === '' || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email) || password.length < 8 || !/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password)) {
        if (namaDepan === '') {
            document.getElementById("namaDepan").style.border = '1px solid #FF0000';
        }
        if (namaBelakang === '') {
            document.getElementById("namaBelakang").style.border = '1px solid #FF0000';
        }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            document.getElementById("email").style.border = '1px solid #FF0000';
            var failMessage = document.createElement("p");
            failMessage.textContent = "Masukkan Email yang Valid";
            failMessage.style.color = "#FF0000";
            failMessage.style.fontSize = "10px";
            messageContainer.appendChild(failMessage);
        }
        if (password.length < 8 || !/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password)) {
            document.getElementById("password").style.border = '1px solid #FF0000';
            var failMessagePW = document.createElement("p");
            failMessagePW.textContent = "Password tidak memenuhi syarat";
            failMessagePW.style.color = "#FF0000";
            failMessagePW.style.fontSize = "10px";
            messageContainerPW.appendChild(failMessagePW);
        }
        isValid = false;
    }

    if (!isValid) {
        return;
    }
    const emailData = { email };
    fetch('{{ route("workersunion.checkEmail") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(emailData),
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then((data) => {
        if (data.exists) {
            // Handle existing email case
            document.getElementById("email").style.border = '1px solid #FF0000';
            var failMessage = document.createElement("p");
            failMessage.textContent = "Email telah terdaftar";
            failMessage.style.color = "#FF0000";
            failMessage.style.fontSize = "10px";
            messageContainer.appendChild(failMessage);
            return;
        }

        // If email is available, submit the form
        document.getElementById("registerForm").submit(); // Submit the form normally
    })
    .catch((error) => {
        console.error('There was a problem with the fetch operation:', error);
    });
    
}

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