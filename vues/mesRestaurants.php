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
        <h1>Voici vos Restaurants</h1>
        <a class="boutonAjouter"href="?action=ajouterResto">Nouveau Restaurant</a>
        <ul class="liste-commandes">
            <li class="article">
                <a href="?action=voirMonMenu" style="font-size: 24px; font-weight: bold; color: #D2691E; text-transform: uppercase; height: 40px; line-height: 50px; margin-top: 10px;">
                Trois Amigos</a><br>
                <span class="description" style ="margin-top: 20px;">Un restaurant servant les meilleurs plats mexicain au monde du fameux tacos au queso fondido</span><br>
                <a class="boutonModifier" href="?action=modifierResto">Modifier Restaurant</a>
                <button class="boutonSupprimer">Supprimer</button>
            </li>
        </ul>
    </main>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
</body>
</body>
</html>