<?php

	include_once("controleurs/controleur_classe_abstraite.php");

	class Confirmation extends Controleur  {
		
		
		public function __construct() {
			
			parent::__construct();
		}
		


		public function executerAction():string
		{
		
			return "confirmation.php";
		}

		


		
	}	
	
?>