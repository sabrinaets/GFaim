<?php

	include_once("controleurs/controleur_classe_abstraite.php");

	class AccueilDefaut extends Controleur  {
		
		public function __construct() {
			
			parent::__construct();
		}
		
		public function executerAction():string
		{
				

			return "index.php";
		}

		
	}	
	
?>