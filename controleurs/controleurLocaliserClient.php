<?php

    include_once("controleurs/controleur_classe_abstraite.php");

    class localiserClient extends Controleur  {
            
        
        public function __construct() {
            
            parent::__construct();
        }
        

        public function executerAction():string
        {        

            return "localiserClient.php";
        }

        
    }	
?>