let totalPrix =0;  // doit la mettre dans localstorage, sinon se reset a zero a chaque refresh

console.log("Fichier fonctions.js chargé !");

    document.getElementById("toggle-panier").addEventListener("click", function(){
        let panier = getPanier();
        let panierHTML = document.querySelector(".panier");
        afficherPanier();
        panierHTML.classList.toggle("hidden");
        this.textContent = panierHTML.classList.contains("hidden") ? "Panier" : "Fermer panier";

    }) ;


const PANIER_KEY = "panier";


function getPanier() {
    return JSON.parse(localStorage.getItem(PANIER_KEY)) || [];
}


function savePanier(panier) {
    localStorage.setItem(PANIER_KEY, JSON.stringify(panier));
}


function ajouterAuPanier(id, nom, prix,idRestaurant) {
    let panier = getPanier();
    
    
    let item = panier.find(item => item.id === id);
    
    if (item) {
        item.quantite++; 
    } else {
        panier.push({ id, nom, prix, idRestaurant,quantite: 1 });
    }
    totalPrix+=prix;
    savePanier(panier);
    afficherPanier();
}


function afficherPanier() {
    let panier = getPanier();
    let panierHTML = document.querySelector(".panier");
    

    
    let contenu = "";
    
    panier.forEach(item => {
        contenu += `<li>${item.nom} - ${item.prix}$ (x${item.quantite}) 
            <button class="deletePanier" onclick="supprimerDuPanier(${item.id})"><i class="fa-solid fa-xmark"></i></button></li>`;
    });

    panierHTML.innerHTML = contenu + `<h2>Total: ${totalPrix}$</h2><br><a class="commander-panier">Commander</a>`
    let boutonCommander = document.querySelector(".commander-panier");
    if (boutonCommander) {
        boutonCommander.addEventListener("click", commanderPanier);
    } else {
        console.error("Le bouton .commander-panier n'a pas été trouvé.");
    }
}


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


function viderPanier() {
    localStorage.removeItem(PANIER_KEY);
    totalPrix=0;
    afficherPanier();
}


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
        if (data.idCommande) {
            alert("Commande passée avec succès !");
            ajouterItemsACommande(data.idCommande);
            viderPanier(); 
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

function ajouterItemsACommande(idCommande) {
    let panier = getPanier();
    
    
    panier.forEach(item => {
        let commandeItem = {
            idCommande: idCommande, 
            idItem: item.id,      
            quantite: item.quantite, 
        };

        console.log("CommandeItem envoyée:", commandeItem);
       
        fetch("http://localhost:9090/PROJETWEB/api/commandeItem", { 
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(commandeItem)
        })
        .then(response => response.text())
        .then(data => {
            console.log("Réponse de l'API commandeItem:", data);
            if (data.message) {
                console.log("Item ajouté à la commande avec succès");
            } else {
                console.error("Erreur lors de l'ajout de l'item à la commande");
            }
        })
        .catch(error => console.error("Erreur:", error));
    });
}
