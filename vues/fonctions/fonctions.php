
<?php 
function afficherMenu($controleur)
{
    $menu = "
        <div>
          ";

    $typeActeur = $controleur->getActeur(); // Obtenir le type d'utilisateur

    if ($typeActeur === "visiteur") {
        $menu .= "<a href='?action=seConnecter'>Se connecter</a>";
        $menu .= "<a href='?action=creerCompte'>Créer un compte</a>";
    } else {
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['utilisateurConnecte']) && $_SESSION['utilisateurConnecte'] instanceof User) {
            $utilisateurConnecte = $_SESSION['utilisateurConnecte'];
            $nom = htmlspecialchars($utilisateurConnecte->getUserName());
            $menu .= "<span style='color:white'>" . $nom . " connecté </span>";
            if(htmlspecialchars($utilisateurConnecte->getRole()->getRoleName()) === "Admin"){
                $menu .= "<a href='?action=gestionApi'>Gestion de l'API</a>";
                $menu .= "<a href='?action=creerCompte'>Créer compte</a>";
                
            }
            else if(htmlspecialchars($utilisateurConnecte->getRole()->getRoleName()) === "Client"){
                $menu .= "<a href='?action=voirCommandesClient'>Voir mes commandes</a>";
                $menu .= "<a href='?action=voirPanier'>panier</a>"; //icone panier
            }
            else if(htmlspecialchars($utilisateurConnecte->getRole()->getRoleName()) === "Livreur"){
                $menu .= "<a href='?action=voirCommandesDispoLivreur'>Commandes disponibles</a>";
                $menu .= "<a href='?action=voirCommandeALivrerLivreur'>Commandes à livrer</a>";
            }
            else if(htmlspecialchars($utilisateurConnecte->getRole()->getRoleName()) === "Restaurant"){
                $menu .= "<a href='?action=voirStats'>Voir mes statistiques</a>";
                $menu .= "<a href='?action=voirCommandesResto'>Voir mes commandes</a>"; 
            }
        }
        $menu .= "<a href='?action=seDeconnecter'>Se déconnecter</a>";

    }

    $menu .= "</div>
     ";

    echo $menu;
}
?>