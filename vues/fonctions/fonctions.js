
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
    let totalPrix = 0; 

    panier.forEach(item => {
        totalPrix += parseInt(item.quantite) * parseFloat(item.prix);
        contenu += `<div class="unItemListe">
            <div><p>${item.nom} (x${item.quantite}) - ${(parseFloat(item.prix)).toFixed(2)}$</p></div>
            <button class="deletePanier" onclick="soustraireItem(${item.id})">-</button>
        </div>`;
    });

    contenu += `<h2>Total: ${totalPrix.toFixed(2)}$</h2>
        <div id="paypal-button-container"></div>
        <br><a class="commander-panier vider">Vider le panier</a>`;

    panierHTML.innerHTML = contenu;

    // Boutons
    const boutonVider = document.querySelector(".vider");
    const boutonClose = document.querySelector(".closePanier");

    if (boutonVider) {
        boutonVider.addEventListener("click", viderPanier);
    }
    if (boutonClose) {
        boutonClose.addEventListener("click", togglePanier);
    }

    loadPaypalSdk().then(() => {
        renderPaypalButton(panier, totalPrix);
    }).catch(() => {
        console.error("Erreur lors du chargement du SDK PayPal");
    });
}
function loadPaypalSdk() {
    return new Promise((resolve, reject) => {
        if (typeof paypal !== "undefined") {
            return resolve(); 
        }

        const existingScript = document.querySelector("script[src*='paypal.com/sdk/js']");
        if (existingScript) {
            existingScript.addEventListener("load", resolve);
            return;
        }

        const script = document.createElement("script");
        script.src = "https://www.paypal.com/sdk/js?client-id=AaueH_EDRloIbSiw261KmBqc4D2xk6tTslaNnpHWnxwnXZy6LY52OZz-s5kBLoGvADAhsPReqKaRCFz_&currency=CAD&locale=fr_CA";
        script.onload = resolve;
        script.onerror = reject;
        document.head.appendChild(script);
    });
}
function renderPaypalButton(panier, totalPrix) {
    if (!panier.length || totalPrix <= 0) {
        console.warn("Panier vide, bouton PayPal non affiché.");
        const container = document.getElementById("paypal-button-container");
        if (container) container.innerHTML = ''; // Vider le bouton si déjà affiché
        return;
    }

    paypal.Buttons({
        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: totalPrix.toFixed(2), 
                        currency_code: "CAD"
                    }
                }]
            });
        },
        onApprove: function (data, actions) {
            return actions.order.capture().then(function (details) {
                alert("Paiement approuvé ! Merci " + details.payer.name.given_name);
                console.log("Détails de la transaction:", details);
                commanderPanier();

            });
        },
        onError: function (err) {
            console.error("Erreur PayPal:", err);
        }
    }).render('#paypal-button-container');
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
