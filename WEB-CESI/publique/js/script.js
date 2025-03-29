/*menu compte*/
document.addEventListener("DOMContentLoaded", function () {
    const dropdownToggle = document.querySelector(".compte");
    const dropdownList = document.querySelector(".w-dropdown-list");

    dropdownToggle.addEventListener("click", function (event) {
        event.stopPropagation();
        console.log("Clic détecté sur .compte !");
        dropdownList.classList.toggle("active");
        console.log("Classe active : ", dropdownList.classList.contains("active"));
    });

    document.addEventListener("click", function () {
        dropdownList.classList.remove("active");
        console.log("Clic en dehors : fermeture du menu.");
    });

    dropdownList.addEventListener("click", function (event) {
        event.stopPropagation();
    });
});
/*Bouton Favoris*/
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".favoris-btn");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            button.classList.toggle("favori-active");
            button.textContent = button.classList.contains("favori-active") ? "★" : "☆";
        });
    });
});
/* Formulaire */
/*comparaison motde passe */
document.addEventListener("DOMContentLoaded", () => {
    let form = document.getElementById("email-form");
    let password = document.getElementById("password");
    let confirmPassword = document.getElementById("confirm-password");
    let errorDiv = document.getElementById("error");
    let errorText = document.getElementById("errorText");

    // Cache le message d'erreur au chargement de la page
    errorDiv.style.display = "none";

    // Vérification au clic sur "Créer"
    form.addEventListener("submit", (event) => {
        if (password.value !== confirmPassword.value) {
            errorText.textContent = "Les mots de passe ne correspondent pas.";
            errorDiv.style.display = "block";
            event.preventDefault(); // Empêche la soumission du formulaire
        } else {
            errorDiv.style.display = "none";
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const toggles = document.querySelectorAll(".toggle");

    toggles.forEach(toggle => {
        toggle.addEventListener("click", function (event) {
            event.stopPropagation(); // Empêche la fermeture immédiate du menu

            const menu = this.nextElementSibling; // Récupère l'élément suivant (modifsupp)
            
            if (menu && menu.classList.contains("modifsupp")) {
                menu.classList.toggle("visible");
            }
        });
    });

    // Cacher le menu si on clique ailleurs
    document.addEventListener("click", function () {
        document.querySelectorAll(".modifsupp.visible").forEach(menu => {
            menu.classList.remove("visible");
        });
    });
});

/*suppression d'une offre*/
function supprimerOffre() {
    const confirmation = confirm("Voulez-vous vraiment supprimer cette offre ?");
    if (confirmation) {
      alert("Offre supprimée !");
    }
      
}
/*gratification*/
const stars = document.querySelectorAll('.star');
const note = document.getElementById('note');

stars.forEach((star, index) => {
  star.addEventListener('click', () => {
    // Active les étoiles jusqu'à celle cliquée
    stars.forEach((s, i) => {
      s.classList.toggle('favori-active', i <= index);
    });

    // Affiche la note
    note.textContent = `Vous avez donné une note de ${index + 1} / 4`;
  });
});



