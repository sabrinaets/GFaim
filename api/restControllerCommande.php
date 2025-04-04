<?php
// Inclusion des classes nécessaires pour la gestion des produits
include_once("../modele/DAO/commandeDao.class.php");
include_once("../modele/commande.class.php");
use Modele\Commande;
// DÉFINIR LES EN-TÊTES HTTP REQUIS POUR LES RÉPONSES JSON
header("Access-Control-Allow-Origin: *"); // pour autoriser les requêtes externes.
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); //pour spécifier les méthodes HTTP acceptées.
header("Access-Control-Allow-Headers: Content-Type, Authorization"); //  pour permettre l’envoi de données JSON.
header("Content-Type: application/json"); // pour spécifier le type json
// FIN DES AJOUTS EN-TÊTES HTTP

class RestControllerCommande {
    //B. AJOUTER DES PROPRIÉTÉS DE LA CLASSE
    private $requestMethod;
    private $idCommande;

    public function __construct($requestMethod, $idCommande) {
        $this->requestMethod = $requestMethod;
        
        if (empty($idCommande)) {
            $this->idCommande = null;
        } else {
            $this->idCommande = $idCommande;
        }
    }
    //FIN DE B. AJOUTER DES PROPRIÉTÉS DE LA CLASSE

    // Vérification de la validité des données du produit
    private function validateCommande($data) {
        return !empty($data['idClient']) && 
               !empty($data['idRestaurant']) && 
               !empty($data['idStatut']) &&
                isset($data['prixTotal']) && is_numeric($data['prixTotal']) && $data['prixTotal'] > 0;
    }

    // Génération des réponses HTTP standardisées
    private function responseJson($statusCode, $data) {
        return [
            'status_code_header' => "HTTP/1.1 $statusCode " . $this->getStatusMessage($statusCode),
            'body' => json_encode($data)
        ];
    }

    // Réponse 404 : Ressource non trouvée
    private function notFoundResponse() {
        return $this->responseJson(404, ["message" => "Resource not found"]);
    }

    // Réponse 422 : Données invalides
    private function unprocessableEntityResponse() {
        return $this->responseJson(422, ["message" => "Invalid input"]);
    }

    // Réponse 500 : Erreur serveur
    private function serverErrorResponse() {
        return $this->responseJson(500, ["message" => "Internal server error"]);
    }

    // Correspondance des codes d'état HTTP avec leurs messages
    private function getStatusMessage($code) {
        $statusMessages = [
            200 => "OK",
            201 => "Created",
            404 => "Not Found",
            422 => "Unprocessable Entity",
            500 => "Internal Server Error"
        ];
        return $statusMessages[$code] ?? "Unknown Status";
    }

    //C. IMPLÉMENTER LA MÉTHODE processRequest()
    public function processRequest() {
        if ($this->requestMethod === 'GET') {
            if ($this->idCommande !== null) {
                $reponse =  $this->getCommande($this->idCommande);
            } else {
                $reponse = $this->getAllCommandes();
            }
        }
        else if ($this->requestMethod === 'POST') {
            $reponse = $this->createCommandeFromRequest();
        }

        else if ($this->requestMethod === 'PUT' && $this->idCommande !== null) {
            $reponse = $this->updateCommandeFromRequest($this->idCommande);
        }

        else if ($this->requestMethod === 'DELETE' && $this->idCommande !== null) {
            $reponse = $this->deleteCommandeFromRequest($this->idCommande);
        }
        else{
            $reponse = $this->notFoundResponse();
        }
        header($reponse['status_code_header']);
        if ($reponse['body']) {
            echo $reponse['body'];
        }
    }
    //FIN DE C. IMPLÉMENTER LA MÉTHODE processRequest()

    //D. IMPLÉMENTER LES OPÉRATIONS CRUD
    private function getAllCommandes() {
        $Commandes = CommandeDAO::findAll();
        return $this->responseJson(200, $Commandes);
    }

    private function getCommande($id) {
        $Commande = CommandeDAO::findById($id);

        if ($Commande) {
            return $this->responseJson(200, $Commande);
        } else {
            return $this->notFoundResponse();
        }
    }

    private function createCommandeFromRequest() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$this->validateCommande($data)) {
            return $this->unprocessableEntityResponse();
        }


       
        $Commande = new Commande(
            null, 
            $data['idClient'],
            $data['idRestaurant'],
            null,
            $data['prixTotal'], 
            $data['idStatut'],
        );

        $newCommandeId = CommandeDAO::save($Commande);

        if ($newCommandeId!=null) {
            return $this->responseJson(201, ["message" => "Product créé avec succès","idCommande" => $newCommandeId]);
        } else {
            return $this->serverErrorResponse();
        }
    }

    public function updateCommandeFromRequest($id) {
        $Commande = CommandeDAO::findById($id);

        if (!$Commande) {
            return $this->notFoundResponse();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!$this->validateCommande($data)) {
            return $this->unprocessableEntityResponse();
        }

        $Commande->setIdRestaurant($data['idRestaurant']);
        $Commande->setPrixTotal($data['prixTotal']);
        $Commande->setIdClient($data['idClient']);
        $Commande->setIdLivreur($data['idLivreur']);
        $Commande->setIdStatut($data['idStatut']);

        if (CommandeDAO::update($Commande)) {
            return $this->responseJson(200, ["message" => "Produit mis à jour avec succès"]);
        } else {
            return $this->serverErrorResponse();
        }
    }

    public function deleteCommandeFromRequest($id) {
        $Commande = CommandeDAO::findById($id);

        if (!$Commande) {
            return $this->notFoundResponse();
        }

        if (CommandeDAO::delete($Commande)) {
            return $this->responseJson(200, ["message" => "Produit supprimé avec succès"]);
        } else {
            return $this->serverErrorResponse();
        }
    }
}
?>