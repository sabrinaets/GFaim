<?php

include_once(__DIR__ . "/DAO.interface.php");
include_once(__DIR__ . "/../user.class.php");
include_once(__DIR__ . "/../restaurant.class.php");


class RestaurantDao implements DAO {
    
    /**
     * Recherche un restaurant par ID
     * @param int $id
     * @return Restaurant|null
     */
    static public function findById(int $idRestaurant): ?Restaurant {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $restaurant = null;
        $requete = $connexion->prepare(
            "SELECT * FROM Restaurant WHERE idRestaurant = :idRestaurant"
        );
        $requete->bindParam(':idRestaurant', $idRestaurant, PDO::PARAM_INT);
        $requete->execute();

        if ($requete->rowCount() != 0) {
            $enr = $requete->fetch();
            $restaurant = new Restaurant(
                $enr['idRestaurant'],
                $enr['idProprietaire'],
                $enr['nom'],
                $enr['adresse'],
                $enr['telephone'],
                $enr['description']
            );
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $restaurant;
    }

    /**
     * Retourne tous les restaurants
     * @return array
     */
    static public function findAll(): array {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $liste = [];
        $requete = $connexion->prepare("SELECT * FROM Restaurant");
        $requete->execute();

        while ($enr = $requete->fetch()) {
            $restaurant = new Restaurant(
                $enr['idRestaurant'],
                $enr['idProprietaire'],
                $enr['nom'],
                $enr['adresse'],
                $enr['telephone'],
                $enr['description']
            );
            $liste[] = $restaurant;
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $liste;
    }

    /**
     * Retourne tous les restaurants
     * @return array
     */
    static public function findAllByProprietaire(int $idProprietaire): array {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $liste = [];
        $requete = $connexion->prepare("SELECT * FROM Restaurant WHERE idProprietaire = :idProprietaire");
        $requete->bindParam(':idProprietaire', $idProprietaire, PDO::PARAM_INT);
        $requete->execute();

        while ($enr = $requete->fetch()) {
            $restaurant = new Restaurant(
                $enr['idRestaurant'],
                $enr['idProprietaire'],
                $enr['nom'],
                $enr['adresse'],
                $enr['telephone'],
                $enr['description']
            );
            $liste[] = $restaurant;
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $liste;
    }

    /**
     * Ajoute un restaurant
     * @param Restaurant $restaurant
     * @return bool
     */
    static public function save(object $restaurant): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion");
        }

        // Stockage dans des variables intermédiaires
        $idProprietaire = $restaurant->getIdProprietaire();
        $nom = $restaurant->getNom();
        $adresse = $restaurant->getAdresse();
        $phone = $restaurant->getPhone();
        $description = $restaurant->getDescription();
    
        // Requête préparée
        $requete = $connexion->prepare(
            "INSERT INTO Restaurant (idProprietaire, nom, adresse, telephone, description) 
             VALUES (:idProprietaire, :nom, :adresse, :phone, :description)"
        );

        // Liaison des paramètres
        $requete->bindParam(':idProprietaire', $idProprietaire, PDO::PARAM_INT);
        $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
        $requete->bindParam(':adresse', $adresse, PDO::PARAM_STR);
        $requete->bindParam(':phone', $phone, PDO::PARAM_STR);
        $requete->bindParam(':description', $description, PDO::PARAM_STR);


        $success = $requete->execute();
        if ($success) {
            $restaurant->setIdRestaurant((int)$connexion->lastInsertId());
        }

        return $success;
    }

    /**
     * Met à jour un utilisateur existant
     * @param Restaurant $user
     * @return bool
     */
    static public function update(object $restaurant): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }
    
        // Stockage dans des variables intermédiaires
        $idRestaurant = $restaurant->getIdRestaurant();
        $idProprietaire = $restaurant->getIdProprietaire();
        $nom = $restaurant->getNom();
        $adresse = $restaurant->getAdresse();
        $phone = $restaurant->getPhone();
        $description = $restaurant->getDescription();

        // Requête préparée
        $requete = $connexion->prepare(
            "UPDATE Restaurant 
             SET idProprietaire = :idProprietaire, nom = :nom, adresse = :adresse, telephone = :phone, description = :description 
             WHERE idRestaurant = :idRestaurant"
        );
    
        // Liaison des paramètres
        $requete->bindParam(':idRestaurant', $idRestaurant, PDO::PARAM_INT);
        $requete->bindParam(':idProprietaire', $idProprietaire, PDO::PARAM_INT);
        $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
        $requete->bindParam(':adresse', $adresse, PDO::PARAM_STR);
        $requete->bindParam(':phone', $phone, PDO::PARAM_STR);
        $requete->bindParam(':description', $description, PDO::PARAM_STR);
    
        return $requete->execute();
    }

    /**
     * Supprime un restaurant
     * @param Restaurant $restaurant
     * @return bool
     */
    static public function delete(object $restaurant): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $requete = $connexion->prepare(
            "DELETE FROM Restaurant WHERE idRestaurant = :idRestaurant"
        );
        $requete->bindParam(':idRestaurant', $restaurant->getIdRestaurant(), PDO::PARAM_INT);

        return $requete->execute();
    }

    static public function findByEmail(string $email): ?Restaurant {
        throw new Exception("Cette fonction n'est pas disponible pour cette classe [restaurant]");
        return null; // Retourne null si aucun utilisateur trouvé
    }

    static public function existsByEmail(string $email): bool {
            throw new Exception("Cette fonction n'est pas disponible pour cette classe [restaurant]");
            return false;
    }
    
    public static function findByDescription(string $filter): array{
        $tableau = [];
        return $tableau;  
    }

}

?>