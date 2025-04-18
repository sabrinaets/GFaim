package com.aj.gfaim.modele;

public class ItemLivraisonDispo {
    private String id;
    private String nomRestaurant;
    private String adresse;
    private String produits;

    // Constructeur
    public ItemLivraisonDispo(String nomRestaurant, String adresse, String produits) {
        this.nomRestaurant = nomRestaurant;
        this.adresse = adresse;
        this.produits = produits;
    }

    // Getters
    public String getId() { return id; }
    public String getNomRestaurant() { return nomRestaurant; }
    public String getAdresse() { return adresse; }
    public String getProduits() { return produits; }

    // Setters
    public void setId(String id) { this.id = id; }
    public void setNomRestaurant(String nomRestaurant) { this.nomRestaurant = nomRestaurant; }
    public void setAdresse(String adresse) { this.adresse = adresse; }
    public void setProduits(String produits) { this.produits = produits; }
}
