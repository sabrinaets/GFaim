<?php
class Restaurant implements JsonSerializable
{
    private int $idCommande;
    private int $idItem;
    private int $quantite;
    
    public function __construct(
        int $idCommande,
        int $idItem,
        int $quantite
    ){
        $this->idCommande = $idCommande;
        $this->idItem = $idItem;
        $this->quantite = $quantite;
    }

    //Permettre d'avoir des instances de Item et de les envoyer
    public function jsonSerialize(): array
    {
        return [
            'idCommande' => $this->idCommande,
            'idItem'=>$this->idItem,
            'quantite' => $this->quantite,
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
     * Get the value of idItem
     */ 
    public function getIdItem()
    {
        return $this->idItem;
    }

    /**
     * Set the value of idItem
     *
     * @return  self
     */ 
    public function setIdItem($idItem)
    {
        $this->idItem = $idItem;

        return $this;
    }

    /**
     * Get the value of quantite
     */ 
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set the value of quantite
     *
     * @return  self
     */ 
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf(
            "[#%d] %s - %s - %s",
            $this->idCommande,
            $this->idItem,
            $this->quantite
        );
    }
}
?>