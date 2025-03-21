<?php
	include_once("controleurs/controleur_classe_abstraite.php");
	class TerminerCommandeLivreur extends Controleur  {
		
		// ******************* Constructeur vide
		public function __construct() {
			//appel du constructeur parent
			parent::__construct();
		}
		
		public function executerAction():string
		{
            session_start();

			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$restaurant = $_POST["restaurant"];
				$adresse = $_POST["adresse"];
				$details = $_POST["details"];

				if (!empty($_SESSION["commandesALivrer"])) {
					foreach ($_SESSION["commandesALivrer"] as $index => $commande) {
						if ($commande["restaurant"] == $restaurant && 
							$commande["adresse"] == $adresse &&
							$commande["details"] == $details) {
							unset($_SESSION["commandesALivrer"][$index]);
							$_SESSION["commandesALivrer"] = array_values($_SESSION["commandesALivrer"]);
							break;
						}
					}
				}
	
			}

			return "coursesALivrer.php";
		}
	}	
?>