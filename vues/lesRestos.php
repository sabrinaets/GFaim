<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFaim - livraison de repas</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
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

    <main class="main">
        <?php
        if(empty($controleur->getLesRestos()))
        {
            echo "<h1>Aucun restaurant trouvé</h1>";
        }
        else{
            afficherRestaurants($controleur->getLesRestos()); // Affiche la liste des restaurants
        }
        ?>
    <div class="panier hidden"></div>
    </main>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
    <script src="vues/fonctions/fonctions.js"></script>

</body>
</html>