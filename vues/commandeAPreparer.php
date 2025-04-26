<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - GFaim</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .boutonTerminer{
    background-color: rgb(87, 173, 244);
    padding:10px 15px;
    border-radius: 25px;
    text-decoration: none;
    color:#fff;
        }
    .boutonTerminer:hover{
        background-color: rgb(87, 147, 244);
    }

    </style>
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
    <main class="contenu">
        <h1 class="commandeALivrer">Commandes à préparer</h1>
        <?php
            $cmdResto = $controleur->getTabCommandesResto();


            if (empty($cmdResto)) {
                echo "<h3>Aucune commande n'a été placée.</h3>";
            } else {
                afficherCommandesResto($cmdResto);
            }
        ?>
        
    </main>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
</body>
</body>
</html>