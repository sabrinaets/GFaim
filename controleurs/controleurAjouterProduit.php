<?php
include_once("controleurs/controleur_classe_abstraite.php");
include_once("modele/DAO/UserDAO.class.php");

class ajouterProduit extends Controleur
{
    

    public function __construct(){
        parent::__construct();
        
    }
    public function executerAction():string
		{
				
			return "ajouterArticle.php";
		}
} 
?>