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
        <h1>Commandes disponibles</h1>
        <?php
            $cmdDispo = $controleur->getTabCmdDispo();

            if (empty($cmdDispo)) {
                echo "<h3>Aucune commande en attente.</h3>";
            } else {
                afficherCommandesDispo($cmdDispo);
            }
        ?>
        <!--
        <ul class="liste-commandes">
        <li class="commande">
            <span class="restaurant">🍕 Pizzeria Bella</span><br>
            <span class="adresse">12 rue de Paris - Jean Dupont</span><br>
            <span class="commande-details">1x Margherita, 1x Coca</span><br>
            <form action="ajouterCommandeLivreur.php" method="post">
                <input type="hidden" name="restaurant" value="Pizzeria Bella">
                <input type="hidden" name="adresse" value="12 rue de Paris - Jean Dupont">
                <input type="hidden" name="commande" value="1x Margherita, 1x Coca">
                <a href="?action=ajouterCommandeLivreur"class="boutonAccepte" type="submit">Accepter</a>
            </form>
        </li>
        </ul>
        -->
    </main>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
</body>
</body>
</html>