<?php
include_once("controleurs/controleur_classe_abstraite.php");
include_once("modele/DAO/commandeDao.class.php");

class annulerCommande extends Controleur
{
    private $tabMesCommandes;

    public function __construct(){
        parent::__construct();
        
    }
    public function executerAction():string
		{
			$pdo = ConnexionBD::getInstance();
			if (isset($_GET['id']))	{
                $id = $_GET['id'];
                $success = commandeDAO::annulerMaCommande($pdo,$id);
                if (!$success){
                    header("Location: ?action=voirCommandesClient&message=Probleme avec la suppression");
                }
                else{
                    $idClient = $_SESSION['idUtilisateur'];
			        $this->tabMesCommandes = commandeDAO::getCommandesParClient($pdo,$idClient);
			        return "mesCommandes.php";
                }
            }	
			return "mesCommandes.php";
		}

    /**
     * Get the value of tabMesCommandes
     */ 
    public function getTabMesCommandes()
    {
        return $this->tabMesCommandes;
    }
} 
?>