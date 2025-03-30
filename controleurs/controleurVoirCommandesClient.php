<?php
	//erreur quand jinclut CommandeDAO, je vais essayer de regler
	include_once("controleurs/controleur_classe_abstraite.php");


	class voirCommandesClient extends Controleur  {

		private $tabMesCommandes;
		
		// ******************* Constructeur vide
		public function __construct() {
			//appel du constructeur parent
			parent::__construct();
			$this->tabMesCommandes=array();
		}
		


		public function executerAction():string
		{
			$idClient = $_SESSION['idClient'] ?? null;


            if (!$idClient) {
                die("Erreur : aucun client connecté.");
            }
            else {
               
                $pdo = ConnexionBD::getInstance();
                $this->tabMesCommandes = commandeDAO::getCommandesParClient($pdo, $idClient);
            }

			return "mesCommandes.php";
		}
		
	}	
	
?>