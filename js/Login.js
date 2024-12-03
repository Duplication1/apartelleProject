const passwordField = document.getElementById("password");
const eyeIcon = document.querySelector(".eye-icon");

function togglePassword() {
  if (passwordField.type === "password") {
    passwordField.type = "text";
    eyeIcon.textContent = "visibility_off";
  } else {
    passwordField.type = "password";
    eyeIcon.textContent = "visibility";
  }
}

eyeIcon.onclick = togglePassword;
