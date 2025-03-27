<?php

class Item implements JsonSerializable{
    private ?int $idItem;
    private int $idRestaurant;
    private string $nom;
    private ?string $description;
    private float $prix;
    private ?string $image;

    public function __construct(
        ?int $idItem,
        int $idRestaurant,
        string $nom,
        string $description,
        float $prix,
        string $image

    ){
        $this->idItem = $idItem;
        $this->idRestaurant = $idRestaurant;
        $this->nom = $nom;
        $this->prix = $prix;
        $this->image = $image;
        $this->description = $description;
        
    }

    //Permettre d'avoir des instances de Item et de les envoyer
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->idItem,
            'restaurant'=>$this->idRestaurant,
            'nom' => $this->nom,
            'prix' => $this->prix,
            'image' => $this->image, 
            'description' => $this->description, 
        ];
    }

    public function __toString(): string
    {
        return sprintf(
            "[#%d] %s - %i @%.2f$ (%s)",
            $this->idItem,
            $this->nom,
            $this->idRestaurant,
            $this->prix,
            $this->description
        );
    }

 
    public function getIdItem()
    {
        return $this->idItem;
    }



    public function setIdItem($idItem)
    {
        $this->idItem = $idItem;

        return $this;
    }


    public function getIdRestaurant()
    {
        return $this->idRestaurant;
    }


    public function setIdRestaurant($idRestaurant)
    {
        $this->idRestaurant = $idRestaurant;

        return $this;
    }


    public function getNom()
    {
        return $this->nom;
    }


    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }


    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }


    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }


}
?>