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
        <!--<ul id="restaurant-list">

        <li class="carreResto">
            <div class="texteResto">
                <h1 id="resto-nom" class="nomResto" style ="margin: 0; padding: 0">Restaurant l'escondite</h1>
                <h2 id="resto-adresse">1633 Av ducharme</h2>
            </div>
            <a href="?action=voirMenu" style="text-align: center;">Menu</a>
            
        </li>
        <li class="carreResto">
            <div class="texteResto">
                <h1 id="resto-nom" class="nomResto" style ="margin: 0; padding: 0">Restaurant 2</h1>
                <h2 id="resto-adresse">1633 Av ducharme</h2>
            </div>
            <a href="?action=voirMenu" style="text-align: center;">Menu</a>
            
        </li>
        <li class="carreResto">
            <div class="texteResto">
                <h1 id="resto-nom" class="nomResto" style ="margin: 0; padding: 0">Restaurant 3</h1>
                <h2 id="resto-adresse">1633 Av ducharme</h2>
            </div>
            <a href="?action=voirMenu" style="text-align: center;">Menu</a>
            
        </li>
    </ul>
    <div class="panier hidden">
            <h2>Panier</h2>
            <ul></ul>
        </div>
    </ul>-->
    </main>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
    <script src="vues/fonctions/fonctions.js"></script>
</body>
</html>