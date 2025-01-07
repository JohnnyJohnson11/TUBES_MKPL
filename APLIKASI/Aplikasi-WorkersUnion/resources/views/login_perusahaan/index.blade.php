<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Workers Union - Login</title>
    <link rel="stylesheet" href="{{ asset('css/login_perusahaan.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="navbar">
        <h1><span class="highlight">Workers</span> Union</h1>
        <ul class="nav-list">
            <li><a href="{{ route('workersunion.halamanUtama') }}">Home</a></li>
            <li><a href="{{ route('workersunion.halamanUtamaPerusahaan') }}">Perusahaan</a></li>
            <li><a href="{{route('workersunion.daftarPerusahaanIndex')}}" class="masuk">Daftar Perusahaan</a></li>
            <li><a href="#" class="post-job-btn">+ Posting Pekerjaan</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="form-title">Perusahaan</div>
        <div class="subtitle">Temukan orang terbaik untuk lowongan Anda</div>
      
        <form id="loginForm" action="{{ route('workersunion.logInPerusahaan') }}" method="POST" style="margin-top: 20px;">
          <div class="input-group" style="margin-bottom: 0px">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Email">
            <img id="warning-sign" src="" style="position:absolute;width:20px;right: 6px;bottom: 10px;">
          </div>
          <div id="message-container" style="margin-bottom: 13px; margin-top: 2px;"></div>
          <div class="input-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" placeholder="Password" style="padding-right: 1px;">
              <img id="eyeIcon" src="./images/PW_show.png" style="position:absolute; width:22px; right:6px; bottom:13px; cursor:pointer;">
            </div>
          <div id="message-container-PW" style="margin-bottom: 13px; margin-top: 2px;"></div>
        </form>
        <div class="checkbox-group">
          <input type="checkbox" id="remember">
          <label for="remember">Ingat Saya</label>
        </div>
      
        <button class="login-btn" id="login-btn">Masuk</button>
        
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
  
    }
  };
  function emailClicked(){
    var warningSign=document.getElementById("warning-sign");
    var messageContainer = document.getElementById("message-container");
    email.style.border='1px solid #ccc';
    messageContainer.innerHTML='';
    warningSign.src="";
  }
  function showPassword() {
      var passwordInput = document.getElementById("password");
      var eyeIcon = document.getElementById("eyeIcon"); // Ambil elemen ikon secara langsung
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.src = "./images/PW_hide.png";
      } else {
        passwordInput.type = "password";
        eyeIcon.src = "./images/PW_show.png";
      }
    }
  function PasswordClicked(){
    var messageContainerPW = document.getElementById("message-container-PW");
    password.style.border='1px solid #ccc';
    messageContainerPW.innerHTML='';
  }
  window.onload = function() {
      const emailInput = document.getElementById("email");
      emailInput.addEventListener("focus", emailClicked);
  
      const PasswordInput = document.getElementById("password");
      PasswordInput.addEventListener("focus", PasswordClicked);
  
      const clickEye = document.getElementById("eyeIcon");
      clickEye.addEventListener("click",showPassword);
  };
  document.getElementById('login-btn').addEventListener('click', function (event) {
    event.preventDefault(); 

    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const emailValue = email.value.trim();
    const passwordValue = password.value.trim();
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const messageContainer = document.getElementById("message-container");
    const messageContainerPW = document.getElementById("message-container-PW");

    // Clear previous messages
    messageContainer.innerHTML = '';
    messageContainerPW.innerHTML = '';
    email.style.border = '1px solid #ccc';
    password.style.border = '1px solid #ccc';

    // Validate email and password
    if (!emailPattern.test(emailValue) || passwordValue.length === 0) {
        if (!emailPattern.test(emailValue)) {
            email.style.border = '1px solid #FF0000';
            const failMessage = document.createElement("p");
            failMessage.textContent = "Masukkan Email yang Valid";
            failMessage.style.color = "#FF0000";
            failMessage.style.fontSize = "10px";
            messageContainer.appendChild(failMessage);
            document.getElementById("warning-sign").src = "{{ asset('images/warning.png') }}";
        }
        if (passwordValue.length === 0) {
            password.style.border = '1px solid #FF0000';
            const failMessagePW = document.createElement("p");
            failMessagePW.textContent = "Password tidak boleh kosong";
            failMessagePW.style.color = "#FF0000";
            failMessagePW.style.fontSize = "10px";
            messageContainerPW.appendChild(failMessagePW);
        }
        return; // Stop execution if validation fails
    }

    // Prepare data for submission
    const logInData = { email: emailValue, password: passwordValue };

    // Make the AJAX request
    fetch('{{ route("workersunion.logInPerusahaan") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(logInData),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            if (data.success && data.password) {
              window.location.href = data.redirect;
            } else {
                const failMessage = document.createElement("p");
                failMessage.textContent = data.message;
                failMessage.style.color = "#FF0000";
                failMessage.style.fontSize = "10px";
                messageContainer.appendChild(failMessage);
            }
        })
        .catch((error) => {
            console.error("There was a problem with the fetch operation:", error);
            const failMessage = document.createElement("p");
            failMessage.textContent = "An unexpected error occurred. Please try again later.";
            failMessage.style.color = "#FF0000";
            failMessage.style.fontSize = "10px";
            messageContainer.appendChild(failMessage);
        });
});
  </script>
      </body>
      
      </html>