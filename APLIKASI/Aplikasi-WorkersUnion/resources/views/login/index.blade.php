<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Workers Union - Login</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
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
    <li><a href="#" class="masuk">Masuk</a></li>
    <li><a href="#" class="post-job-btn">+ Posting Pekerjaan</a></li>
  </ul>
</nav>

<div class="container">
  <div class="form-title">Calon Pekerja</div>
  <div class="subtitle">Temukan Lowongan Sesuai Gaji Anda</div>

  <a href="#" class="facebook-btn">
    <img src="./images/FacebookIcon.png" alt="Facebook"> Masuk dengan Facebook
  </a>

  <p class="privacy-notice">Kami tidak akan mengunggah apapun tanpa izin dari Anda</p>

  <div class="divider"><span>Atau</span></div>

  <div class="input-group" style="margin-bottom: 0px">
    <label for="email">Email</label>
    <input type="email" id="email" placeholder="Email">
    <img id="warning-sign" src="" style="position:absolute;width:20px;right: 6px;bottom: 10px;">
  </div>
  <div id="message-container" style="margin-bottom: 13px; margin-top: 2px;"></div>
  <div class="input-group" style="margin-bottom: 0px">
    <label for="password">Password</label>
    <input type="password" id="password" placeholder="Password" style="
    padding-right: 30px;">
    <span><img id="eyeIcon"src="./images/PW_show.png" style="position:absolute;width:22px;right: 6px;bottom: 12px;"></span> 
  </div>
  <div id="message-container-PW" style="margin-bottom: 13px; margin-top: 2px;"></div>
  <div class="checkbox-group">
    <input type="checkbox" id="remember">
    <label for="remember">Ingat Saya</label>
  </div>

  <button class="login-btn" id="login">Masuk</button>
  
  <div class="footer">
    Pengguna baru? <a href="./Halaman Daftar.html">Daftar</a><br>
    <p>Dengan Terhubung ke Facebook, Saya telah membaca dan menyetujui Ketentuan Penggunaan dan Kebijakan Privasi Workers Union.com</p>
  </div>
</div>
<script>
  function buttonClicked() {
    var email=document.getElementById("email");
    var warningSign=document.getElementById("warning-sign");
    var emailValue = email.value;
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var messageContainer = document.getElementById("message-container");
    var messageContainerPW = document.getElementById("message-container-PW");
    messageContainer.innerHTML = '';
    messageContainerPW.innerHTML ='';
    var input = document.getElementById("password");
    var inputValue=input.value;
    if(!emailPattern.test(emailValue)||inputValue.length===0){
      if (!emailPattern.test(emailValue)){
        email.style.border='1px solid #FF0000';
        var failMessage = document.createElement("p");
        failMessage.textContent = "Masukkan Email yang Valid"; 
        failMessage.style.color = "#FF0000";
        failMessage.style.fontSize ="10px"
        messageContainer.appendChild(failMessage);
        warningSign.src="./images/warning.png";
      } 
      if(inputValue.length===0){
        input.style.border='1px solid #FF0000';
        var failMessagePW = document.createElement("p");
        failMessagePW.textContent = "Password tidak boleh kosong"; 
        failMessagePW.style.color = "#FF0000";
        failMessagePW.style.fontSize ="10px"
        messageContainerPW.appendChild(failMessagePW);
      }
    }
    else{
      window.location.href="D:/WebPro/TUBES-WEBPRO-M.Daffa-Fathoni-Siregar_1302223092/home_page/home.html";
    }
  };
  function emailClicked(){
    var warningSign=document.getElementById("warning-sign");
    var messageContainer = document.getElementById("message-container");
    email.style.border='1px solid #ccc';
    messageContainer.innerHTML='';
    warningSign.src="";
  }
  function showPassword(){
    var passwordInput = document.getElementById("password");
    if(passwordInput.type==="text"){
      passwordInput.type = "password";
      this.src="./images/PW_show.png";
    }else{
      passwordInput.type = "text";
      this.src="./images/PW_hide.png";
    }
  }
  function PasswordClicked(){
    var messageContainerPW = document.getElementById("message-container-PW");
    password.style.border='1px solid #ccc';
    messageContainerPW.innerHTML='';
  }
  window.onload = function() {
      const button = document.getElementById("login");
      button.addEventListener("click", buttonClicked);

      const emailInput = document.getElementById("email");
      emailInput.addEventListener("focus", emailClicked);

      const PasswordInput = document.getElementById("password");
      PasswordInput.addEventListener("focus", PasswordClicked);

      const clickEye = document.getElementById("eyeIcon");
      clickEye.addEventListener("click",showPassword);
  };
</script>
</body>
</html>
