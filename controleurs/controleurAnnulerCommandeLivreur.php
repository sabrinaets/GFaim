<?php
include_once("controleurs/controleur_classe_abstraite.php");
include_once("modele/DAO/commandeDao.class.php");

class annulerCommandeLivreur extends Controleur
{
    private $tabCmdLivrer;

    public function __construct(){
        parent::__construct();
        $this->tabCmdLivrer = array();
    }

    public function executerAction():string
		{
            $pdo = ConnexionBD::getInstance();
			if (isset($_GET['id']))	{
                $id = $_GET['id'];
                $success = commandeDAO::annulerCommandeLivreur($pdo,$id);
                if (!$success){
                    header("Location: ?action=voirCommandeALivrerLivreur&message=Probleme avec la suppression");
                }
                else{
                    $idLivreur = $_SESSION['idUtilisateur'];
			        $this->tabCmdLivrer = commandeDAO::voirCommandesLivrer($pdo,$idLivreur);
			        return "coursesALivrer.php";
                }
            }
			return "coursesALivrer.php";
		}


    public function getTabCmdLivrer()
    {
        return $this->tabCmdLivrer;
    }
} 
?>