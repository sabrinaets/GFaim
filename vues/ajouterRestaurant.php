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
                  id="ajouterNom"
                  class="form-control my-2"
                  placeholder="Nom du restaurant"
                  required
                />
                <input
                  type="text"
                  id="ajouterAdresse"
                  class="form-control my-2"
                  placeholder="Adresse civique"
                  required
                />
                <input
                  type="text"
                  id="ajouterPhone"
                  class="form-control my-2"
                  placeholder="Numéro de téléphone"
                  required
                />
                <textarea
                  id="ajouterDescription"
                  class="form-control my-2"
                  placeholder="Description"
                  required
                ></textarea>
                <input  style="font-size:17px; padding:7px; margin-top:15px; border:none; width:40%; border-radius:20px" type="submit" value="Ajouter">
            </form>
        </div>
    </section>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
</body>
</html>