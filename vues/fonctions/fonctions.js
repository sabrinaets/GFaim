//Fonction pour faire apparaitre le panier
document.getElementById("toggle-panier").addEventListener("click", function () {
    let panier = document.querySelector(".panier");
    //nouveau:
    
    if (!panier) {
        panier = document.createElement("div");
        panier.classList.add("panier", "hidden");

        let titre = document.createElement("h2");
        titre.innerHTML = "Panier";

        let cas1 = document.createElement("div");
        cas1.classList.add("panier-items"); 

        // Exemple de produit (tu peux remplacer par une liste dynamique)
        let produit = { nom: "Item 1", prix: 10, id: 1 };

        let innercas1 = document.createElement("div");
        innercas1.classList.add("panier-item");
        innercas1.innerHTML = `
            <div>
                <h3>${produit.nom}</h3>
                <p>Prix: ${produit.prix}$</p>
            </div>
            <a class="supprimer-item" data-id="${produit.id}"><i class="fa-solid fa-x"></i></a>
        `;

        cas1.appendChild(innercas1); // Correction : appendChild()

        // Section total
        let total = document.createElement("div");
        total.classList.add("total");
        total.innerHTML = `
            <h2>Total: ${produit.prix}$</h2>
            <a class="commander-panier">Commander</a>
        `;

        // Ajout des éléments au panier
        panier.appendChild(titre);
        panier.appendChild(cas1);
        panier.appendChild(total);

        // Ajout au DOM
        document.body.appendChild(panier);
    }

  //fin nouveau              
    panier.classList.toggle("hidden");
    this.textContent = panier.classList.contains("hidden") ? "Panier" : "Fermer panier";
});
