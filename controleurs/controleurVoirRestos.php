<?php
include_once("controleurs/controleur_classe_abstraite.php");
include_once("modele/DAO/UserDAO.class.php");
include_once("modele/DAO/RestaurantDao.class.php");


class voirRestos extends Controleur
{
    private $tabLesResto;

    public function __construct(){
        parent::__construct();
        $this->tabLesResto = array();
    }
    public function executerAction():string
		{
            $this->tabLesResto = RestaurantDao::findAll();

 
			
			return "lesRestos.php";
	}
    public function getLesRestos():array
        {
            return $this->tabLesResto;
    }
}
?>