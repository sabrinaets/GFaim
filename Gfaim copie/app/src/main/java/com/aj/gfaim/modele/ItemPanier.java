package com.aj.gfaim.modele;

public class ItemPanier {
    String nom;
    String description;
    String prix;
    private int imageResId;

    public ItemPanier(String nom, String description, String prix, int imageResId) {
        this.nom = nom;
        this.description = description;
        this.prix = prix;
        this.imageResId = imageResId;
    }

    public String getNom() { return nom; }
    public String getDescription() { return description; }
    public String getPrix() { return prix; }
    public int getImageResId() { return imageResId; }
}