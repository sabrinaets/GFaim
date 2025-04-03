//Fonction pour faire apparai
    document.getElementById("toggle-panier").addEventListener("click", afficherPanier) ;

// Clé du panier dans Local Storage
const PANIER_KEY = "panier";

// Fonction pour récupérer le panier depuis Local Storage
function getPanier() {
    return JSON.parse(localStorage.getItem(PANIER_KEY)) || [];
}

// Fonction pour sauvegarder le panier dans Local Storage
function savePanier(panier) {
    localStorage.setItem(PANIER_KEY, JSON.stringify(panier));
}

// Fonction pour ajouter un produit au panier
function ajouterAuPanier(id, nom, prix) {
    let panier = getPanier();
    
    // Vérifie si l'item est déjà dans le panier
    let item = panier.find(item => item.id === id);
    
    if (item) {
        item.quantite++; // Incrémente la quantité
    } else {
        panier.push({ id, nom, prix, quantite: 1 });
    }
    
    savePanier(panier);
    afficherPanier();
}

// Fonction pour afficher le panier dans une liste
function afficherPanier() {
    let panier = getPanier();
    let panierHTML = document.querySelector(".panier");
    let totalPrix =0;

    // Vide le HTML actuel
    let contenu = "";
    
    panier.forEach(item => {
        contenu += `<li>${item.nom} - ${item.prix}€ (x${item.quantite}) 
            <button onclick="supprimerDuPanier(${item.id})">❌</button></li>`;
        totalPrix += item.prix;
    });

    panierHTML.innerHTML = contenu + `<h2>Total: ${totalPrix}€</h2><br><a href="#">Commander</a>`
    panierHTML.classList.toggle("hidden");
    this.textContent = panierHTML.classList.contains("hidden") ? "Panier" : "Fermer panier";
}

// Fonction pour supprimer un produit du panier
function supprimerDuPanier(id) {
    let panier = getPanier();
    panier = panier.filter(item => item.id !== id);
    savePanier(panier);
    afficherPanier();
}

// Fonction pour vider tout le panier
function viderPanier() {
    localStorage.removeItem(PANIER_KEY);
    afficherPanier();
}

// Afficher le panier au chargement de la page
document.addEventListener("DOMContentLoaded", afficherPanier);
