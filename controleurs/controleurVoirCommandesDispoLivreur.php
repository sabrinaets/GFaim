<?php

	include_once("controleurs/controleur_classe_abstraite.php");
	include_once("modele/DAO/commandeDao.class.php");
	class VoirCommandesDispoLivreur extends Controleur  {

		private $tabCmdDispo;
		
		
		public function __construct() {
			
			parent::__construct();
			$this->tabCmdDispo=array();
		}
		
		public function executerAction():string
		{
			$pdo = ConnexionBD::getInstance();
			$this->tabCmdDispo=commandeDAO::getCommandesDispo($pdo);	
			return "coursesDispo.php";
		}


		public function getTabCmdDispo()
		{
				return $this->tabCmdDispo;
		}
	}	
	
?>