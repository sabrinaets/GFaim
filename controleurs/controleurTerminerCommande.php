<?php
include_once("controleurs/controleur_classe_abstraite.php");
include_once("modele/DAO/commandeDao.class.php");

class terminerCommande extends Controleur
{
    private $tabCommandesResto;

    public function __construct(){
        parent::__construct();
        $this->tabCommandesResto = array();
    }

    public function executerAction():string
		{
            $pdo = ConnexionBD::getInstance();
			if (isset($_GET['id']))	{
                $id = $_GET['id'];
                $success = commandeDAO::terminerCommandeResto($pdo,$id);
                if (!$success){
                    header("Location: ?action=voirCommandesResto&message=Probleme avec la suppression");
                }
                else{
                    $idRestaurateur = $_SESSION['idUtilisateur'];
			        $this->tabCommandesResto = commandeDAO::voirCommandesResto($pdo,$idRestaurateur);
			        return "commandeAPreparer.php";
                }
            }
			return "commandeAPreparer.php";
		}




    /**
     * Get the value of tabCommandesResto
     */ 
    public function getTabCommandesResto()
    {
        return $this->tabCommandesResto;
    }
} 
?>