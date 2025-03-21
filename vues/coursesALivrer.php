<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - GFaim</title>
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
    <main class="contenu">
        <h1 class="commandeALivrer">Commandes à livrer</h1>
        <ul class="liste-commandes">
            <?php
            if (!empty($_SESSION["commandeALivrer"])) {
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
            }
            ?>
        </ul>
    </main>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
</body>
</body>
</html>