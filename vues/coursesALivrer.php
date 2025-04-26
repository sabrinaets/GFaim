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
     
            ?>
        </ul>
    </main>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
    <script src="vues/fonctions/livreur.js"></script>
    <script>
         const idLivreur = <?php echo $_SESSION['idUtilisateur']; ?>;
         envoyerPositionLivreur(idLivreur);
    </script>
</body>
</body>
</html>