<?php
include_once "controleurs/controleurManufacture.class.php";

if(!ISSET($_GET['action'])){
    // on reste à la page d'accueil
 $action="";

}else{
// Sinon on recupere l’action indiqué à accomplir
$action = $_GET['action'];
}

$controleur = ManufactureControleur::creerControleur($action);
//qui contient maintenant des données qui peuvent être utilisées par la vue.
	
	
	// Executer l'action et obtenir le nom de la vue
   $nomVue = $controleur->executerAction();
	
	// inclure la bonne vue
	include_once("vues/". $nomVue)
?>