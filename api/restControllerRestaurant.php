<?php
// Inclusion des classes nécessaires pour la gestion des produits
include_once("../modele/DAO/RestaurantDao.class.php");

// DÉFINIR LES EN-TÊTES HTTP REQUIS POUR LES RÉPONSES JSON
header("Access-Control-Allow-Origin: *"); // pour autoriser les requêtes externes.
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); //pour spécifier les méthodes HTTP acceptées.
header("Access-Control-Allow-Headers: Content-Type, Authorization"); //  pour permettre l’envoi de données JSON.
header("Content-Type: application/json"); // pour spécifier le type json
// FIN DES AJOUTS EN-TÊTES HTTP

class RestControllerRestaurant {
    //B. AJOUTER DES PROPRIÉTÉS DE LA CLASSE
    private $requestMethod;
    private $restaurantId;

    public function __construct($requestMethod, $restaurantId) {
        $this->requestMethod = $requestMethod;
        
        if (empty($restaurantId)) {
            $this->restaurantId = null;
        } else {
            $this->restaurantId = $restaurantId;
        }
    }
    //FIN DE B. AJOUTER DES PROPRIÉTÉS DE LA CLASSE

    // Vérification de la validité des données du produit
    private function validateRestaurant($data) {
        return !empty($data['idProprietaire']) && 
               !empty($data['nom']) && 
               !empty($data['adresse']) &&
                !empty($data['phone']) &&
                !empty($data['description']);
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
            404 => "Not Found 1",
            422 => "Unprocessable Entity",
            500 => "Internal Server Error"
        ];
        return $statusMessages[$code] ?? "Unknown Status";
    }

    //C. IMPLÉMENTER LA MÉTHODE processRequest()
    public function processRequest() {
        if ($this->requestMethod === 'GET') {
            if ($this->restaurantId !== null) {
                $reponse =  $this->getRestaurant($this->restaurantId);
            } else {
                $reponse = $this->getAllRestaurants();
            }
        }
        else if ($this->requestMethod === 'POST') {
            $reponse = $this->createRestaurantFromRequest();
        }

        else if ($this->requestMethod === 'PUT' && $this->restaurantId !== null) {
            $reponse = $this->updateRestaurantFromRequest($this->restaurantId);
        }

        else if ($this->requestMethod === 'DELETE' && $this->restaurantId !== null) {
            $reponse = $this->deleteProductFromRequest($this->restaurantId);
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
    private function getAllRestaurants() {
        $restaurants = RestaurantDAO::findAll();
        return $this->responseJson(200, $restaurants);
    }

    private function getRestaurant($id) {
        $restaurant = RestaurantDAO::findById($id);

        if ($restaurant) {
            return $this->responseJson(200, $restaurant);
        } else {
            return $this->notFoundResponse();
        }
    }

    private function createRestaurantFromRequest() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$this->validateRestaurant($data)) {
            return $this->unprocessableEntityResponse();
        }

        // Trouve le dernier produit pour obtenir le dernier ID et incrémenter de 1
        /*$allrestaurants = RestaurantDAO::findAll();
        $lastrestaurant = end($allrestaurants);
        $newId = $lastrestaurant->getIdRestaurant() + 1;*/

        $restaurant = new restaurant(
            null,
            $data['idProprietaire'],
            $data['nom'],
            $data['adresse'],
            $data['phone'], 
            $data['description'],
        );

        $newrestaurant = RestaurantDAO::save($restaurant);

        if ($newrestaurant) {
            return $this->responseJson(201, ["message" => "Product créé avec succès"]);
        } else {
            return $this->serverErrorResponse();
        }
    }

    public function updaterestaurantFromRequest($id) {
        $restaurant = RestaurantDAO::findById($id);

        if (!$restaurant) {
            return $this->notFoundResponse();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        if (!$this->validaterestaurant($data)) {
            return $this->unprocessableEntityResponse();
        }

        $restaurant->setNom($data['nom']);
        $restaurant->setAdresse($data['adresse']);
        $restaurant->setPhone($data['phone']);
        $restaurant->setDescription($data['description']);

        if (restaurantDAO::update($restaurant)) {
            return $this->responseJson(200, ["message" => "Produit mis à jour avec succès"]);
        } else {
            return $this->serverErrorResponse();
        }
    }

    public function deleteProductFromRequest($id) {
        $restaurant = RestaurantDAO::findById($id);

        if (!$restaurant) {
            return $this->notFoundResponse();
        }

        if (restaurantDAO::delete($restaurant)) {
            return $this->responseJson(200, ["message" => "Produit supprimé avec succès"]);
        } else {
            return $this->serverErrorResponse();
        }
    }
}
?>