<?php
// 2.
include_once("restControllerItem.php");
include_once("restControllerRestaurant.php");
include_once("restControllerCommande.php");
// FIN 2.

// 3.
header("Access-Control-Allow-Origin: *"); // pour autoriser les requêtes externes.
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); //pour spécifier les méthodes HTTP acceptées.
header("Access-Control-Allow-Headers: Content-Type, Authorization"); //  pour permettre l’envoi de données JSON.
// FIN 3.

// 4.
$requestMethod = $_SERVER["REQUEST_METHOD"];
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME']; // Chemin du script exécuté
$scriptDir = dirname($scriptName); // Dossier contenant le script
$requestPath = trim(str_replace($scriptDir, "", $requestUri), "/"); // Extraction du chemin relatif
// FIN 4.

// 5.
$pathSegments = explode("/", $requestPath);

$resource = $pathSegments[0] ?? null;
$id = isset($pathSegments[1]) && is_numeric($pathSegments[1]) ? intval($pathSegments[1]) : null; // on s'assure que l'id est présent et est un nombre
//echo json_encode(["resource" => $resource, "id" => $id]); // pour le débogage



/*$controller = new RestControllerProduct($requestMethod, $id);

if ($requestMethod === "GET") {
    $controller->processRequest();
} elseif ($requestMethod === "POST") {
    $controller->processRequest();
} elseif ($requestMethod === "PUT") {
    $controller->processRequest();
} elseif ($requestMethod === "DELETE") {
    $controller->processRequest();
} else {
    http_response_code(405);
    echo json_encode(["message" => "Méthode non autorisée"]);
}
*/


switch($resource){
    case "item":
        $controller = new RestControllerItem($requestMethod, $id);
        processDemande($requestMethod, $id, $controller);
        break;
    case "restaurant":
        $controller = new RestControllerRestaurant($requestMethod, $id);
        processDemande($requestMethod, $id, $controller);
        break;
    case "commande":
        $controller = new RestControllerCommande($requestMethod, $id);
        processDemande($requestMethod, $id, $controller);
        break;
    default:
        http_response_code(404);
        echo json_encode(["message" => "Ressource non trouvée"]);
}



function processDemande($requestMethod, $id, $controller) {
    if ($requestMethod === "GET") {
        $controller->processRequest();
    } elseif ($requestMethod === "POST") {
        $controller->processRequest();
    } elseif ($requestMethod === "PUT") {
        $controller->processRequest();
    } elseif ($requestMethod === "DELETE") {
        $controller->processRequest();
    } else {
        http_response_code(405);
        echo json_encode(["message" => "Méthode non autorisée"]);
    }
}
?>