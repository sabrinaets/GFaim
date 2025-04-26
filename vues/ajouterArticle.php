<?php
if(!isset($_SESSION)) {
    session_start();
}
$idResto = isset($_GET['id']) ? $_GET['id'] : null; 
echo "<script>const restaurantId = " . json_encode($idResto) . ";</script>";
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
        <div class="formAjouterArticle">
            <h2>Ajouter un article</h2>
            <form id="ajouterArticle" action="post">
                <input type="hidden" id="editProductId" />
                <input
                  type="text"
                  id="ajouterNom"
                  name="nom"
                  class="form-control my-2"
                  placeholder="Nom de l'article"
                  required
                />
                <input
                  type="number"
                  id="ajouterPrix"
                  name="prix"
                  class="form-control my-2"
                  placeholder="Prix"
                  step="0.01"
                  required
                />
                <input
                  type="text"
                  id="ajouterImage"
                  name="image"
                  class="form-control my-2"
                  placeholder="URL de l'image"
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

        const form = document.getElementById('ajouterArticle');

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
                    idRestaurant: restaurantId,
                    nom: nom,
                    prix: prix,
                    image: image,
                    description: description
                };

                if (!confirm("Voulez-vous vraiment ajouter ce produit ?")) {
                    return;
                }

                fetch('http://localhost:8001/api/item', {
                    method: 'POST',
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
                    alert('Article ajouté avec succès !');
                    console.log('Succès:', data);
                    form.reset();
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert("Erreur lors de l'ajout de l'article. Veuillez réessayer.");
                });
            });
        } else {
            console.error("Formulaire #ajouterArticle non trouvé !");
        }
    });
</script>
    </section>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
</body>
</html>