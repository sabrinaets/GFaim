package com.aj.gfaim.modele;

public class Commande {
    private String numero;
    private String produit;
    private String statut;

    public Commande(String numero, String produit, String statut) {
        this.numero = numero;
        this.produit = produit;
        this.statut = statut;
    }

    public String getNumero() {
        return numero;
    }

    public String getProduit() {
        return produit;
    }

    public String getStatut() {
        return statut;
    }
}