package com.aj.gfaim.modele;

import java.io.Serializable;

public class Restaurant implements Serializable {
    private String nom;
    private String adresse;

    public Restaurant(String nom, String adresse) {
        this.nom = nom;
        this.adresse = adresse;
    }

    public String getNom() {
        return nom;
    }

    public String getAdresse() {
        return adresse;
    }
}