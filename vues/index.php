
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFaim - livraison de repas</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <style>
    .carre img{
    margin-right:50px;
    background-image: linear-gradient(black,gray);
    border-radius: 40px;
 


    width: 420px; 
    max-width: 500px;
    min-width: 300px;
    height: 510px;

    min-height: 510px;
    max-height:510;
    
}
</style>
</head>
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
    <main class="main">
        <div class="carre">
            <div class="carretext">
                <h2>Bon. </h2>
                <h1>Rapide.</span></h1>
                <h2>Facile.</h2>
                <p>Votre faim, notre mission : avec GFaim, obtenir des repas délicieux et variés n'a jamais été aussi facile.</p>
                <a href="?action=voirRestos">Commander</a>
            </div>
            <img src="images/imageBurger.jpg" alt="burger">
            
        </div>
        <div class="autresComptes">
            <div class="roles">
                <img src="images/chef.webp" alt="Image cuisine restaurant" width="450px">
                <div>
                <h3>Vous êtes propriétaire?</h3>
                <p>Rejoignez notre réseau de restaurateurs dès maintenant. Avec GFaim, vous
                    êtes entre de bonnes mains. On s'occupe des clients et de la livraison, vous
                    n'avez qu'à en récolter les profits!
                </p>
                <a href="mailto:GFaim@gmail.com?subject=Demande%20de%20compte%20restaurateur">Nous contacter</a>
            </div>
            </div>
            <div class="roles">
                <img src="images/deliveryDriver.jpg" alt="Imagelivreur" width="450px">
                <div>
                <h3>Livrez avec nous!</h3>
                <p>Vous avez un peu de temps libre et vous cherchez un revenu supplémentaire?
                    Être votre propre patron et travailler selon vos disponibilités vous intéresse?
                    Ne cherchez pas plus loin, joignez-vous à notre équipe!
                    </p>
                    <a href="mailto:GFaim@gmail.com?subject=Demande%20de%20compte%20livreur">Nous contacter</a>
                </div>
            </div>
        </div>
        
        <div class="panier hidden">
            <h2>Panier</h2>
            <ul></ul>
        </div>
    </main>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
    <script src="vues/fonctions/fonctions.js">
         
    </script>
    <script>
    var idUtilisateur = <?php echo json_encode($_SESSION['idUtilisateur']); ?>;
         console.log("id utilisateur de index:" +idUtilisateur);
         sessionStorage.setItem('idUtilisateur',idUtilisateur);
         </script>
         <script>
            let idUtilisateur = <?php echo json_encode($_SESSION['idUtilisateur']); ?>;
        </script>

</body>
</html>
