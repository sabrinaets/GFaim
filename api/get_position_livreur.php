<?php
include_once '../modele/DAO/connexionBD.class.php';

if (isset($_GET['idLivreur'])) {
    try {
        $pdo = ConnexionBD::getInstance();

        $stmt = $pdo->prepare("SELECT latitude, longitude FROM Utilisateur WHERE idUtilisateur = ?");
        $stmt->execute([$_GET['idLivreur']]);
        $position = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($position) {
            header('Content-Type: application/json');
            echo json_encode($position);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Livreur non trouvé']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur serveur : ' . $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'idLivreur manquant']);
}
