// ---------- PAGE SERVICES ----------
const servicesDisplay = document.querySelectorAll(".service-img");
console.log(servicesDisplay);

// pour chacune des div, on affiche l'un des trois background disponible au hasard
servicesDisplay.forEach((service) => {
  service.style.background =
    "url('../assets/img/background-desktop-services-" +
    Math.floor(Math.random() * (3 - 1 + 1) + 1) +
    ".png')";
  service.style.backgroundSize = "20%";
  service.style.backgroundRepeat = "no-repeat";
  let position = [0, 100];
  //   la position du background est aleatoirement soit tout a gauche, soit tout a droite
  service.style.backgroundPosition =
    position[Math.floor(Math.random() * position.length)] + "% 75%";
});
