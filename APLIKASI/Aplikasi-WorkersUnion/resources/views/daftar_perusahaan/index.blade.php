<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Job Listings</title>
    <link rel="stylesheet" href="{{ asset('css/daftar_perusahaan.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="navbar">
        <h1><span class="highlight">Workers</span> Union</h1>
        @if (session()->has('idPekerja'))
        <ul class="nav-list">
            <li><a href="{{ route('workersunion.homePage') }}">Home</a></li>
            <li><a href="{{ route('workersunion.lihatPekerjaan') }}">Pekerjaan</a></li>
            <li><a href="{{ route('workersunion.halamanUtamaPerusahaan') }}">Perusahaan</a></li>
            <li class="user-menu">
                <a href="#" class="username">{{$pekerjas[0]['username']}} <span>&#9662;</span></a>
                <div class="dropdown-menu">
                    <a href='{{ route("workersunion.profilePage") }}'>Lihat Profil</a>
                    <a href="{{ route('workersunion.halamanUtama') }}">Keluar</a>
                </div>
            </li>
            <li><a href="#" class="post-job-btn">+ Posting Pekerjaan</a></li>
        </ul>
        @else
        <ul class="nav-list">
          <li><a href="{{ route('workersunion.halamanUtama') }}">Home</a></li>
          <li><a href="{{ route('workersunion.loginIndex') }}">Pekerjaan</a></li>
          <li><a href="#">Perusahaan</a></li>
          <li><a href="{{ route('workersunion.loginIndex') }}">Masuk</a></li> 
          <li><a href="{{route('workersunion.logInPerusahaanIndex')}}" class="post-job-btn">+ Posting Pekerjaan</a></li>
        </ul>
        @endif
      </nav>
        <div class="header-content">
            <div class="form-container">
                <h1>Rekrut orang yang Anda butuhkan, mudah dan cepat</h1>
                <p>Daftar sekarang dan pasang iklan lowongan pekerjaan anda GRATIS</p>
                <form id="registerForm" action="{{ route('workersunion.storePerusahaan') }}" method="POST" style="margin-top: 20px;">
                    @csrf
                    <h2>Email atau Login ID</h2>
                    <input id="email" type="email" name="email"placeholder="Email aktif anda" required>
                    <h2>Nama</h2>
                    <input id="username" type="text" name="username"placeholder="Nama lengkap" required>
                    <h2>Nomor HP</h2>
                    <input id="nomorHP" type="text" name="nomorHP"placeholder="No HP" required>
                    <h2>Nama Bisnis Terdaftar</h2>
                    <input id="namaBisnis" type="text" name="namaBisnis"placeholder="Nama Bisnis Terdaftar" required>
                    <h2>Kata Sandi</h2>
                    <input id="password" type="password" name="password"placeholder="Kota Anda" required>
                    
                    <button id="register" type="submit">Daftar</button>
                    <div id="message-container-PW" style="margin-bottom: 13px; margin-top: 2px;"></div>
                    <p>Dengan melanjutkan, saya telah membaca dan menyetujui Persyaratan Penggunaan WorkersUnion.com dan Kebijakan Privasi</p>
                    <p>Sudah punya akun? <a href="{{route('workersunion.logInPerusahaanIndex')}}">Masuk</a></p>
                </form>
            </div>
        </div>

    <section class="trusted-section">
        <h1 style="font-size: 40px;">Dipercaya oleh UKM dan Perusahaan Selama 20+ Tahun</h1>
        <div class="trusted-logos">
            <img src="images/logo1.png" alt="Logo 1">
            <img src="images/logo2.png" alt="Logo 2">
            <img src="images/logo3.png" alt="Logo 3">
            <img src="images/logo4.png" alt="Logo 4">
            <img src="images/logo5.png" alt="Logo 5">
        </div>
    </section>

    <section class="features-section">
        <h1 style="font-size: 40px;">Mengapa memilih WorkersUnion</h1>
        <div class="features">
            <div class="feature-item">
                <img src="images/choice1.png" alt="Logo 1">
                <h3>Kami adalah Pilihan Pertama Para Pencari Kerja</h3>
                <p>Akses 1.3+ juta talenta profesional di Indonesia</p>
            </div>
            <div class="feature-item">
                <img src="images/choice2.png" alt="Logo 1">
                <h3>Kami Dapat Dipercaya</h3>
                <p>Dipercaya oleh 1+ perusahaan di Asia</p>
            </div>
            <div class="feature-item">
                <img src="images/choice3.png" alt="Logo 1">
                <h3>Kami Mendukung Anda</h3>
                <p>Anda mendapat hasil setiap saat</p>
            </div>
        </div>
    </section>

    <section class="steps-section">
        <h1 style="font-size: 40px;">Rekrut Mudah dalam 3 Langkah Sederhana</h1>
        <div style="display: flex;">
            <div style="width: 47%; display: flex; justify-content: flex-end; margin-right: 5px;">
                <img src="images/chinesedude.png" style="width: 80%;">
            </div>
            <div style="width: 60%">
                <div class="steps">
                    <div class="step" style="display: flex; align-items: center;" >
                        <img src="images/num1.png" style="margin-top: 23px;margin-bottom: 23px;">
                        <div style="margin-left: 20px;">
                            <p style="text-align: left; color:#54586a; font-weight: bold;">Daftar untuk akun gratis Anda</p>
                            <p style="font-size: 15px; text-align: left; color:#54586a;">Cukup daftar online dan buat iklan lowongan pekerjaan Anda</p>
                        </div>
                    </div>
                    <div class="step" style="display: flex; align-items: center;">
                        <img src="images/num2.png" style="margin-top: 23px;margin-bottom: 23px;">
                        <div style="margin-left: 20px;">
                            <p style="text-align: left; color:#54586a; font-weight: bold;">Posting iklan pekerjaan Anda</p>
                            <p style="font-size: 15px; text-align: left; color:#54586a;">Gunakan paket Lite Ad GRATIS Anda atau pilih paket jenis iklan kami yang lain</p>
                        </div>
                    </div>
                    <div class="step" style="display: flex; align-items: center;">
                        <img src="images/num3.png" style="margin-top: 23px;margin-bottom: 23px;">
                        <div style="margin-left: 20px;">
                            <p style="text-align: left; color:#54586a; font-weight: bold;">Mulai merekrut</p>
                            <p style="font-size: 15px; text-align: left; color:#54586a;">Kelola semua pelamar dengan platform kami yang mudah digunakan</p>
                        </div>
                    </div>
                    <button style="border: 3px solid #4964E9; color:#4964E9; background-color: transparent; justify-content: flex-start; display:flex;">Pasang Iklan Sekarang</button>
                </div>
                
            </div>
        </div>
    </section>
</body>
<script>
    window.onload = function() {
        document.getElementById("register").addEventListener("click", buttonClicked)
    }
    function buttonClicked(event) {
        event.preventDefault();
        document.getElementById("message-container-PW").innerHTML="";

        var email = document.getElementById("email").value.trim();
        var username = document.getElementById("username").value.trim();
        var nomorHP = document.getElementById("nomorHP").value.trim();
        var namaBisnis = document.getElementById("namaBisnis").value.trim();
        var password = document.getElementById("password").value.trim();

        var messageContainer = document.getElementById("message-container");
        var messageContainerPW = document.getElementById("message-container-PW");

        let isValid = true;

        if (!username || !nomorHP || !namaBisnis || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email) || password.length < 8 || !/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password)) {
            if (!username) {
                document.getElementById("username").style.border = '1px solid #FF0000';
            }
            if (!namaBisnis){
                document.getElementById("namaBisnis").style.border = '1px solid #FF0000';
            }
            if (!nomorHP){
                document.getElementById("nomorHP").style.border = '1px solid #FF0000';
            }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                document.getElementById("email").style.border = '1px solid #FF0000';
                var failMessage = document.createElement("p");
                failMessage.textContent = "Masukkan Email yang Valid";
                failMessage.style.color = "#FF0000";
                failMessage.style.fontSize = "10px";
                messageContainerPW.appendChild(failMessage);
            }
            if (password.length < 8 || !/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password)) {
                document.getElementById("password").style.border = '1px solid #FF0000';
                var failMessagePW = document.createElement("p");
                failMessagePW.textContent = "Password harus lebih panjang dari 8, memiliki huruf kapital, huruf kecil, simbol, dan angka";
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
        fetch('{{ route("workersunion.checkEmailPerusahaan") }}', {
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
                document.getElementById("email").style.border = '1px solid #FF0000';
                var failMessage = document.createElement("p");
                failMessage.textContent = "Email telah terdaftar";
                failMessage.style.color = "#FF0000";
                failMessage.style.fontSize = "10px";
                messageContainerPW.appendChild(failMessage);
                return;
            }

            // If email is available, submit the form
            document.getElementById("registerForm").submit(); 
        })
        .catch((error) => {
            console.error('There was a problem with the fetch operation:', error);
        });
        
    }
    document.querySelector('.user-menu .username').addEventListener('click', function () {
        document.querySelector('.dropdown-menu').classList.toggle('show');
    });
</script>
</html>