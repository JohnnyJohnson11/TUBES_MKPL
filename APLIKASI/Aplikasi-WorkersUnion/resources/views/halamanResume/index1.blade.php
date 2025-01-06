<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jawaban Pertanyaan Perusahaan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/lamarPekerjaan1.css') }}">
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

    <!-- Header -->
    <div class="header">
        <img src="{{$pekerjaan['logoPerusahaan']}}" alt="Company Logo">
        <div>
            <h2><strong>{{$pekerjaan['kategoriJabatan']}}</strong></h2>
            <p>{{$pekerjaan['namaBisnis']}}</p>
        </div>
    </div>

    <!-- Progress Navigation -->
    <div class="stepper">
        <div class="step active">
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
        <div class="step">
          <span>3</span>
          <p>Tinjau dan Kirim</p>
        </div>
    </div>

    <!-- Form Container -->
    <div id="questionsContainer" class="container">

    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const pertanyaan = "{{$pekerjaan['pertanyaan']}}";

        const questionsMap = {
            1: "Berapa gaji bulanan yang Anda inginkan?",
            2: "Berapa tahun pengalaman Anda sebagai Staff Administrasi?",
            3: "Produk Microsoft apa saja yang bisa Anda gunakan?",
            4: "Bagaimana Anda menilai kemampuan bahasa Inggris Anda?",
            5: "Apakah Anda bersedia bepergian untuk pekerjaan ini saat dibutuhkan?",
            6: "Bahasa apa saja yang fasih Anda gunakan?",
            7: "Apakah Anda bersedia menjalani pemeriksaan latar belakang?"
        };

        const container = document.getElementById("questionsContainer");

        const questionNumbers = pertanyaan.split(",");

        questionNumbers.forEach((questionNumber) => {
            const questionText = questionsMap[questionNumber.trim()]; 
            if (questionText) {
                const questionElement = document.createElement("h3");
                questionElement.textContent = questionText;
                container.appendChild(questionElement);

                const inputFieldContainer = document.createElement("div");
                inputFieldContainer.className = "input-field";
                const inputField = document.createElement("input");
                inputField.type = "text";
                inputField.setAttribute("data-question", questionNumber); 
                inputFieldContainer.appendChild(inputField);

                container.appendChild(inputFieldContainer);
            }
        });

        function storeAnswers() {
            const inputs = document.querySelectorAll(".input-field input");
            const answers = Array.from(inputs).map(input => input.value.trim());
            const answersString = answers.join("~"); 
            console.log("Answers String:", answersString);
            const store = {
                answersString
            };

            fetch('{{ route("workersunion.lamarPekerjaanStorePage1") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify(store),
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
        }

                const submitButton = document.createElement("button");
                submitButton.textContent = "Submit Answers";
                submitButton.style.cssText = "margin-top: 20px;";
                submitButton.addEventListener("click", storeAnswers);
                container.appendChild(submitButton);

            });
            
</script>
</html>
