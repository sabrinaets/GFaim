<?php

	include_once("controleurs/controleur_classe_abstraite.php");
	class Commande extends Controleur  {
		
		// ******************* Constructeur vide
		public function __construct() {
			//appel du constructeur parent
			parent::__construct();
		}
		
		public function executerAction():string
		{
				
			return "order.php";
		}

		


		
	}	
	
?>