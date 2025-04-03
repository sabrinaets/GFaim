<?php
if(!isset($_SESSION)) {
    session_start(); // Toujours démarrer la session
}
$idUtilisateur = isset($_SESSION['idUtilisateur']) ? $_SESSION['idUtilisateur'] : null;
echo "<script>const idProprietaire = " . json_encode($idUtilisateur) . ";</script>";
$idResto = isset($_GET['id']) ? $_GET['id'] : null; // Récupérer l'ID du restaurant à modifier<
echo "<script>const restaurantId = " . json_encode($idResto) . ";</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier article - GFaim</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
        <?php
                include("vues/fonctions/entete.php");
                include("vues/fonctions/fonctions.php");
                afficherMenu($controleur);
            ?>
        </nav>
    </header>
    <section class="modifier" style="background-image: linear-gradient(rgba(0, 0, 0, 0.566),rgba(0, 0, 0, 0.333)), url('images/imageLivreur.jpg');">
        <div class="formModifierResto">
            <h2>Modifier le Restaurant</h2>
            <form id="modifierResto" action="post">
                <input type="hidden" id="editRestoId" />
                <input
                  type="text"
                  id="modifierNom"
                  name="nom"
                  class="form-control my-2"
                  placeholder="Nom du restaurant"
                  required
                />
                <input
                  type="text"
                  id="modifierAdresse"
                  name="adresse"
                  class="form-control my-2"
                  placeholder="Adresse civique"
                  required
                />
                <input
                  type="text"
                  id="modifierPhone"
                  name="phone"
                  class="form-control my-2"
                  placeholder="Numéro de téléphone"
                  required
                />
                <textarea
                  id="modifierDescription"
                  name="description"
                  class="form-control my-2"
                  placeholder="Description"
                  required
                ></textarea>
                <input  style="font-size:17px; padding:7px; margin-top:15px; border:none; width:40%; border-radius:20px" type="submit" value="Modifier">
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

const form = document.getElementById('modifierResto');

if (form) {
    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Empêche la soumission classique du formulaire
        const name = form.querySelector('[name="nom"]').value.trim();
        const adresse = form.querySelector('[name="adresse"]').value.trim();
        const phone = form.querySelector('[name="phone"]').value.trim();
        const description = form.querySelector('[name="description"]').value.trim();

        if (!name || !adresse || !phone || !description) {
            alert("Veuillez remplir tous les champs !");
            return;
        }

        const resto = {
            idProprietaire: idProprietaire,
            nom: name,
            adresse: adresse,
            phone: phone,
            description: description
        };

        if (!confirm("Voulez-vous vraiment modifier ce restaurant ?")) {
            return;
        }

        fetch(`http://localhost:9090/PROJETWEB/api/restaurant/${restaurantId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(resto)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la requête');
            }
            return response.json();
        })
        .then(data => {
            alert('Restaurant Modifier avec succès !');
            console.log('Succès:', data);
            form.reset();
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert("Erreur lors de la modification du restaurant. Veuillez réessayer.");
        });
    });
} else {
    console.error("Formulaire #modifierResto non trouvé !");
}
});
</script>

    </section>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
</body>
</html>