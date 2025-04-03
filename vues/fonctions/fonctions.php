
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
        echo '<span>' . htmlspecialchars($uneCommande['nomRestaurant']) . '</span>';
        echo '<span>' . htmlspecialchars($uneCommande['adresseRestaurant']) . '</span>';
        echo '<span>' . number_format($uneCommande['prixTotal'], 2) . '&thinsp;$</span>';


        // Afficher les items de la commande
        echo '<ul class="items-commande">';
        $items = CommandeItemDao::findAllByCommande($uneCommande['idCommande']);
        foreach ($items as $item) {
            echo '<li style="margin-right:20px">' . htmlspecialchars((string) $item['nomItem']) . ' (x' . htmlspecialchars((string) $item['quantite']) . ')</li>'; //probleme possible ici
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
            echo '<li style="margin-right:20px">' . htmlspecialchars((string) $item['nomItem']) . ' (x' . htmlspecialchars((string) $item['quantite']) . ')</li>'; //probleme possible ici
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
            echo '<li style="margin-right:20px">' . htmlspecialchars((string) $item['nomItem']) . ' (x' . htmlspecialchars((string) $item['quantite']) . ')</li>'; 
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
            echo '<li style="margin-right:20px">' . htmlspecialchars((string) $item['nomItem']) . ' (Quantité: ' . htmlspecialchars((string) $item['quantite']) . ')</li>'; //probleme possible ici
        }
        echo '</ul>';
        echo '<a class="boutonTerminer" href="?action=terminerCommande&id='.htmlspecialchars((string) $uneCommande['idCommande']).'">Terminer</a>';
        echo '</li>';

    }
}

function afficherRestaurants(array $tableau):void{
    echo '<ul id="restaurant-list">';
    foreach ($tableau as $unRestaurant){
        echo '<li class="carreResto">';
        echo '<div class="texteResto">';
        echo '<h1 id="resto-nom" class="nomResto" style ="margin: 0; padding: 0">'. htmlspecialchars($unRestaurant->getNom()).'</h1>';
        echo '<h2 id="resto-adresse" class="adresseResto">'. htmlspecialchars($unRestaurant->getAdresse()).'</h2>';
        echo '</div>';
        echo '<a href="?action=voirMenu&id='.htmlspecialchars((string) $unRestaurant->getIdRestaurant()).'" style="text-align: center;">Menu</a>';
        echo '</li>';
        
    }
    echo '</ul>';
}
function afficherMenuResto(array $tableauItem, Restaurant $resto):void{
    echo '<div class="menuResto">';
    echo '<h1 id="resto-nom">'. htmlspecialchars($resto->getNom()).'</h1>';
    echo '<br>';
    echo '<h2>'. htmlspecialchars(" - Menu - ").'</h2>';
    echo '<div id="menu">';
    foreach ($tableauItem as $unItem){
        echo '<div class="menu-item">';
        echo '<img src="images/imageBurger.jpg" alt="burger" width ="250px" height="250px">';
        echo '<div class="item-info">';
        echo '<h3>'. htmlspecialchars($unItem->getNom()).'</h3>';
        echo '<p>'. htmlspecialchars($unItem->getDescription()).'</p>';
        echo '<p>Prix: '. htmlspecialchars($unItem->getPrix()).'</p>';
        echo '<a onclick="ajouterAuPanier('
        . htmlspecialchars((string) $unItem->getIdItem()) 
        . ', \'' . addslashes(htmlspecialchars((string) $unItem->getNom())) . '\', ' 
        . htmlspecialchars((string) $unItem->getPrix()) . ', ' 
        . htmlspecialchars((string) $unItem->getIdRestaurant())
        . ')" href="#">Ajouter au panier</a>';
   
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';

}
?>
