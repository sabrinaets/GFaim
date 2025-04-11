<?php
session_start();
$_SESSION['test'] = "ok";
echo $_SESSION['test'];
	//erreur quand jinclut CommandeDAO, je vais essayer de regler
	include_once("controleurs/controleur_classe_abstraite.php");
	include_once("modele/DAO/commandeDao.class.php");

	class voirCommandesClient extends Controleur  {

		private $tabMesCommandes;
		
		
		public function __construct() {
			
			parent::__construct();
			$this->tabMesCommandes=array();
		}
		


		public function executerAction():string
		{
			$idClient = $_SESSION['idUtilisateur'] ?? null;


            if (!$idClient) {
                die("Erreur : aucun client connecté.");
            }
            else {
               
                $pdo = ConnexionBD::getInstance();
                $this->tabMesCommandes = commandeDAO::getCommandesParClient($pdo, $idClient);
            }

			return "mesCommandes.php";
		}
		

		
		public function getTabMesCommandes()
		{
				return $this->tabMesCommandes;
		}
	}	
	
?>