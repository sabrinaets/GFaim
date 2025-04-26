<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFaim - livraison de repas</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
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

    <main class="main" id="main-menu">
        
        <div class="panier hidden">
     
        </div>

        <div class="carreMenu">
            <?php
                if(empty($controleur->getLesItems())) {
                    echo "<h1>Aucun Produits trouvé</h1>";
                } else {
                    afficherMenuResto($controleur->getLesItems(), $controleur->getResto()); 
                }
            ?>
    </div>

    </main>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
    <script src="vues/fonctions/fonctions.js" defer ></script>
    <script>
    var idUtilisateur = <?php echo json_encode($_SESSION['idUtilisateur']); ?>;
         console.log("id utilisateur de menuResto:" +idUtilisateur);
         sessionStorage.setItem('idUtilisateur',idUtilisateur);
         </script>
    </script>

    
</body>
</html>