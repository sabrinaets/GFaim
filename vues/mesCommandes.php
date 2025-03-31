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
        height:20px;
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
        <!--
            <ul class="liste-commandes-client">
            <li class="commande">
                <span class="restaurant">🍕 Pizzeria Bella<br><span class="adresse">12 rue de Paris - Jean Dupont</span></span><br>
                <span class="nom-livreur">Jeremy Yameogo</span><br>
                <span class="commande-details">1x Margherita, 1x Coca</span><br>
                <a href="?action=localiser"class="bouttonscommandes">Localiser</a>
                <a class="bouttonscommandes" style="margin-left: 10px;background-color: rgb(190, 11, 11);">Annuler</a>
            </li>
            <li class="commande">
                <span class="restaurant">🍕 Pizzeria Bella<br><span class="adresse">12 rue de Paris - Jean Dupont</span></span><br>
                <span class="nom-livreur">Jeremy Yameogo</span><br>
                <span class="commande-details">1x Margherita, 1x Coca</span><br>
                <a href="?action=localiser"class="bouttonscommandes">Localiser</a>
                <a class="bouttonscommandes" style="margin-left: 10px;background-color: rgb(190, 11, 11);">Annuler</a>
            </li>
            <li class="commande">
                <span class="restaurant">🍕 Pizzeria Bella<br><span class="adresse">12 rue de Paris - Jean Dupont</span></span><br>
                <span class="nom-livreur">Jeremy Yameogo</span><br>
                <span class="commande-details">1x Margherita, 1x Coca</span><br>
                <a href="?action=localiser" class="bouttonscommandes">Localiser</a>
                <a class="bouttonscommandes" style="margin-left: 10px;background-color: rgb(190, 11, 11);">Annuler</a>
            </li>
            
        </ul>
        -->
    </main>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
    <script src="vues/fonctions/fonctions.js"></script>
</body>
</body>
</html>