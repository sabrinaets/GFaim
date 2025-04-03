<?php
include_once("controleurs/controleur_classe_abstraite.php");
include_once("modele/DAO/UserDAO.class.php");
include_once("modele/DAO/itemDao.class.php");
include_once("modele/DAO/RestaurantDao.class.php");
include_once("modele/Restaurant.class.php");

class voirMenu extends Controleur
{
    private $tableLesItems;
    private $resto;

    public function __construct(){
        parent::__construct();
        $this->tableLesItems = array();
        $this->resto = RestaurantDao::findById($_GET['id']);
    }
    public function executerAction():string {
            $this->tableLesItems = ItemDao::findAllByResto($_GET['id']);
            $this->resto = RestaurantDao::findById($_GET['id']);
				
			return "menuResto.php";
	}
    public function getLesItems():array
        {
            return $this->tableLesItems;
    }
    public function getResto():Restaurant
        {
            return $this->resto;
    }
} 
?>