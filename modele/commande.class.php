<?php

class Commande implements JsonSerializable {
    private ?int $idCommande;
    private int $idClient;
    private int $idRestaurant;
    private ?int $idLivreur;
    private float $prixTotal;
    private int $idStatut;

    public function __construct(?int $idCommande,int $idClient, int $idRestaurant, ?int $idLivreur,float $prixTotal,int $idStatut){
       $this->idCommande = $idCommande;
        $this->idClient=$idClient;
        $this->idRestaurant = $idRestaurant;
        $this->idLivreur = $idLivreur;
        $this->prixTotal = $prixTotal;
        $this->idStatut = $idStatut;
    }

    public function jsonSerialize(): array {
        return [
            'idCommande' => $this->idCommande,
            'idClient' => $this->idClient,
            'idRestaurant' => $this->idRestaurant,
            'idLivreur' => $this->idLivreur,
            'prixTotal' => $this->prixTotal,
            'idStatut' => $this->idStatut
        ];
    }
    

    /**
     * Get the value of idCommande
     */ 
    public function getIdCommande()
    {
        return $this->idCommande;
    }

    /**
     * Set the value of idCommande
     *
     * @return  self
     */ 
    public function setIdCommande($idCommande)
    {
        $this->idCommande = $idCommande;

        return $this;
    }

    /**
     * Get the value of idRestaurant
     */ 
    public function getIdRestaurant()
    {
        return $this->idRestaurant;
    }

    /**
     * Set the value of idRestaurant
     *
     * @return  self
     */ 
    public function setIdRestaurant($idRestaurant)
    {
        $this->idRestaurant = $idRestaurant;

        return $this;
    }

    /**
     * Get the value of idClient
     */ 
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * Set the value of idClient
     *
     * @return  self
     */ 
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;

        return $this;
    }

    /**
     * Get the value of idLivreur
     */ 
    public function getIdLivreur()
    {
        return $this->idLivreur;
    }

    /**
     * Set the value of idLivreur
     *
     * @return  self
     */ 
    public function setIdLivreur($idLivreur)
    {
        $this->idLivreur = $idLivreur;

        return $this;
    }

    /**
     * Get the value of prixTotal
     */ 
    public function getPrixTotal()
    {
        return $this->prixTotal;
    }

    /**
     * Set the value of prixTotal
     *
     * @return  self
     */ 
    public function setPrixTotal($prixTotal)
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    /**
     * Get the value of idStatut
     */ 
    public function getIdStatut()
    {
        return $this->idStatut;
    }

    /**
     * Set the value of idStatut
     *
     * @return  self
     */ 
    public function setIdStatut($idStatut)
    {
        $this->idStatut = $idStatut;

        return $this;
    }
}
?>