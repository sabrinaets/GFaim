<?php
	include_once("controleurs/controleur_classe_abstraite.php");
	class AjouterCommandeLivreur extends Controleur  {

		private $tabCmdLivrer;
		
		public function __construct() {
			
			parent::__construct();
			$this->tabCmdLivrer=array();
		}
		
		public function executerAction():string
		{	

			$pdo = ConnexionBD::getInstance();
			$idLivreur = $_SESSION['idUtilisateur'];

			if (isset($_GET['action']) && $_GET['action'] === 'ajouterCommandeLivreur' && isset($_GET['id'])) {
				$idCommande = intval($_GET['id']); 

				commandeDAO::updateCommandeAcceptee($pdo,$idCommande,$idLivreur); // on update la commande.

				
			
		}
			$this->tabCmdLivrer = commandeDAO::voirCommandesLivrer($pdo,$idLivreur);
			return "coursesALivrer.php";
		}


		public function getTabCmdLivrer()
		{
				return $this->tabCmdLivrer;
		}
	}	
?>