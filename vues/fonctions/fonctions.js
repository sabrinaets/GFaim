let totalPrix =0;


console.log("Fichier fonctions.js chargé !");
//Fonction pour faire apparai
    document.getElementById("toggle-panier").addEventListener("click", function(){
        let panier = getPanier();
        let panierHTML = document.querySelector(".panier");
        afficherPanier();
        panierHTML.classList.toggle("hidden");
        this.textContent = panierHTML.classList.contains("hidden") ? "Panier" : "Fermer panier";

    }) ;

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
function ajouterAuPanier(id, nom, prix,idRestaurant) {
    let panier = getPanier();
    
    // Vérifie si l'item est déjà dans le panier
    let item = panier.find(item => item.id === id);
    
    if (item) {
        item.quantite++; // Incrémente la quantité
    } else {
        panier.push({ id, nom, prix, idRestaurant,quantite: 1 });
    }
    totalPrix+=prix;
    savePanier(panier);
    afficherPanier();
}

// Fonction pour afficher le panier dans une liste
function afficherPanier() {
    let panier = getPanier();
    let panierHTML = document.querySelector(".panier");
    

    // Vide le HTML actuel
    let contenu = "";
    
    panier.forEach(item => {
        contenu += `<li>${item.nom} - ${item.prix}€ (x${item.quantite}) 
            <button onclick="supprimerDuPanier(${item.id})">❌</button></li>`;
    });

    panierHTML.innerHTML = contenu + `<h2>Total: ${totalPrix}€</h2><br><a class="commander-panier">Commander</a>`
    let boutonCommander = document.querySelector(".commander-panier");
    if (boutonCommander) {
        boutonCommander.addEventListener("click", commanderPanier);
    } else {
        console.error("Le bouton .commander-panier n'a pas été trouvé.");
    }
}

// Fonction pour supprimer un produit du panier
function supprimerDuPanier(id) {
    let panier = getPanier();

    itemASupprimer = panier.find(item => item.id === id);
    if (itemASupprimer) {
        totalPrix -= itemASupprimer.quantite * itemASupprimer.prix; // Corrige la soustraction
    }
    panier = panier.filter(item => item.id !== id);
   
    savePanier(panier);
    afficherPanier();
}

// Fonction pour vider tout le panier
function viderPanier() {
    localStorage.removeItem(PANIER_KEY);
    totalPrix=0;
    afficherPanier();
}

// Afficher le panier au chargement de la page
document.addEventListener("DOMContentLoaded", afficherPanier);


function commanderPanier(id) {
    let panier = getPanier();

    if (!panier || panier.length === 0) {
        alert("Votre panier est vide !");
        return;
    }

    

    let idC = sessionStorage.getItem('idUtilisateur');
        console.log("idC"+idC);
    if (!idC){
        console.log("Aucun utilisateur connecte");
    }


    let itemsCommande = panier.map(item => {
        console.log(item); 
        return {
            idProduit: item.id,
            nom: item.nom,
            prix: item.prix,
            quantite: item.quantite,
            idRestaurant: item.idRestaurant 
        };
    });

    let idR;
    itemsCommande.forEach(item => {
        if (item.idRestaurant === undefined) {
            console.error("L'élément ne contient pas de idRestaurant");
        } else {
            console.log("ID Restaurant: ", item.idRestaurant);
            idR = item.idRestaurant;
        }
    });

    

   
    let commande = {
        idClient: idC, 
        idRestaurant: idR, 
        idStatut: 1,  
        prixTotal: panier.reduce((total, item) => total + item.prix * item.quantite, 0),
    };


    //Faire POST pour la commande vide
    console.log("Commande envoyée:", commande);
    fetch("http://localhost:9090/PROJETWEB/api/commande", { 
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(commande)
    })
    .then(response => response.json())
    .then(data => {
        console.log("Réponse de l'API:", data); 

        try{
        if (data.message) {
            alert("Commande passée avec succès !");
            viderPanier(); // Vide le panier après la commande
        } else {
            alert("Erreur lors de la commande.");
        }
    }
    catch(e){
        console.error("Erreur de parsing JSON:", e); 
        alert("Réponse invalide du serveur.");
    }
    })
    .catch(error => console.error("Erreur:", error));
}

