<?php
if(!isset($_SESSION)) {
    session_start(); // Toujours démarrer la session
}
$idResto = isset($_GET['idResto']) ? $_GET['idResto'] : null; // Récupérer l'ID du restaurant à modifier<
echo "<script>const restaurantId = " . json_encode($idResto) . ";</script>";
$idItem = isset($_GET['id']) ? $_GET['id'] : null; // Récupérer l'ID du restaurant à modifier<
echo "<script>const idItem = " . json_encode($idItem) . ";</script>";
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
        <div class="formModifierArticle">
            <h2>Modifier l'article</h2>
            <form id="modifierArticle" action="post">
                <input type="hidden" id="editProductId" />
                <input
                  type="text"
                  id="modifierNom"
                  name="nom"
                  class="form-control my-2"
                  placeholder="Nom de l'article"
                  required
                />
                <input
                  type="number"
                  id="modifierPrix"
                  name="prix"
                  class="form-control my-2"
                  placeholder="Prix"
                  step="0.01"
                  required
                />
                <input
                  type="text"
                  id="modifierImage"
                  name="image"
                  class="form-control my-2"
                  placeholder="URL de l'image"
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

const form = document.getElementById('modifierArticle');

if (form) {
    form.addEventListener('submit', function (event) {
        event.preventDefault(); 
        const nom = form.querySelector('[name="nom"]').value.trim();
        const prix = form.querySelector('[name="prix"]').value.trim();
        const image = form.querySelector('[name="image"]').value.trim();
        const description = form.querySelector('[name="description"]').value.trim();

        if (!nom || !prix || !image || !description) {
            alert("Veuillez remplir tous les champs !");
            return;
        }

        const article = {
            itemId: idItem,
            idRestaurant: restaurantId,
            nom: nom,
            prix: prix,
            image: image,
            description: description
        };

        if (!confirm("Voulez-vous vraiment modifier ce produit ?")) {
            return;
        }

        fetch(`http://localhost:8001/api/item/${idItem}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(article)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la requête');
            }
            return response.json();
        })
        .then(data => {
            alert('Article modifier avec succès !');
            console.log('Succès:', data);
            form.reset();
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert("Erreur lors de la modification de l'article. Veuillez réessayer.");
        });
    });
} else {
    console.error("Formulaire #modifierarticle non trouvé !");
}
});
</script>    
    </section>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
</body>
</html>