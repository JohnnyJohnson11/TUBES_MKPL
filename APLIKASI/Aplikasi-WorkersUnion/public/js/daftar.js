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
    namaDepan,
    namaBelakang,
    email,
    password,
  };

  fetch('{{ route("workersunion.storePekerja") }}', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
    body: JSON.stringify(formData),
  })
  .then((response) => response.json())
  .then((data) => {
    console.log('Response text:', text); 
    const data = JSON.parse(text);

      if (data.success) {
          alert(data.message);
      } else {
          alert('Error: ' + data.message);
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