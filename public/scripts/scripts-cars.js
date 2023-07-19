// fonction de separateur de milliers
function lisibilite_nombre(nbr) {
  var nombre = "" + nbr;
  var retour = "";
  var count = 0;
  for (var i = nombre.length - 1; i >= 0; i--) {
    if (count != 0 && count % 3 == 0) retour = nombre[i] + " " + retour;
    else retour = nombre[i] + retour;
    count++;
  }
  return retour;
}

//   affichage dynamique des valeurs des inputs et boutons reset
// mileage
const mileageInput = document.querySelector(".mileage-input");
const mileageValue = document.querySelector(".mileage-value");
mileageValue.textContent = mileageInput.min + "km - " + mileageInput.max + "km";
mileageInput.addEventListener("change", (e) => {
  mileageValue.textContent =
    e.target.min + "km - " + lisibilite_nombre(e.target.value) + "km";
});
// document.querySelector(".mileage-reset").addEventListener("click", (e) => {
//   e.preventDefault();
//   mileageInput.value = mileageInput.max;
//   mileageValue.textContent =
//     mileageInput.min + "km - " + lisibilite_nombre(mileageInput.value) + "km";
// });

// price
const priceInput = document.querySelector(".price-input");
const priceValue = document.querySelector(".price-value");
priceValue.textContent =
  priceInput.min + "€ - " + lisibilite_nombre(priceInput.max) + "€";
priceInput.addEventListener("change", (e) => {
  priceValue.textContent =
    e.target.min + "€ - " + lisibilite_nombre(e.target.value) + "€";
});
// document.querySelector(".price-reset").addEventListener("click", (e) => {
//   e.preventDefault();
//   priceInput.value = priceInput.max;
//   priceValue.textContent =
//     priceInput.min + "€ - " + lisibilite_nombre(priceInput.value) + "€";
// });

// year
const yearInput = document.querySelector(".year-input");
const yearValue = document.querySelector(".year-value");
yearValue.textContent = yearInput.min + " - " + yearInput.max;
yearInput.addEventListener("change", (e) => {
  yearValue.textContent = e.target.min + " - " + e.target.value;
});
// document.querySelector(".year-reset").addEventListener("click", (e) => {
//   e.preventDefault();
//   yearInput.value = yearInput.max;
//   yearValue.textContent = yearInput.min + " - " + yearInput.max;
// });

//   traitement ajax des données
const filtersForm = document.querySelector("#filters");

//   on crée une boucle sur les input
document.querySelectorAll("#filters input").forEach((input) => {
  input.addEventListener("change", () => {
    // on intercepte les clics
    // on recupere les données du formulaire
    const form = new FormData(filtersForm);

    //   on fabrique la queryString
    const params = new URLSearchParams();

    params.append("ajax", "filters");

    form.forEach((value, key) => params.append(key, value));

    //   on recupere l'url active
    const url = new URL(window.location.href);

    //   on lance la requete ajax
    fetch(url + "?" + params.toString() + "&ajax=1", {
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        // on recupere la zone a modifier
        const content = document.querySelector("#content");
        //   on remplace
        content.innerHTML = data.content;
      })
      .catch((e) => console.log(e.message));
  });
});
