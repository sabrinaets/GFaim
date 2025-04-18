<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - GFaim</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <a id="logo" href='?action=Accueil' title="Gfaim"><img src="images/logo.png" width="100px" alt="accueil"></a>
            <div>
                <a href='?action=seConnecter'>Vous avez déja un compte? <span class="motOrange">Se connecter</span></a>
            </div>
        </nav>
    </header>
    <section class="inscription" style="background-image: linear-gradient(rgba(0, 0, 0, 0.566),rgba(0, 0, 0, 0.333)), url('images/imageLivreur.jpg');">
        <div class="formInscription">
            <h2>Inscription</h2>
            <form id="inscrire"method="post" action="?action=creerCompte">
                
                
                <input name="userName"type="name" required placeholder="Nom d'utilisateur" maxlength=30>
                
                
                <input list="roles" name="role"placeholder="Rôle" required>
                <datalist id="roles">
                  <option value="Client">
                  <option value="Livreur">
                  <option value="Restaurateur">
                  <option value="admin">
                  </datalist>

                  
                <input minlength=6 maxlength=6 name="codepostal"type="codepostal" required placeholder="Code postal (ex. ABC123)">
                
                <input maxlength=12 name="phone"type="phone" required placeholder="Numéro de téléphone: (ex. XXX-XXX-XXXX)">

                
                <input name="email" type="email" required placeholder="Adresse courriel: (ex. nom@gmail.com)">
                
                
                
                <input name="password"type="password" required placeholder="Choisissez votre mot de passe">
                <input  style="font-size:17px; padding:7px; margin-top:15px; border:none; width:40%; border-radius:20px" type="submit" value="M'inscrire">
            </form>
        </div>
    </section>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
</body>
</html>