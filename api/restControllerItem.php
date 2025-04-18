<?php
// Inclusion des classes nécessaires pour la gestion des produits
include_once("../modele/DAO/itemDao.class.php");
include_once("../modele/unItem.class.php");


// DÉFINIR LES EN-TÊTES HTTP REQUIS POUR LES RÉPONSES JSON
header("Access-Control-Allow-Origin: *"); // pour autoriser les requêtes externes.
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); //pour spécifier les méthodes HTTP acceptées.
header("Access-Control-Allow-Headers: Content-Type, Authorization"); //  pour permettre l’envoi de données JSON.
header("Content-Type: application/json"); // pour spécifier le type json
// FIN DES AJOUTS EN-TÊTES HTTP

class RestControllerItem {
    //B. AJOUTER DES PROPRIÉTÉS DE LA CLASSE
    private $requestMethod;
    private $itemId;

    public function __construct($requestMethod, $itemId) {
        $this->requestMethod = $requestMethod;
        
        if (empty($itemId)) {
            $this->itemId = null;
        } else {
            $this->itemId = $itemId;
        }
    }
    //FIN DE B. AJOUTER DES PROPRIÉTÉS DE LA CLASSE

    // Vérification de la validité des données du produit
    private function validateItem($data) {
        return !empty($data['idRestaurant']) && 
               !empty($data['nom']) && 
               !empty($data['description']) && 
               isset($data['prix']) && is_numeric($data['prix']) && $data['prix'] > 0;
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
            if ($this->itemId !== null) {
                $reponse =  $this->getItem($this->itemId);
            } else {
                $reponse = $this->getAllItems();
            }
        }
        else if ($this->requestMethod === 'POST') {
            $reponse = $this->createItemFromRequest();
        }

        else if ($this->requestMethod === 'PUT' && $this->itemId !== null) {
            $reponse = $this->updateItemFromRequest($this->itemId);
        }

        else if ($this->requestMethod === 'DELETE' && $this->itemId !== null) {
            $reponse = $this->deleteProductFromRequest($this->itemId);
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
    private function getAllItems() {
        $items = ItemDAO::findAll();
        return $this->responseJson(200, $items);
    }

    private function getItem($id) {
        $item = ItemDAO::findById($id);

        if ($item) {
            return $this->responseJson(200, $item);
        } else {
            return $this->notFoundResponse();
        }
    }

    private function createItemFromRequest() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$this->validateItem($data)) {
            return $this->unprocessableEntityResponse();
        }

        // Trouve le dernier produit pour obtenir le dernier ID et incrémenter de 1
        /*$allItems = ItemDAO::findAll();
        $lastItem = end($allItems);
        $newId = $lastItem->getIdItem() + 1;*/

        $item = new unItem(
            null, 
            $data['idRestaurant'],
            $data['nom'],
            $data['description'],
            $data['prix'],
            $data['image'] 
        );

        $newItem = ItemDAO::save($item);

        if ($newItem) {
            return $this->responseJson(201, ["message" => "Product créé avec succès"]);
        } else {
            return $this->serverErrorResponse();
        }
    }

    public function updateItemFromRequest($id) {
        $item = ItemDAO::findById($id);

        if (!$item) {
            return $this->notFoundResponse();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!$this->validateItem($data)) {
            return $this->unprocessableEntityResponse();
        }

        $item->setNom($data['nom']);
        $item->setPrix($data['prix']);
        $item->setImage($data['image']);
        $item->setDescription($data['description']);

        if (ItemDAO::update($item)) {
            return $this->responseJson(200, ["message" => "Produit mis à jour avec succès"]);
        } else {
            return $this->serverErrorResponse();
        }
    }

    public function deleteProductFromRequest($id) {
        $item = ItemDAO::findById($id);

        if (!$item) {
            return $this->notFoundResponse();
        }

        if (ItemDAO::delete($item)) {
            return $this->responseJson(200, ["message" => "Produit supprimé avec succès"]);
        } else {
            return $this->serverErrorResponse();
        }
    }
    //FIN DE D. IMPLÉMENTER LES OPÉRATIONS CRUD
}
?>