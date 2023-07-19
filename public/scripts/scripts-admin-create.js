// ---------- PAGE ADMIN/CREATE ----------
const titleCreateEmploye = document.querySelector(".create-employe-title");

function resizeTitle() {
  if (screen.width <= 750) {
    titleCreateEmploye.innerHTML =
      '<a href="/"><img src="../assets/img/logo-slogan-mobile.png" alt="logo du site"></a>';
  } else {
    titleCreateEmploye.innerHTML =
      '<a href="/"><img src="../assets/img/logo-desktop.png" alt="logo du site"></a>';
  }
}
window.onload = resizeTitle;
window.onresize = resizeTitle;

// petit script js qui permet d'afficher/masquer le mdp lors de la saisie
function togglePassword() {
  const passwordInput = document.querySelector("#create_employe_password");
  passwordInput.type = passwordInput.type === "text" ? "password" : "text";

  //   gestion de l'icone oeil fermé/ouvert
  // on crée au prealable une classe hide-eye en css qui a le parametre display: none
  const eyeIcon = document.querySelector(".fa-eye");
  eyeIcon.className =
    eyeIcon.className === "fa-solid fa-eye hide-eye"
      ? "fa-solid fa-eye"
      : "fa-solid fa-eye hide-eye";

  const eyeSlashIcon = document.querySelector(".fa-eye-slash");
  eyeSlashIcon.className =
    eyeSlashIcon.className === "fa-solid fa-eye-slash hide-eye"
      ? "fa-solid fa-eye-slash"
      : "fa-solid fa-eye-slash hide-eye";
}
