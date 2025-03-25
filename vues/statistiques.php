
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
.carre p{
    margin:0;
    text-align: center;
}
#unstat {
    display: flex;
    flex-direction: column;
    justify-content:center;
    width:30%;
    align-self: center;
    justify-self: center;
    background-color:rgb(168, 165, 165);
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
        <section id="stats">
        <div id="unstat">
            <i class="fa-solid fa-burger"></i>
            <h4>Le poke bowl</h4>
            <p>est votre mets le plus populaire</p>
        </div>
        <div id="unstat">
            <i class="fa-solid fa-laptop"></i>
            <h4>18</h4>
            <p>commandes vous sont assignées</p>
        </div>
        <div id="unstat">
            <i class="fa-solid fa-user-group"></i>
            <h4>20</h4>
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

