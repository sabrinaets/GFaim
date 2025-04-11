<?php

if (isset($_POST['restaurant'])) {
    $_SESSION['idRestoSelectionne'] = $_POST['restaurant'];
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFaim - statistiques</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<style>
    
#stats{
    display:flex;
    flex-direction: row;
    width:100%;
    height:80%

}    
.carre{
    margin:0;
    display: block !important; 
}
#unstat {
    display: flex;
    flex-direction: column;
    justify-content:center;
    width:30%;
    align-self: center;
    justify-self: center;
    background-color:rgba(213, 208, 208, 0.48);
    margin:20px;
    border-radius: 40px;
    text-align: center;
    height:60%;

}
#unstat i{
    display:block;
    font-size:30px;
    padding:15px 10px;
    border-radius: 10px;
    width:20%;
    color: rgb(248, 136, 9);
    background-color: white;
    text-align: center;
    justify-self: center;
    margin: 0 auto;
}
#unstat h4{
    margin-top:10px;
    font-size:25px;
}
#listeResto{
    margin-top: 40px;
    margin-left: 30px;
    width:300px;
    height:40px;
    border-radius: 20px;
    border: 1px solid black;
    padding:0px 10px;
}
h3{
    margin:30px 0px 0px 20px;
}
</style>
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

            <h2>Quelques statistiques</h2>
            
            <form method="post" action="">
            
                  <?php 
                    
                    restosDunProprio()
                  ?>
                <button type="submit" style="font-size:17px; padding:12px; margin-top:15px; border:none; border-radius:20px">
                     <i class="fa-solid fa-magnifying-glass"></i>
                </button>

            </form>


        <section id="stats">
        <div id="unstat">
            <i class="fa-solid fa-burger"></i>
            <?php 
            $pdo = ConnexionBD::getInstance();
            echo '<h4>'.commandeDAO::itemPlusPopulaire($pdo,$_SESSION['idRestoSelectionne'])??'Selectionnez un restaurant'.'</h4>'
            ?>
            <p>est votre mets le plus populaire</p>
        </div>
        <div id="unstat">
            <i class="fa-solid fa-laptop"></i>
            <?php 
            $pdo = ConnexionBD::getInstance();
            echo '<h4>'.commandeDAO::commandesParResto($pdo,$_SESSION['idRestoSelectionne'])??'Selectionnez un restaurant'.'</h4>'
            ?>
            <p>commandes vous sont assignées</p>
        </div>
        <div id="unstat">
            <i class="fa-solid fa-user-group"></i>
            <?php 
            $pdo = ConnexionBD::getInstance();
            echo '<h4>'.commandeDAO::clientsParResto($pdo,$_SESSION['idRestoSelectionne'])??'Selectionnez un restaurant'.'</h4>'
            ?>
            <p>clients font affaire avec vous</p>
        </div>
        </section>
        </div>
     

    </main>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
    
</body>
</html>

