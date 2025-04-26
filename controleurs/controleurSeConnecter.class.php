<?php
include_once("controleurs/controleur_classe_abstraite.php");
include_once("modele/DAO/UserDAO.class.php");
include_once("modele/monRole.class.php");

class SeConnecter extends Controleur
{
    
    private $tabProduits;

    public function __construct()
    {
        parent::__construct();
        $this->tabProduits = array();
    }

    public function getTabProduits(): array
    {
        return $this->tabProduits;
    }

  
    public function executerAction(): string
    {
        // Vérifier si l'utilisateur est déjà connecté
        if ($this->acteur == "utilisateur") {
            array_push($this->messagesErreur, "Vous êtes déjà connecté.");
            return "index.php";
        }

        // Vérifier si les informations POST sont présentes
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $unUtilisateur = UserDAO::findByEmail($_POST['email']);
            
            // Vérification de l'existence de l'utilisateur
            if ($unUtilisateur == null) {
                header("Location: ?action=seConnecter&message=Aucun utilisateur trouvé.");
                return "connexion.php";
            }
            if ($unUtilisateur->verifyPassword($_POST['password'])){
            // Connexion réussie
                $this->acteur = "utilisateur";
                $_SESSION['utilisateurConnecte'] = $unUtilisateur;
                $_SESSION['idUtilisateur']=$unUtilisateur->getId();

                return "index.php";
            }
            else{
                header("Location: ?action=seConnecter&message=Mot de passe incorrect.");
                return "connexion.php";
            }
           
        }

        if (isset($_GET['message'])) {
            $message = htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8');
            echo "<script>alert('$message');</script>";
        }
        
        return "connexion.php";
    }
}
