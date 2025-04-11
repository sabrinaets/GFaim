<?php
class unRestaurant implements JsonSerializable
{
    private ?int $idRestaurant;
    private int $idProprietaire;
    private string $nom;
    private string $adresse;
    private string $phone;
    private string $description;

       // Constructor
       public function __construct(
        ?int $idRestaurant,
        int $idProprietaire,
        string $nom,
        string $adresse,
        string $phone,
        string $description,
  
        
    ) {
        $this->idRestaurant = $idRestaurant;
        $this->idProprietaire=$idProprietaire;
        $this->nom=$nom;
        $this->adresse = $adresse;
        $this->phone = $phone;
        $this->description=$description;
    }

        //Permettre d'avoir des instances de Item et de les envoyer
    public function jsonSerialize(): array
    {
        return [
            'idRestaurant' => $this->idRestaurant,
            'idProprietaire'=>$this->idProprietaire,
            'nom' => $this->nom,
            'adresse' => $this->adresse,
            'phone' => $this->phone, 
            'description' => $this->description,
        ];
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
     * Get the value of idProprietaire
     */ 
    public function getIdProprietaire()
    {
        return $this->idProprietaire;
    }

    /**
     * Set the value of idProprietaire
     *
     * @return  self
     */ 
    public function setIdProprietaire($idProprietaire)
    {
        $this->idProprietaire = $idProprietaire;

        return $this;
    }

    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of adresse
     */ 
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     *
     * @return  self
     */ 
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

        // __toString method
        public function __toString(): string
        {
            return sprintf(
                "[Restaurant #%d] %s - %s - %s - %s - %s-  %s)",
                $this->idRestaurant,
                $this->idProprietaire,
                $this->nom,
                $this->adresse,
                $this->phone,
                $this->description
            );
        }
}
?>