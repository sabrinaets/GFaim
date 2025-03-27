<?php

include_once(__DIR__ . "/DAO.interface.php");
include_once(__DIR__ . "/../commande.class.php");

class commandeDAO implements DAO{
    static public function findById(int $id):?commande{
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

    static public function save(object $commande):bool{
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
    
        return $requete->execute();
    
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

    static public function findByEmail(string $email): null{
        throw new Exception("Fonction indisponible pour cette classe");
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
}