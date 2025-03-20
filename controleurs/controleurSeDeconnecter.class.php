<?php

	include_once("controleurs/controleur_classe_abstraite.php");
	include_once("modele/DAO/UserDAO.class.php");

	class SeDeconnecter extends  Controleur {
		
		// ******************* Constructeur vide
		public function __construct() {
			parent::__construct();
		}
		

		// ******************* Méthode exécuter action
		public function executerAction():string {
			//----------------------------- VÉRIFIER LA VALIDITÉ DE LA SESSION  -----------
			if ($this->acteur=="visiteur") {
				array_push ($this->messagesErreur,"Vous êtes déjà déconnécté.");
				return "index.php";
			} elseif (ISSET($_POST['deconnexion'])) {
				$this->acteur="visiteur";
				unset($_SESSION['utilisateurConnecte']);
				return "index.php";
			} else {
				return "deconnexion.php";				
			}
		}


		
	}	
	
?>