<?php

include_once '../modele/DAO/connexionBD.class.php';
/* update_position agit comme une mini api qui recoit les coordonnees gps du livreur et met a jour la bd*/

try{
    $pdo = ConnexionBD::getInstance();
}
catch(Exception $e){
    throw new Exception("Impossible d'acceder a la BD pour mettre a jour la position du livreur");
}

$data = json_decode(file_get_contents("php://input"),true);
$idLivreur = $data["idLivreur"];
$latitude = $data["latitude"];
$longitude = $data["longitude"];

$sql ="UPDATE Utilisateur SET latitude = ?, longitude=? WHERE idUtilisateur=?";
$stmt =$pdo->prepare($sql);
$stmt->execute([$latitude,$longitude,$idLivreur]);
echo "Position mise a jour";