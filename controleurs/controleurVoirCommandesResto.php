<?php

	include_once("controleurs/controleur_classe_abstraite.php");
	class voirCommandesResto extends Controleur  {
		
		private $tabCommandesResto;
		// ******************* Constructeur vide
		public function __construct() {
			//appel du constructeur parent
			parent::__construct();
			$this->tabCommandesResto = array();
		}
		
		public function executerAction():string
		{
			$idRestaurateur = $_SESSION['idUtilisateur'] ?? null;	
			if (!$idRestaurateur) {
                die("Erreur : aucun restaurant connecté.");
            }
            else {
               
                $pdo = ConnexionBD::getInstance();
                $this->tabCommandesResto = commandeDAO::voirCommandesResto($pdo, $idRestaurateur);
            }

			return "commandeAPreparer.php";
		}

		public function getTabCommandesResto()
		{
				return $this->tabCommandesResto;
		}
	}	
	
?>