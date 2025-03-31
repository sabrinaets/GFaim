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
        <!--
        <ul class="liste-commandes">
            <li class="livraison">
                <span class="commandeALivrerNomResto">🍉 Watermelon</span><br>
                <span class="adresse">1 Rue du blablabla - Nicolas Bernier</span><br>
                <span class="commandeALivrerDetails">1x Margherita, 1x Coca</span><br>
                <button class="commandeALivrerBoutonAccepte" onclick="window.location.href='coursesALivrer.html'">Terminer</button>
            </li>
            <li class="livraison">
                <span class="commandeALivrerNomResto">🍔 Mc Donald's</span><br>
                <span class="adresse">42 Rue de la Montagne - Arnaud Jean</span><br>
                <span class="commandeALivrerDetails">1x Cheeseburger, 1x Frites</span><br>
                <button class="commandeALivrerBoutonAccepte" onclick="window.location.href='coursesALivrer.html'">Terminer</button>
            </li>
            <li class="livraison">
                <span class="commandeALivrerNomResto">🍣 I am Pho</span><br>
                <span class="adresse">99 boulevard Saint-Michel - Marc Lefevre</span><br>
                <span class="commandeALivrerDetails">8x Sushi saumon, 1x Miso</span><br>
                <button class="commandeALivrerBoutonAccepte" onclick="window.location.href='coursesALivrer.html'">Terminer</button>
            </li>
            <li class="livraison">
                <span class="commandeALivrerNomResto">🍔 Shake Shack</span><br>
                <span class="adresse">4068 Conroy Rd - Arnaud Jean</span><br>
                <span class="commandeALivrerDetails">1x Burger</span><br>
                <button class="commandeALivrerBoutonAccepte" onclick="window.location.href='coursesALivrer.html'">Terminer</button>
            </li>
            <li class="livraison">
                <span class="commandeALivrerNomResto">🍕 Pizzeria Bella</span><br>
                <span class="adresse">100 Je sais pas où - Jean Val-Jean</span><br>
                <span class="commandeALivrerDetails">1x Rien</span><br>
                <button class="commandeALivrerBoutonAccepte" onclick="window.location.href='coursesALivrer.html'">Terminer</button>
            </li>
            <li class="livraison">
                <span class="commandeALivrerNomResto">🫒 Olive's Garden</span><br>
                <span class="adresse">2341 Halleway Rd - Inoussa</span><br>
                <span class="commandeALivrerDetails">2x Lasagne, 1x Jus Pomme</span><br>
                <button class="commandeALivrerBoutonAccepte" onclick="window.location.href='coursesALivrer.html'">Terminer</button>
            </li>
        </ul>
    </main>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
</body>
</body>
</html>