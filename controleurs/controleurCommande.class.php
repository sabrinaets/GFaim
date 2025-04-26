<?php

	include_once("controleurs/controleur_classe_abstraite.php");
	class Commande extends Controleur  {
		
		
		public function __construct() {
			
			parent::__construct();
		}
		
		public function executerAction():string
		{
				
			return "order.php";
		}

		


		
	}	
	
?>