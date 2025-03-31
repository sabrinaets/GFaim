<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - GFaim</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .boutonAnnuler{
            background-color:rgba(24, 23, 23, 0.91);
            text-decoration: none;
            height:20px;
            padding:15px 20px;
            color:#fff;
            font-weight: 600;
            border-radius: 20px;
            width:85px;
        }
        .boutonAnnuler:hover {
    background-color: rgba(235, 9, 9, 0.91);
    transform: scale(1.05);
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
        <h1 class="commandeALivrer">Commandes à livrer</h1>
        <ul class="liste-commandes">
            <?php
            
            $cmdALivrer = $controleur->getTabCmdLivrer();

            if (empty($cmdALivrer)) {
                echo "<h3>Aucune commande a livrer.</h3>";
            } else {
                afficherCommandesALivrer($cmdALivrer);
            }
            
            /*if (!empty($_SESSION["commandeALivrer"])) {
                foreach ($_SESSION["commandeALivrer"] as $commande) {
                    echo "<li class='livraison'>
                            <span class='commandeALivrerNomResto'>🍽️ {$commande['restaurant']}</span><br>
                            <span class='adresse'>{$commande['adresse']}</span><br>
                            <span class='commandeALivrerDetails'>{$commande['details']}</span><br>
                            <form action='terminerCommande.php' method='post'>
                                <input type='hidden' name='restaurant' value='{$commande['restaurant']}'>
                                <input type='hidden' name='adresse' value='{$commande['adresse']}'>
                                <input type='hidden' name='details' value='{$commande['details']}'>
                                <button class='commandeALivrerBoutonAccepte' type='submit'>Terminer</button>
                            </form>
                          </li>";
                }
            } else {
                echo "<p>Aucune commande en attente</p>";
            }*/
            ?>
        </ul>
    </main>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
</body>
</body>
</html>