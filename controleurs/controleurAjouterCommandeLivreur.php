<?php
	include_once("controleurs/controleur_classe_abstraite.php");
	class AjouterCommandeLivreur extends Controleur  {
		// ******************* Constructeur vide
		public function __construct() {
			//appel du constructeur parent
			parent::__construct();
		}
		
		public function executerAction():string
		{	
			return "coursesALivrer.php";
		}



		


		
	}	
	
?>