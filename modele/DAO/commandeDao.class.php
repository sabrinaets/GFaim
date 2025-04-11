<?php

include_once(__DIR__ . "/DAO.interface.php");
use Modele\Commande;

class commandeDAO implements DAO{
    static public function findById(int $id):?object{
        try{
            $connexion = ConnexionBD::getInstance();
        }
        catch(Exception $e){
            throw new Exception("Impossible d'obtenir la connexion a la BD");
        }

        $commande = null;
        $requete = $connexion->prepare(
            "SELECT * FROM commande WHERE idCommande = :id"
        );
        $requete->bindParam(':id',$id,PDO::PARAM_INT);
        $requete->execute();


        if ($requete->rowCount()!=0){
            $enr = $requete->fetch();
            $commande = new Commande(
                $enr['idCommande'],
                $enr['idClient'],
                $enr['idRestaurant'],
                $enr['idLivreur']??null,
                $enr['prixTotal']??0,
                $enr['idStatut']??1
            );
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $commande;
    }

    public static function findAll():array{
        try{
            $connexion = ConnexionBD::getInstance();
        }
        catch(Exception $e){
            throw new Exception("Impossible d'acceder a la BD");
        }

        $commandes = [];
        $requete = $connexion->prepare(
            "SELECT * FROM commande"
        );
        $requete->execute();

        foreach($requete as $enr){
            $commandes[]=new Commande(
                $enr['idCommande'],
                $enr['idClient'],
                $enr['idRestaurant'],
                $enr['idLivreur']??null,
                $enr['prixTotal']??0,
                $enr['idStatut']??1
            );
        }
        $requete->closeCursor();
        ConnexionBD::close();

        return $commandes;
    }

    static public function save(object $commande){
        try{
            $connexion = ConnexionBD::getInstance();
        }
        catch(Exception $e){
            throw new Exception("Impossible d'acceder a la BD");
        }
        $idCommande = $commande->getIdCommande();
        $idClient = $commande->getIdClient();
        $idRestaurant = $commande->getIdRestaurant();
        $idLivreur = $commande->getIdLivreur()??null;
        $prix = $commande->getPrixTotal()??0;
        $statut = $commande->getIdStatut()??1;

        $requete = $connexion->prepare(
            "INSERT INTO Commande (idClient,idRestaurant,idLivreur,prixTotal,idStatut)
            VALUES(:idClient,
            :idRestaurant,
            :idLivreur,
            :prixTotal,
            :idStatut
            )"
        );

        $requete->bindParam(':idClient',$idClient,PDO::PARAM_INT);
        $requete->bindParam(':idRestaurant',$idRestaurant,PDO::PARAM_INT);
        $requete->bindParam(':idLivreur',$idLivreur,PDO::PARAM_INT);
        $requete->bindParam(':prixTotal',$prix,PDO::PARAM_STR);
        $requete->bindParam(':idStatut',$statut,PDO::PARAM_INT);
    
        $result =  $requete->execute();
        if ($result){
            $newId = $connexion->lastInsertId();
            return $newId;
        }
        return false;
    
    }

    static public function update(object $commande):bool{
        try{
            $connexion = ConnexionBD::getInstance();
        }
        catch(Exception $e){
            throw new Exception("Impossible d'acceder a la BD");
        }
        $idCommande = $commande->getIdCommande();
        $idClient = $commande->getIdClient();
        $idRestaurant = $commande->getIdRestaurant();
        $idLivreur = $commande->getIdLivreur()??null;
        $prix = $commande->getPrixTotal()??0;
        $statut = $commande->getIdStatut()??1;

        $requete = $connexion->prepare(
            "UPDATE Commande 
            SET idClient = :idClient,
            idRestaurant = :idRestaurant,
            idLivreur = :idLivreur,
            prixTotal = :prixTotal,
            idStatut = :idStatut
            WHERE  idCommande = :id"
        );

        $requete->bindParam(':id',$idCommande,PDO::PARAM_INT);
        $requete->bindParam(':idClient',$idClient,PDO::PARAM_INT);
        $requete->bindParam(':idRestaurant',$idRestaurant,PDO::PARAM_INT);
        $requete->bindParam(':idLivreur',$idLivreur,PDO::PARAM_INT);
        $requete->bindParam(':prixTotal',$prix,PDO::PARAM_STR);
        $requete->bindParam(':idStatut',$statut,PDO::PARAM_INT);
    
        return $requete->execute();
    }

    static public function delete(object $commande):bool{
        try{
            $connexion = ConnexionBD::getInstance();
        }
        catch(Exception $e){
            throw new Exception ("Impossible de se connecter a la BD");
        }
        $id = $commande->getIdCommande();

        $requete = $connexion->prepare(
            "DELETE FROM Commande WHERE idCommande= :id");

        $requete->bindParam(':id',$id,PDO::PARAM_INT);
        
        return $requete->execute();

    }

    static public function findByEmail(string $email): object{
        throw new Exception("Fonction indisponible pour cette classe");
        $obj = null;
        return $obj;
    }
    static public function existsByEmail(string $email): bool{
        throw new Exception("Fonction indisponible pour cette classe");
        return false;
    }

    static public function findByDescription(string $filter): array
    {
        throw new Exception("Cette methode est indisponible pour la classe Commande");
        return [];
    }
    static public function getCommandesParClient(PDO $pdo, int $idClient): array {
        $stmt = $pdo->prepare(
            "SELECT c.*, r.nom AS nomRestaurant ,r.adresse AS adresseRestaurant
            FROM commande c
            JOIN restaurant r ON c.idRestaurant = r.idRestaurant
            WHERE c.idClient = :idClient"
        );
        $stmt->execute(['idClient' => $idClient]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   
    static public function getCommandesDispo(PDO $pdo):array{
        $requete = $pdo->prepare(
            "SELECT cmd.*, r.nom AS nomRestaurant, c.codepostal as adresseClient, c.username AS nomClient 
            FROM Commande cmd
            JOIN Restaurant r ON cmd.idRestaurant = r.idRestaurant
            JOIN Utilisateur c ON cmd.idClient = c.idUtilisateur
            WHERE cmd.idStatut = 1 AND cmd.idLivreur IS NULL");
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function updateCommandeAcceptee(PDO $pdo, int $idCommande,int $idLivreur):bool{
            $requete = $pdo -> prepare(
                "UPDATE commande SET idLivreur = :idLivreur WHERE idCommande = :idCommande AND idLivreur IS NULL"
            );
            $requete->execute(['idLivreur'=>$idLivreur,'idCommande'=>$idCommande]);
            return $requete->rowCount() > 0;
    }

    static public function voirCommandesLivrer(PDO $pdo, int $idLivreur):array{
        $requete = $pdo -> prepare(
            "SELECT cmd.* ,r.nom AS nomRestaurant, c.codepostal as adresseClient, c.username AS nomClient 
            FROM commande cmd 
            LEFT JOIN restaurant r ON cmd.idRestaurant = r.idRestaurant
            LEFT JOIN utilisateur c ON cmd.idClient = c.idUtilisateur
            WHERE cmd.idLivreur = :idLivreur AND cmd.idStatut=1"
        );
        $requete->execute(['idLivreur'=>$idLivreur]);
        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
    
        return $resultats ?: []; // Retourne un tableau vide si aucune commande n'est trouvée
    }

    static public function voirCommandesResto(PDO $pdo, int $idRestaurateur):array{
        $requete = $pdo->prepare(
            "SELECT cmd.* , r.nom AS nomRestaurant, c.codepostal as adresseClient, c.username AS nomClient
            FROM restaurant r 
            JOIN commande cmd ON cmd.idRestaurant = r.idRestaurant
            JOIN utilisateur c ON cmd.idClient = c.idUtilisateur
            WHERE r.idProprietaire = :idRestaurateur AND cmd.idStatut=1"
        );
        $requete->execute(['idRestaurateur'=>$idRestaurateur]);
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }
    static public function annulerCommandeLivreur( PDO $pdo,int $idCmd){
        $requete = $pdo->prepare(
            "UPDATE commande SET idLivreur = NULL WHERE idCommande = :idCommande"
        );
        $requete->execute(['idCommande'=>$idCmd]);
        return $requete->execute();
    }
    static public function terminerCommandeResto(PDO $pdo, int $idCmd):bool{
        $requete = $pdo->prepare(
            "UPDATE commande SET idStatut = 3 WHERE idCommande = :idCommande"
        );
        $requete->execute(['idCommande'=>$idCmd]);
        return $requete->execute();
    }
    static public function annulerMaCommande(PDO $pdo, int $idCmd):bool{
        $requete = $pdo->prepare(
            "DELETE FROM commande WHERE idCommande = :idCommande"
        );
        $requete->execute(['idCommande'=>$idCmd]);
        return $requete->execute();
    }
    static public function itemPlusPopulaire(PDO $pdo,int $idRestaurant):string{
        $requete = $pdo->prepare(
            "SELECT MAX(nom) FROM item WHERE idItem IN 
            (SELECT idItem FROM commandeItem cI
            JOIN Commande c ON c.idCommande = cI.idCommande
            WHERE c.idRestaurant = :idRestaurant)"
        );
        $requete->execute(['idRestaurant'=>$idRestaurant]);
        return (string)$requete->fetchColumn();
    }
    static public function commandesParResto(PDO $pdo, int $idRestaurant):int{
        $requete=$pdo->prepare(
            "SELECT COUNT(idCommande) FROM Commande WHERE idRestaurant= :idRestaurant"
        );
        $requete->execute(['idRestaurant'=>$idRestaurant]);
        return (int) $requete->fetchColumn();
    }
    static public function clientsParResto(PDO $pdo, int $idRestaurant){
        $requete = $pdo->prepare(
            "SELECT COUNT(DISTINCT idClient) FROM Commande WHERE idRestaurant = :idRestaurant"
        );
        $requete->execute(['idRestaurant'=>$idRestaurant]);
        return (int) $requete->fetchColumn();
    }
}