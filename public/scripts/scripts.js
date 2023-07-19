// ********** PAGE HOME **********

// ---------- HEADER ----------

// button menu burger (on crée un event au clic qui toggle la classe active sur la nav)
icons.addEventListener("click", () => {
  nav.classList.toggle("active");
});

// ------------------------------

// ---------- CAROUSEL ----------

const carouselContainer = document.getElementById("carousel-container");
const defilement = document.querySelector(".defilement");
const leftButton = document.getElementById("carousel-arrow-left");
const rightButton = document.getElementById("carousel-arrow-right");

// defilement vers la droite
rightButton.addEventListener("click", (e) => {
  const carouselWidth = defilement.clientWidth;
  carouselContainer.scrollLeft += carouselWidth;
});
// defilement vers la gauche
leftButton.addEventListener("click", (e) => {
  const carouselWidth = defilement.clientWidth;
  carouselContainer.scrollLeft -= carouselWidth;
});

// on change les images du carousel en fonction du format de l'ecran
// si l'ecran fait 650px ou moins de largeur, on affiche les images du format mobile, sinon on affiche les images du format desktop
function resizeCarousel() {
  const defilements = document.querySelectorAll(".defilement");
  let position = 1;
  defilements.forEach((mobile) => {
    if (screen.width <= 650) {
      mobile.innerHTML =
        '<img src="../assets/img/service-' +
        position +
        '-mobile.png" alt="mobile format">';
    } else {
      mobile.innerHTML =
        '<img src="../assets/img/service-' +
        position +
        '-desktop.png" alt="desktop format">';
    }
    position++;
  });
}
window.onload = resizeCarousel;
window.onresize = resizeCarousel;

// ------------------------------------

// ---------- NOS AGENCES -------------
// si l'ecran fait 800px ou moins de largeur, on affiche seulement le magasin principal (via media queries) et on modifie le titre au singulier en js puisqu'il n'y a plus qu'un seul magasin affiché
const titleAgency = document.querySelector(".title-agencies");
function resizeAgency() {
  if (screen.width <= 800) {
    titleAgency.textContent = "Notre agence à TOULOUSE pour vous servir ...";
  } else {
    titleAgency.textContent = "Nos agences à TOULOUSE pour vous servir ...";
  }
}
window.onload = resizeAgency;
window.onresize = resizeAgency;

// ---------------------------------------

// ---------- TESTIMONY ------------------
const addTitleToTestimony = document.querySelector(".testimony-form form");
addTitleToTestimony.innerHTML =
  "<h2>Votre avis nous intéresse !</h2>" + addTitleToTestimony.innerHTML;

// code a ameliorer
const labels = document.querySelectorAll("#testimony_note label");

labels.forEach((label) => {
  label.innerHTML = "<i class='fa-solid fa-star'></i>";
});

const labelise = document.querySelectorAll("#testimony_note label i");

for (let i = 0; i < labelise.length; i++) {
  labelise[i].addEventListener("click", () => {
    switch (i) {
      case 0:
        labelise[i].style.color = "yellow";
        labelise[i + 1].style.color = "white";
        labelise[i + 2].style.color = "white";
        labelise[i + 3].style.color = "white";
        labelise[i + 4].style.color = "white";
        break;
      case 1:
        labelise[i].style.color = "rgb(255, 246, 0)";
        labelise[i - 1].style.color = "rgb(255, 246, 0)";
        labelise[i + 1].style.color = "white";
        labelise[i + 2].style.color = "white";
        labelise[i + 3].style.color = "white";
        break;
      case 2:
        labelise[i].style.color = "rgb(255, 246, 0)";
        labelise[i - 1].style.color = "rgb(255, 246, 0)";
        labelise[i - 2].style.color = "rgb(255, 246, 0)";
        labelise[i + 1].style.color = "white";
        labelise[i + 2].style.color = "white";
        break;
      case 3:
        labelise[i].style.color = "rgb(255, 246, 0)";
        labelise[i - 1].style.color = "rgb(255, 246, 0)";
        labelise[i - 2].style.color = "rgb(255, 246, 0)";
        labelise[i - 3].style.color = "rgb(255, 246, 0)";
        labelise[i + 1].style.color = "white";
        break;
      case 4:
        labelise[i].style.color = "rgb(255, 246, 0)";
        labelise[i - 1].style.color = "rgb(255, 246, 0)";
        labelise[i - 2].style.color = "rgb(255, 246, 0)";
        labelise[i - 3].style.color = "rgb(255, 246, 0)";
        labelise[i - 4].style.color = "rgb(255, 246, 0)";
        break;
      default:
        labelise[i].style.color = "rgb(255, 246, 0)";
        break;
    }
  });
}

// ----------------------------------
