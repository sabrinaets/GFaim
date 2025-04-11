<?php

include_once(__DIR__ . "/DAO.interface.php");
include_once(__DIR__ . "/../monUser.class.php");
include_once(__DIR__ . "/../unItem.class.php");


class ItemDao implements DAO {
    
    /**
     * Recherche un Item par ID
     * @param int $id
     * @return Item|null
     */
    static public function findById(int $idItem): ?unItem {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $Item = null;
        $requete = $connexion->prepare(
            "SELECT * FROM Item WHERE idItem = :idItem"
        );
        $requete->bindParam(':idItem', $idItem, PDO::PARAM_INT);
        $requete->execute();

        if ($requete->rowCount() != 0) {
            $enr = $requete->fetch();
            $Item = new unItem(
                $enr['idItem'],
                $enr['idRestaurant'],
                $enr['nom'],
                $enr['description'],
                $enr['prix'],
                $enr['image']
            );
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $Item;
    }

    /**
     * Retourne tous les Items
     * @return array
     */
    static public function findAll(): array {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $liste = [];
        $requete = $connexion->prepare("SELECT * FROM Item");
        $requete->execute();

        while ($enr = $requete->fetch()) {
            $Item = new unItem(
                $enr['idItem'],
                $enr['idRestaurant'],
                $enr['nom'],
                $enr['description'],
                $enr['prix'],
                $enr['image']
            );
            $liste[] = $Item;
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $liste;
    }

    /**
     * Retourne tous les Items
     * @return array
     */
    static public function findAllByResto(int $idRestaurant): array {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $liste = [];
        $requete = $connexion->prepare("SELECT * FROM Item WHERE idRestaurant = :idRestaurant");
        $requete->bindParam(':idRestaurant', $idRestaurant, PDO::PARAM_INT);
        $requete->execute();

        while ($enr = $requete->fetch()) {
            $Item = new unItem(
                $enr['idItem'],
                $enr['idRestaurant'],
                $enr['nom'],
                $enr['description'],
                $enr['prix'],
                $enr['image']
            );
            $liste[] = $Item;
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $liste;
    }

    

    /**
     * Ajoute un Item
     * @param Item $Item
     * @return bool
     */
    static public function save(object $Item): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion");
        }

        // Stockage dans des variables intermédiaires
        $idRestaurant = $Item->getIdRestaurant();
        $nom = $Item->getNom();
        $image = $Item->getImage();
        $prix = $Item->getPrix();
        $description = $Item->getDescription();
    
        // Requête préparée
        $requete = $connexion->prepare(
            "INSERT INTO Item (idRestaurant, nom, description, prix, image) 
             VALUES (:idRestaurant, :nom, :description, :prix, :image)"
        );

        // Liaison des paramètres
        $requete->bindParam(':idRestaurant', $idRestaurant, PDO::PARAM_INT);
        $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
        $requete->bindParam(':image', $image, PDO::PARAM_STR);
        $requete->bindParam(':prix', $prix, PDO::PARAM_STR);
        $requete->bindParam(':description', $description, PDO::PARAM_STR);


        $success = $requete->execute();
        if ($success) {
            $Item->setIdItem((int)$connexion->lastInsertId());
        }

        return $success;
    }

    /**
     * Met à jour un item existant
     * @param Item $Item
     * @return bool
     */
    static public function update(object $Item): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }
    
        // Stockage dans des variables intermédiaires
        $idItem = $Item->getIdItem();
        $idRestaurant = $Item->getIdRestaurant();
        $nom = $Item->getNom();
        $image = $Item->getImage();
        $prix = $Item->getPrix();
        $description = $Item->getDescription();

        // Requête préparée
        $requete = $connexion->prepare(
            "UPDATE Item 
             SET idRestaurant = :idRestaurant, nom = :nom, image = :image, prix = :prix, description = :description 
             WHERE idItem = :idItem"
        );
    
        // Liaison des paramètres
        $requete->bindParam(':idItem', $idItem, PDO::PARAM_INT);
        $requete->bindParam(':idRestaurant', $idRestaurant, PDO::PARAM_INT);
        $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
        $requete->bindParam(':image', $image, PDO::PARAM_STR);
        $requete->bindParam(':prix', $prix, PDO::PARAM_STR);
        $requete->bindParam(':description', $description, PDO::PARAM_STR);
    
        return $requete->execute();
    }

    /**
     * Supprime un Item
     * @param Item $Item
     * @return bool
     */
    static public function delete(object $Item): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $requete = $connexion->prepare(
            "DELETE FROM Item WHERE idItem = :idItem"
        );
        $requete->bindParam(':idItem', $Item->getIdItem(), PDO::PARAM_INT);

        return $requete->execute();
    }

    static public function findByEmail(string $email): ?unItem {
        throw new Exception("Cette fonction n'est pas disponible pour cette classe [Item]");
        return null; // Retourne null si aucun utilisateur trouvé
    }

    static public function existsByEmail(string $email): bool {
            throw new Exception("Cette fonction n'est pas disponible pour cette classe [Item]");
            return false;
    }
    
    public static function findByDescription(string $filter): array{
        $tableau = [];
        return $tableau;  
    }

}

?>