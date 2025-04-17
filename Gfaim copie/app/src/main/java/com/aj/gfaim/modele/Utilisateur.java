package com.aj.gfaim.modele;

import com.fasterxml.jackson.annotation.JsonProperty;
import com.fasterxml.jackson.annotation.JsonPropertyOrder;

@JsonPropertyOrder({
        "id",
        "nom",
        "prenom",
        "role",
        "codePostal",
        "telephone",
        "adresseCourriel",
        "motDePasse"
})

public class Utilisateur {
    private String id;
    private String nom;
    private String prenom;
    private String role;
    private String codePostal;
    private String telephone;
    private String adresseCourriel;
    private String motDePasse;

    public Utilisateur(String nom, String prenom, String role, String codePostal,
                       String telephone, String adresseCourriel, String motDePasse) {
        this.nom = nom;
        this.prenom = prenom;
        this.role = role;
        this.codePostal = codePostal;
        this.telephone = telephone;
        this.adresseCourriel = adresseCourriel;
        this.motDePasse = motDePasse;
    }

    public Utilisateur() {}

    @JsonProperty("id")
    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    @JsonProperty("nom")
    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    @JsonProperty("prenom")
    public String getPrenom() {
        return prenom;
    }

    public void setPrenom(String prenom) {
        this.prenom = prenom;
    }

    @JsonProperty("role")
    public String getRole() {
        return role;
    }

    public void setRole(String role) {
        this.role = role;
    }

    @JsonProperty("codePostal")
    public String getCodePostal() {
        return codePostal;
    }

    public void setCodePostal(String codePostal) {
        this.codePostal = codePostal;
    }

    @JsonProperty("telephone")
    public String getTelephone() {
        return telephone;
    }

    @JsonProperty("telephone")
    public void setTelephone(String telephone) {
        this.telephone = telephone;
    }

    @JsonProperty("adresseCourriel")
    public String getAdresseCourriel() {
        return adresseCourriel;
    }

    public void setAdresseCourriel(String adresseCourriel) {
        this.adresseCourriel = adresseCourriel;
    }

    @JsonProperty("motDePasse")
    public String getMotDePasse() {
        return motDePasse;
    }

    public void setMotDePasse(String motDePasse) {
        this.motDePasse = motDePasse;
    }

    @Override
    public String toString() {
        return "Utilisateur{" +
                "id='" + id + '\'' +
                ", nom='" + nom + '\'' +
                ", prenom='" + prenom + '\'' +
                ", role='" + role + '\'' +
                ", codePostal='" + codePostal + '\'' +
                ", telephone='" + telephone + '\'' +
                ", adresseCourriel='" + adresseCourriel + '\'' +
                ", motDePasse='[PROTEGÉ]'" +
                '}';
    }
}