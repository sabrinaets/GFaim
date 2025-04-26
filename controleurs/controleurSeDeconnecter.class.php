<?php

	include_once("controleurs/controleur_classe_abstraite.php");
	include_once("modele/DAO/UserDAO.class.php");

	class SeDeconnecter extends  Controleur {
		
		public function __construct() {
			parent::__construct();
		}
		

		public function executerAction():string {
			
			if ($this->acteur=="visiteur") {
				array_push ($this->messagesErreur,"Vous êtes déjà déconnécté.");
				return "index.php";
			} elseif (isset($_GET['action']) && $_GET['action'] === "seDeconnecter") {
				$this->acteur="visiteur";
				unset($_SESSION['utilisateurConnecte']);
				return "index.php";
			} else {

				return "index.php";				
			}
		}


		
	}	
	
?>