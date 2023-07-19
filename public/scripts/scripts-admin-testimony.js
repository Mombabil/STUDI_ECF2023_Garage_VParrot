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
