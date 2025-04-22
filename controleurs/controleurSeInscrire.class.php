<?php

include_once("controleurs/controleur_classe_abstraite.php");
include_once("modele/DAO/UserDAO.class.php");
include_once("modele/monRole.class.php");
include_once("modele/monUser.class.php");


class SeInscrire extends Controleur
{
    // ******************* Attributs
    private $tabProduits;

    // ******************* Constructeur vide
    public function __construct()
    {
        parent::__construct();
        $this->tabProduits = array();
    }

    // ******************* Accesseurs
    public function getTabProduits(): array
    {
        return $this->tabProduits;
    }

    // Méthode pour vérifier si l'utilisateur est admin
  

    // ******************* Méthode executerAction
    public function executerAction(): string
    {
        $idRole=2;
        // Vérifiez si le formulaire de création de compte est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["userName"])) {
            // Déterminer le rôle en fonction des permissions
            if (isset($_SESSION['utilisateurConnecte'])) {
                if($_SESSION['utilisateurConnecte']->getRole()->getId() == 1){
                // Si l'utilisateur est admin, utiliser le rôle fourni dans le formulaire
                switch($_POST['role']){
                    case "Livreur":
                        $idRole = 4;
                        break;
                    case "Restaurateur":
                        $idRole=3;
                        break;
                    case "Client":
                        $idRole=2;
                        break;
                    case "admin":    
                        $idRole=1;
                        break;
                    }
                }
                $role = new monRole($idRole, $_POST['role']);
            }
             else {
                // Sinon, attribuer le rôle "Client" par défaut
                $role = new monRole(2, "Client");
            }

            // Création de l'utilisateur
            $nouvelUtilisateur = new monUser(
                null,
                $_POST['userName'],
                $role,
                $_POST['codepostal'],
                $_POST['phone'],
                $_POST['email'],
                $_POST['password'],
                null,
                null,

            );

            // Hacher le mot de passe avant l'insertion
            $nouvelUtilisateur->hashPassword();

            // Enregistrer l'utilisateur dans la base de données
            $resultat = UserDAO::save($nouvelUtilisateur);

            // Rediriger en fonction du résultat
            if ($resultat) {
                header("Location: ?action=seConnecter&message=Compte créé avec succès !");
                exit;
            } else {
                $this->messagesErreur[] = "Impossible de créer le compte.";
            }
        }

        // Retourner la vue pour la page de création de compte
        return "inscription.php";
    }
}
