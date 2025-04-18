<?php
if(!isset($_SESSION)) {
    session_start(); // Toujours démarrer la session
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter article - GFaim</title>
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
    <section class="ajouter" style="background-image: linear-gradient(rgba(0, 0, 0, 0.566),rgba(0, 0, 0, 0.333)), url('images/imageLivreur.jpg');">
        <div class="formAjouterResto">
            <h2>Nouveau Restaurant</h2>
            <form id="ajouterResto" action="post">
                <input type="hidden" id="editRestoId" />
                <input
                  type="text"
                  id="ajouteridProprietaire"
                  name="idProprietaire"
                  class="form-control my-2"
                  placeholder="id du propriétaire"
                  required
                />
                <input
                  type="text"
                  id="ajouterNom"
                  name="name"
                  class="form-control my-2"
                  placeholder="Nom du restaurant"
                  required
                />
                <input
                  type="text"
                  id="ajouterAdresse"
                  name="adresse"
                  class="form-control my-2"
                  placeholder="Adresse civique"
                  required
                />
                <input
                  type="text"
                  id="ajouterPhone"
                  name="phone"
                  class="form-control my-2"
                  placeholder="Numéro de téléphone"
                  required
                />
                <textarea
                  id="ajouterDescription"
                  name="description"
                  class="form-control my-2"
                  placeholder="Description"
                  required
                ></textarea>
                <input  style="font-size:17px; padding:7px; margin-top:15px; border:none; width:40%; border-radius:20px" type="submit" value="Ajouter">
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
    document.addEventListener("DOMContentLoaded", function () {

        const form = document.getElementById('ajouterResto');

        if (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Empêche la soumission classique du formulaire
                const idProprietaire = form.querySelector('[name="idProprietaire"]').value.trim();
                const name = form.querySelector('[name="name"]').value.trim();
                const adresse = form.querySelector('[name="adresse"]').value.trim();
                const phone = form.querySelector('[name="phone"]').value.trim();
                const description = form.querySelector('[name="description"]').value.trim();
                

                if (!idProprietaire|| !name || !adresse || !phone || !description) {
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

                if (!confirm("Voulez-vous vraiment ajouter ce restaurant ?")) {
                    return;
                }

                fetch('http://localhost:8001/api/restaurant', {
                    method: 'POST',
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
                    alert('Restaurant ajouté avec succès !');
                    console.log('Succès:', data);
                    form.reset();
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert("Erreur lors de l'ajout du restaurant. Veuillez réessayer.");
                });
            });
        } else {
            console.error("Formulaire #ajouterResto non trouvé !");
        }
    });
</script>

    </section>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
</body>
</html>