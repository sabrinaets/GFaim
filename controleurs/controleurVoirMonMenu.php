<?php
include_once("controleurs/controleur_classe_abstraite.php");
include_once("modele/DAO/UserDAO.class.php");
include_once("modele/DAO/itemDao.class.php");

class voirMonMenu extends Controleur
{
    private $tabMesItems;

    public function __construct(){
        parent::__construct();
        $this->tabMesItems = array();
    }
    public function executerAction():string
		{
    $this->tabMesItems = ItemDao::findAllByResto($_GET['id']);
				
			return "modifierMenu.php";
		}
    public function getMesItems():array
        {
            return $this->tabMesItems;
    }
} 
?>