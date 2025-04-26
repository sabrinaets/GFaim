<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - GFaim</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
    .commande a{
        width:60px;
        margin:5px;
        height:20px;
        text-decoration: none;
        background-color: rgba(59, 100, 198, 0.92);
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
        <h1>Commandes en livraison</h1>
        
        <?php
            $lescommandes = $controleur->getTabMesCommandes();


            if (empty($lescommandes)) {
                echo "<h3>Aucune commande n'a été placée.</h3>";
            } else {
                afficherCommandesClient($lescommandes);
            }


        ?>
        <div class="panier hidden"></div>
    </main>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
    <script src="vues/fonctions/fonctions.js"></script>
</body>
</body>
</html>