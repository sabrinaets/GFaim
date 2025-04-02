<?php
// Inclusion des classes nécessaires pour la gestion des produits
include_once("../modele/DAO/CommandeItemDao.php");
include_once("../modele/commandeItem.class.php");

// DÉFINIR LES EN-TÊTES HTTP REQUIS POUR LES RÉPONSES JSON
header("Access-Control-Allow-Origin: *"); // pour autoriser les requêtes externes.
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); //pour spécifier les méthodes HTTP acceptées.
header("Access-Control-Allow-Headers: Content-Type, Authorization"); //  pour permettre l’envoi de données JSON.
header("Content-Type: application/json"); // pour spécifier le type json
// FIN DES AJOUTS EN-TÊTES HTTP

class RestControllerCommandeItem {
    //B. AJOUTER DES PROPRIÉTÉS DE LA CLASSE
    private $requestMethod;
    private $idCommandeItem;

    public function __construct($requestMethod, $idCommandeItem) {
        $this->requestMethod = $requestMethod;
        
        if (empty($idCommandeItem)) {
            $this->idCommandeItem = null;
        } else {
            $this->idCommandeItem = $idCommandeItem;
        }
    }
    //FIN DE B. AJOUTER DES PROPRIÉTÉS DE LA CLASSE

    // Vérification de la validité des données du produit
    private function validateCommandeItem($data) {
        return !empty($data['idCommande']) && 
               !empty($data['idItem']) && 
               !empty($data['quantite']);
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
            if ($this->idCommandeItem !== null) {
                $reponse =  $this->getCommandeItem($this->idCommandeItem);
            } else {
                $reponse = $this->getAllCommandesItem();
            }
        }
        else if ($this->requestMethod === 'POST') {
            $reponse = $this->createCommandeItemFromRequest();
        }

        else if ($this->requestMethod === 'PUT' && $this->idCommandeItem !== null) {
            $reponse = $this->updateCommandeItemFromRequest($this->idCommandeItem);
        }

        else if ($this->requestMethod === 'DELETE' && $this->idCommandeItem !== null) {
            $reponse = $this->deleteCommandeItemFromRequest($this->idCommandeItem);
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
    private function getAllCommandesItem() {
        $CommandesItem = CommandeItemDAO::findAll();
        return $this->responseJson(200, $CommandesItem);
    }

    private function getCommandeItem($id) {
        $CommandeItem = CommandeItemDAO::findById($id);

        if ($CommandeItem) {
            return $this->responseJson(200, $CommandeItem);
        } else {
            return $this->notFoundResponse();
        }
    }

    private function createCommandeItemFromRequest() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$this->validateCommandeItem($data)) {
            return $this->unprocessableEntityResponse();
        }

        // Trouve le dernier produit pour obtenir le dernier ID et incrémenter de 1
        $allCommandes = CommandeItemDAO::findAll();
        $lastCommande = end($allCommandes);
        $newId = $lastCommande->getIdCommandeItem() + 1;

        $CommandeItem = new CommandeItem(
            $newId, 
            $data['idCommande'],
            $data['idItem'],
            $data['quantite'],
        );

        $newidCommandeItem = CommandeItemDAO::save($CommandeItem);

        if ($newId) {
            return $this->responseJson(201, ["message" => "Product créé avec succès", "id" => $newId]);
        } else {
            return $this->serverErrorResponse();
        }
    }

    public function updateCommandeItemFromRequest($id) {
        $CommandeItem = CommandeItemDAO::findById($id);

        if (!$CommandeItem) {
            return $this->notFoundResponse();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!$this->validateCommandeItem($data)) {
            return $this->unprocessableEntityResponse();
        }

        $CommandeItem->setIdCommande($data['idCommande']);
        $CommandeItem->setIdItem($data['idItem']);
        $CommandeItem->setQuantite($data['quantite']);

        if (CommandeItemDAO::update($CommandeItem)) {
            return $this->responseJson(200, ["message" => "Produit mis à jour avec succès"]);
        } else {
            return $this->serverErrorResponse();
        }
    }

    public function deleteCommandeItemFromRequest($id) {
        $CommandeItem = CommandeItemDAO::findById($id);

        if (!$CommandeItem) {
            return $this->notFoundResponse();
        }

        if (CommandeDAO::delete($CommandeItem)) {
            return $this->responseJson(200, ["message" => "Produit supprimé avec succès"]);
        } else {
            return $this->serverErrorResponse();
        }
    }
}
?>