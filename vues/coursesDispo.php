<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - GFaim</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .boutonAccepte{
            background-color:rgba(24, 138, 45, 0.98);
            text-decoration: none;
            height:20px;
            padding:10px 15px;
            border-radius: 20px;
            font-weight: 600;
            color:#fff;

        }
        .boutonAccepte:hover {
    background-color: var(--bleuLogo);
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
        <h1>Commandes disponibles</h1>
        <?php
            $cmdDispo = $controleur->getTabCmdDispo();

            if (empty($cmdDispo)) {
                echo "<h3>Aucune commande en attente.</h3>";
            } else {
                afficherCommandesDispo($cmdDispo);
            }
        ?>
        
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