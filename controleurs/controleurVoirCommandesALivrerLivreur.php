<?php
	include_once("controleurs/controleur_classe_abstraite.php");

	class VoirCommandesALivrerLivreur extends Controleur  {
		
		private $tabCmdLivrer;
		
		public function __construct() {
			$this->tabCmdLivrer=array();
			parent::__construct();
		}
		


		public function executerAction():string
		{
			$pdo = ConnexionBD::getInstance();
			
			if (!isset($_SESSION['idUtilisateur'])) {
				die("Erreur : idUtilisateur non défini en session !");
			}
			
			$idLivreur = $_SESSION['idUtilisateur'];
			$this->tabCmdLivrer = commandeDAO::voirCommandesLivrer($pdo,$idLivreur);
			return "coursesALivrer.php";
			
		}
		
		public function getTabCmdLivrer()
		{
				return $this->tabCmdLivrer;
		}
	}
	
	
?>