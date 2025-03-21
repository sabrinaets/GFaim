<?php
	include_once("controleurs/controleur_classe_abstraite.php");
	class AjouterCommandeLivreur extends Controleur  {
		// ******************* Constructeur vide
		public function __construct() {
			//appel du constructeur parent
			parent::__construct();
		}
		
		public function executerAction():string
		{	
			$commande = array();
			
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$commande = [
					"restaurant" => $_POST["restaurant"],
					"adresse" => $_POST["adresse"],
					"details" => $_POST["commande"]
				];
			}

			$_SESSION["commandeALivrer"][] = $commande;

			return "coursesALivrer.php";
		}
	}	
?>