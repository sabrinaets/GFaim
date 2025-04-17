package com.aj.gfaim.modele;

public class ViewModel extends androidx.lifecycle.ViewModel {
    public static String generateNewId(int lastId) {
        int newId = lastId + 1;
        return String.valueOf(newId);
    }

    public Utilisateur prepareUserForRegistration(String id, String nom, String prenom, String role,
                                                  String codePostal, String telephone, String adresseCourriel, String motDePasse) {
        Utilisateur newUser = new Utilisateur(nom, prenom, role, codePostal, telephone, adresseCourriel, motDePasse);
        newUser.setId(id);
        return newUser;
    }

    private Utilisateur currentUser;
    public void setCurrentUser(Utilisateur user) {
        this.currentUser = user;
    }
    public Utilisateur getCurrentUser() {
        return currentUser;
    }
}