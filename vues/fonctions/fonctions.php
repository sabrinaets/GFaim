
<?php 
function afficherMenu($controleur)
{
    $menu = "<nav>
        <div>
          ";

    $typeActeur = $controleur->getActeur(); // Obtenir le type d'utilisateur

    if ($typeActeur === "visiteur") {
        $menu .= "<a href='?action=seConnecter'>Se connecter</a>";
    } else {
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['utilisateurConnecte']) && $_SESSION['utilisateurConnecte'] instanceof User) {
            $utilisateurConnecte = $_SESSION['utilisateurConnecte'];
            $nom = htmlspecialchars($utilisateurConnecte->getUserName());
            $menu .= "<li style='color:red'>" . $nom . " connecté </li>";
            if(htmlspecialchars($utilisateurConnecte->getRole()->getRoleName()) === "Admin"){
                $menu .= "<li><a href='?action=gestionApi'>Gestion de l'API</a></li>";
                $menu .= "<li><a href='?action=creerCompte'>Créer compte</a></li>";
            }
            else if(htmlspecialchars($utilisateurConnecte->getRole()->getRoleName()) === "Client"){

            }
        }
        $menu .= "<li><a href='?action=seDeconnecter'>Se déconnecter</a></li>";

    }

    $menu .= "</div>
      </nav>";

    echo $menu;
}
?>