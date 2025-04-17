
console.log("Fichier fonctions.js chargé !");

    document.getElementById("toggle-panier").addEventListener("click", togglePanier);
   
    function togglePanier(){
        let panier = getPanier();
        let panierHTML = document.querySelector(".panier");
        afficherPanier();
        panierHTML.classList.toggle("hidden");

    }





function getPanier() { 
    let id = sessionStorage.getItem("idUtilisateur");
    if (!id) {
        console.error("Utilisateur non connecté — impossible de récupérer le panier.");
        return [];
    }
    return JSON.parse(localStorage.getItem("panier_" + id)) || [];
}


function savePanier(panier) {
    let id = sessionStorage.getItem("idUtilisateur");
    if (!id) {
        console.error("Utilisateur non connecté — impossible de sauvegarder le panier.");
        return;
    }
    localStorage.setItem("panier_" + id, JSON.stringify(panier));
}


function ajouterAuPanier(id, nom, prix,idRestaurant) {
    let panier = getPanier();
    
    
    let item = panier.find(item => item.id === id);
    
    if (item) {
        item.quantite++; 
    } else {
        panier.push({ id, nom, prix, idRestaurant,quantite: 1 });
    }
    
    savePanier(panier);
    afficherPanier();
}


function afficherPanier() {
    let panier = getPanier();
    let panierHTML = document.querySelector(".panier");
    

    
    let contenu = `<button class="closePanier" onclick=""><i class="fa-solid fa-xmark"></i></button>`; 
    let totalPrix =0; 
    
    
    panier.forEach(item => {
        totalPrix +=parseInt(item.quantite)*parseFloat(item.prix);
        contenu += `<div class="unItemListe">
            <div><p>${item.nom} (x${item.quantite}) - ${item.prix}$</p>
            </div>
            <button class="deletePanier" onclick="soustraireItem(${item.id})">-</button></li></div>`;
    });

    panierHTML.innerHTML = contenu + `<h2>Total: ${totalPrix}$</h2><br><a class="commander-panier">Commander</a><a class="commander-panier vider">Vider le panier</a>`
    
    let boutonCommander = document.querySelector(".commander-panier");
    let boutonVider = document.querySelector(".vider");
    let boutonClose = document.querySelector(".closePanier");

    if (boutonVider) {
        boutonVider.addEventListener("click", viderPanier);
    } else {
        console.error("Le bouton .commander-panier n'a pas été trouvé.");
    }
    if (boutonCommander) {
        boutonCommander.addEventListener("click", commanderPanier);
    } else {
        console.error("Le bouton .commander-panier n'a pas été trouvé.");
    }
    if (boutonClose){
        boutonClose.addEventListener("click",togglePanier);
    }
}


function supprimerDuPanier(id) {
    let panier = getPanier();

    
    panier = panier.filter(item => item.id !== id);
   
    savePanier(panier);
    afficherPanier();
}


function viderPanier() {
    let id = sessionStorage.getItem("idUtilisateur");
    if (!id) {
        console.error("Utilisateur non connecté — impossible de vider le panier.");
        return;
    }

    localStorage.removeItem("panier_" + id);
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
    fetch("http://localhost:8001/api/commande", { 
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
       
        fetch("http://localhost:8001/api/commandeItem", { 
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
     
function soustraireItem(id){
    let panier = getPanier();

    let itemASupprimer = panier.find(item => item.id === id);
   
    if(itemASupprimer.quantite>1){
        itemASupprimer.quantite--;
        savePanier(panier);
    }
    else{
        supprimerDuPanier(id);
        return;
    }
    
    afficherPanier();
}