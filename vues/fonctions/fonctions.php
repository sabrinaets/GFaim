
<?php 
require_once("modele/DAO/CommandeItemDao.php");

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
                $menu .= "<a id='toggle-panier'>Panier</a>"; //icone panier
                $menu .= "<a href='?action=voirCommandesClient'>Voir mes commandes</a>";
            }
            else if(htmlspecialchars($utilisateurConnecte->getRole()->getRoleName()) === "Livreur"){
                $menu .= "<a href='?action=voirCommandesDispoLivreur'>Commandes disponibles</a>";
                $menu .= "<a href='?action=voirCommandeALivrerLivreur'>Commandes à livrer</a>";
            }
            else if(htmlspecialchars($utilisateurConnecte->getRole()->getRoleName()) === "Restaurant"){
                $menu .= "<a href='?action=voirStats'>Statistiques</a>";
                $menu .= "<a href='?action=voirCommandesResto'>Voir mes commandes</a>"; 
                $menu .= "<a href='?action=voirMesRestos'>Voir mes restaurants</a>"; 
            }
        }
        $menu .= "<a href='?action=seDeconnecter'>Se déconnecter</a>";

    }

    $menu .= "</div>
     ";

    echo $menu;
}

function afficherCommandesClient(array $tableau): void {
   
    echo '<ul class="liste-commandes-client">';
    foreach ($tableau as $uneCommande) {
        echo '<li class="commande">';    
        echo '<span>Restaurant : ' . htmlspecialchars($uneCommande['nomRestaurant']) . '</span>';
        echo '<span>Adresse : ' . htmlspecialchars($uneCommande['adresseRestaurant']) . '</span>';
        echo '<p class="price"><small>Prix</small> ' . number_format($uneCommande['prixTotal'], 2) . '&thinsp;$</p>';


        // Afficher les items de la commande
        echo '<ul class="items-commande">';
        $items = CommandeItemDao::findAllByCommande($uneCommande['idCommande']);
        foreach ($items as $item) {
            echo '<li>' . htmlspecialchars($item->getNom()) . ' (Quantité: ' . htmlspecialchars($item->getQuantite()) . ')</li>';
        }
        echo '</ul>';


        echo '<a class="bouttonscommandes" href="?action=localiser&id=' . htmlspecialchars((string) $uneCommande['idCommande']) . '">Localiser</a>';
        echo '<a class="bouttonscommandes" href="?action=annulerCommande&id=' . htmlspecialchars((string) $uneCommande['idCommande']) . '">Annuler</a>';
        echo '</li>';
    }
    echo '</ul>';



//pas sure si cest necessaire?
// Injecter les produits sous forme de JSON
/*
echo '<script id="php-products" type="application/json">';
echo json_encode(array_map(fn($c) => [
    'id' => $c->getIdCommande(),
    'client' => $c->getIdClient(),
    'restaurant' => $c->getIdRestaurant(),
    'livreur' => $c->getIdLivreur(),
    'prix' => $c->getPrixTotal(),
    'statut'=>$c -> getIdStatut(),
], $tableau));
echo '</script>';*/
}

function afficherCommandesDispo(array $tableau):void{
    echo '<ul class="liste-commandes">';
    foreach ($tableau as $uneCommande){
        echo '<li class="commande">';
        echo '<span class="restaurant">' . htmlspecialchars($uneCommande['nomRestaurant']).'</span>';
        echo '<span class="adresse">'. htmlspecialchars($uneCommande['adresseClient']).' - '. htmlspecialchars($uneCommande['nomClient']).'</span>';
    
        // Afficher les items de la commande
        echo '<ul class="commande-details">';
        $items = CommandeItemDao::findAllByCommande($uneCommande['idCommande']);
        foreach ($items as $item) {
            echo '<li>' . htmlspecialchars($item->getNom()) . ' (Quantité: ' . htmlspecialchars($item->getQuantite()) . ')</li>'; //probleme possible ici
        }
        echo '</ul>';
    
        echo '<a class="boutonAccepte" href="?action=ajouterCommandeLivreur&id='.htmlspecialchars((string) $uneCommande['idCommande']).'">Accepter</a>';
        echo '</li>';
    }
    echo '</ul>';
}

function afficherCommandesALivrer(array $tableau):void{
    echo '<ul class="liste-commandes">';
    foreach ($tableau as $uneCommande){
        echo '<li class="commande">';
        echo '<span class="restaurant">' . htmlspecialchars($uneCommande['nomRestaurant']).'</span>';
        echo '<span class="adresse">'. htmlspecialchars($uneCommande['adresseClient']).' - '. htmlspecialchars($uneCommande['nomClient']).'</span>';
    
        // Afficher les items de la commande
        echo '<ul class="commande-details">';
        $items = CommandeItemDao::findAllByCommande($uneCommande['idCommande']);
        foreach ($items as $item) {
            echo '<li>' . htmlspecialchars($item->getNom()) . ' (Quantité: ' . htmlspecialchars($item->getQuantite()) . ')</li>'; //probleme possible ici
        }
        echo '</ul>';
        echo '<a class="boutonAnnuler" href="?action=annulerCommandeLivreur&id='.htmlspecialchars((string) $uneCommande['idCommande']).'">Annuler</a>';
        echo '</li>';

    }
}
function afficherCommandesResto(array $tableau):void{
    echo '<ul class="liste-commandes">';
    foreach ($tableau as $uneCommande){
        echo '<li class="livraison">';
        echo '<span class="commandeALivrerNomResto">' . htmlspecialchars($uneCommande['nomRestaurant']).'</span>';
        echo '<span class="adresse">'. htmlspecialchars($uneCommande['adresseClient']).' - '. htmlspecialchars($uneCommande['nomClient']).'</span>';
    
        // Afficher les items de la commande
        echo '<ul class="commandeALivrerDetails">';
        $items = CommandeItemDao::findAllByCommande($uneCommande['idCommande']);
        foreach ($items as $item) {
            echo '<li>' . htmlspecialchars($item->getNom()) . ' (Quantité: ' . htmlspecialchars($item->getQuantite()) . ')</li>'; //probleme possible ici
        }
        echo '</ul>';
        echo '<a class="boutonTerminer" href="?action=terminerCommande&id='.htmlspecialchars((string) $uneCommande['idCommande']).'">Terminer</a>';
        echo '</li>';

    }
}

?>