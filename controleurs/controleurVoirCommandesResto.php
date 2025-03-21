<?php

	include_once("controleurs/controleur_classe_abstraite.php");
	class voirCommandesResto extends Controleur  {
		
		// ******************* Constructeur vide
		public function __construct() {
			//appel du constructeur parent
			parent::__construct();
		}
		
		public function executerAction():string
		{
				
			return "commandeAPreparer.php";
		}
	}	
	
?>