package com.aj.gfaim.modele;

import java.io.Serializable;

public class MenuItem implements Serializable {
    private String nom;
    private String description;
    private String prix;
    private int imageResId;

    public MenuItem(String nom, String description, String prix, int imageResId) {
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