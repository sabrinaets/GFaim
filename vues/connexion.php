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
            <a id="logo" href='?action=Accueil' title="Gfaim"><img src="images/logo.png" width="100px" alt="accueil"></a>
            <div>
                <a style="display:block;" href='?action=creerCompte'>Vous n'avez pas encore de compte? <span class="motOrange">Créez-en un!</span></a>
            </div>
        </nav>
    </header>
    <section class="connexion">
        <div class="formConnexion">
            <h2>Connexion</h2>
            <form id="connecter"method="post" action="?action=seConnecter">
                <label for="email" >Adresse courriel:</label>
                <br>
                <input type="email" name="email" required placeholder="nom@gmail.com">
                <br>
                <label for="password">Mot de passe: </label>
                <br>
                <input type="password" name="password"required placeholder="Entrez votre mot de passe">
                <input class="btnSeConnecter" style="font-size:17px; margin-top:40px; border:none; width:40%; border-radius:20px" type="submit" value="Se connecter">
            </form>
        </div>
    </section>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
</body>
</html>