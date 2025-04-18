<?php
include_once("controleurs/controleur_classe_abstraite.php");
include_once("modele/DAO/commandeDao.class.php");

class itineraireCommande extends Controleur
{
    private $commandeAVoir;

    public function __construct(){
        parent::__construct();
        
    }
    public function executerAction():string
		{
            if (isset($_GET['id'])){
                $this->commandeAVoir = CommandeDAO::findById($_GET['id']);
            }
			
			return "itineraireLivreur.php";
		}


    public function getCommandeAVoir()
    {
        return $this->commandeAVoir;
    }
} 
?>