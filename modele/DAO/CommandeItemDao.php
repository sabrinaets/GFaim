<?php

include_once(__DIR__ . "/DAO.interface.php");
include_once(__DIR__ . "/../user.class.php");
include_once(__DIR__ . "/../commandeItem.class.php");


class CommandeItemDao implements DAO {
    
    /**
     * Recherche un Item par ID
     * @param int $id
     * @return Item|null
     */
    static public function findById(int $idCommandeItem): ?CommandeItem {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $commandeItem = null;
        $requete = $connexion->prepare(
            "SELECT * FROM commandeitem WHERE idCommandeItem = :idCommandeItem"
        );
        $requete->bindParam(':idCommandeItem', $idCommandeItem, PDO::PARAM_INT);
        $requete->execute();

        if ($requete->rowCount() != 0) {
            $enr = $requete->fetch();
            $commandeItem = new CommandeItem(
                $enr['idCommandeItem'],
                $enr['idCommande'],
                $enr['idItem'],
                $enr['quantite']
            );
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $commandeItem;
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
        $requete = $connexion->prepare("SELECT * FROM commandeitem");
        $requete->execute();

        while (($enr = $requete->fetch()) !== false) {
            $commandeItem = new CommandeItem(
                $enr['idCommandeItem'],
                $enr['idCommande'],
                $enr['idItem'],
                $enr['quantite']
            );
            $liste[] = $commandeItem;
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $liste;
    }

     /**
     * Retourne tous les Items d'une commande
     * @return array
     */
    static public function findAllByCommande(int $idCommande): array {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $liste = [];
        $requete = $connexion->prepare("SELECT * FROM commandeitem  WHERE idCommande = :idCommande");
        $requete->bindParam(':idCommande', $idCommande, PDO::PARAM_INT);
        $requete->execute();

        while (($enr = $requete->fetch()) !== false) {
            $commandeItem = new CommandeItem(
                $enr['idCommandeItem'],
                $enr['idCommande'],
                $enr['idItem'],
                $enr['quantite']
            );
            $liste[] = $commandeItem;
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
    static public function save(object $commandeItem): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion");
        }

        // Stockage dans des variables intermédiaires
        $idCommande = $commandeItem->getIdCommande();
        $idItem = $commandeItem->getIdItem();
        $quantite = $commandeItem->getQuantite();
    
        // Requête préparée
        $requete = $connexion->prepare(
            "INSERT INTO commandeitem (idCommande, idItem, quantite) 
             VALUES (:idCommande, :idItem, :quantite)"
        );

        // Liaison des paramètres
        $requete->bindParam(':idCommande', $idCommande, PDO::PARAM_INT);
        $requete->bindParam(':idItem', $idItem, PDO::PARAM_STR);
        $requete->bindParam(':quantite', $quantite, PDO::PARAM_STR);


        $success = $requete->execute();
        if ($success) {
            $commandeItem->setIdCommandeItem((int)$connexion->lastInsertId());
        }

        return $success;
    }

    /**
     * Met à jour un item existant
     * @param Item $Item
     * @return bool
     */
    static public function update(object $commandeItem): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }
    
        // Stockage dans des variables intermédiaires
        $idCommandeItem = $commandeItem->getIdCommandeItem();
        $idCommande = $commandeItem->getIdCommande();
        $idItem = $commandeItem->getIdItem();
        $quantite = $commandeItem->getQuantite();

        // Requête préparée
        $requete = $connexion->prepare(
            "UPDATE commandeitem 
             SET idCommande = :idCommande, idItem = :idItem, quantite = :quantite 
             WHERE idCommandeItem = :idCommandeItem"
        );
    
        // Liaison des paramètres
        $requete->bindParam(':idCommandeItem', $idCommandeItem, PDO::PARAM_INT);
        $requete->bindParam(':idCommande', $idCommande, PDO::PARAM_INT);
        $requete->bindParam(':idItem', $idItem, PDO::PARAM_STR);
        $requete->bindParam(':quantite', $quantite, PDO::PARAM_STR);
    
        return $requete->execute();
    }

    /**
     * Supprime un Item
     * @param Item $Item
     * @return bool
     */
    static public function delete(object $commandeItem): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $requete = $connexion->prepare(
            "DELETE FROM commandeitem WHERE idCommandeItem = :idCommandeItem"
        );
        $requete->bindParam(':idItem', $commandeItem->getIdCommandeItem(), PDO::PARAM_INT);

        return $requete->execute();
    }

    static public function findByEmail(string $email): ?Object {
        throw new Exception("Cette fonction n'est pas disponible pour cette classe [commandeItem]");
        return null; // Retourne null si aucun utilisateur trouvé
    }

    static public function existsByEmail(string $email): bool {
            throw new Exception("Cette fonction n'est pas disponible pour cette classe [commandeItem]");
            return false;
    }
    
    public static function findByDescription(string $filter): array{
        throw new Exception("Cette fonction n'est pas disponible pour cette classe [commandeItem]");
        return $tableau;  
    }


}

?>