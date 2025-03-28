package com.aj.gfaim.modele;

import android.content.ClipData;

public class ItemLivraisonDispo {
    String nomRestaurant;
    String adresse;
    String itemCommande;

    public ItemLivraisonDispo(String nomRestaurant, String adresse, String itemCommande) {
        this.nomRestaurant = nomRestaurant;
        this.adresse = adresse;
        this.itemCommande = itemCommande;
    }

    public String getNomRestaurant() {
        return nomRestaurant;
    }

    public String getAdresse() {
        return adresse;
    }

    public String getItemCommande() {
        return itemCommande;
    }
}