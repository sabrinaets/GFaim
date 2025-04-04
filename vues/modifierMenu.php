<?php
if(!isset($_SESSION)) {
    session_start(); // Toujours démarrer la session
}
$idResto = isset($_GET['id']) ? $_GET['id'] : null; // Récupérer l'ID du restaurant à modifier<
echo "<script>const restaurantId = " . json_encode($idResto) . ";</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - GFaim</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
        <?php
                include("vues/fonctions/entete.php");
                include("vues/fonctions/fonctions.php");
                afficherMenu($controleur);
            ?>
        </nav>
    </header>
    <main class="contenu">
        <h1>Voici les articles dans votre menu</h1>
        <a class="boutonAjouter"href="?action=ajouterProduit&id=<?= htmlspecialchars($idResto) ?>">Ajouter</a>
        <?php
        if(empty($controleur->getMesItems()))
        {
            echo "<h1>Aucun article trouvé</h1>";
        }
        else{
            afficherMonMenu($controleur->getMesItems()); // Affiche la liste des articles
        }
        ?>
        <!---<ul class="liste-commandes">
            <li class="article">
                <span class="nomArticle">Rondelle d'oignon</span><br>
                <span class="description">Des oignons frais pané servi avec notre mayo épicée signature</span><br>
                <span class="prix">3.99$</span><br>
                <a class="boutonModifier" href="?action=editArticle">Modifier</a>
                <button class="boutonSupprimer">Supprimer</button>
            </li>
            <li class="article">
                <span class="nomArticle">Cola</span><br>
                <span class="description">Un cola sans trademark</span><br>
                <span class="prix">0.99$</span><br>
                <button class="boutonModifier" href="?action=editArticle">Modifier</button>
                <button class="boutonSupprimer">Supprimer</button>
            </li>
            <li class="article">
                <span class="nomArticle">Cheeseburger</span><br>
                <span class="description">Cheeseburger servi sur pain au sésame et fait avec du boeuf 100% canadien</span><br>
                <span class="prix">8.99$</span><br>
                <button class="boutonModifier" href="?action=editArticle">Modifier</button>
                <button class="boutonSupprimer">Supprimer</button>
            </li>
            <li class="article">
                <span class="nomArticle">Frite familliale</span><br>
                <span class="description">Des frites maisons servi avec notre mayo épicée signature</span><br>
                <span class="prix">6.99$</span><br>
                <button class="boutonModifier" href="?action=editArticle">Modifier</button>
                <button class="boutonSupprimer">Supprimer</button>
            </li>
            <li class="article">
                <span class="nomArticle">Hamburger fromage & bacon</span><br>
                <span class="description">Hamburger servi sur pain au sésame et fait avec du boeuf et bacon 100% canadien</span><br>
                <span class="prix">10.99$</span><br>
                <button class="boutonModifier" href="?action=editArticle">Modifier</button>
                <button class="boutonSupprimer">Supprimer</button>
            </li>
            <li class="article">
                <span class="nomArticle">Hot-dog steamé</span><br>
                <span class="description">Un bon hot-dog classique cuit à la vapeur</span><br>
                <span class="prix">1.49$</span><br>
                <button class="boutonModifier" href="?action=editArticle">Modifier</button>
                <button class="boutonSupprimer">Supprimer</button>
            </li>
        </ul>--->
        <div class="formAjouterPromotion">
            <h2>Ajouter une promotion</h2>
            <form id="ajouterPromotion" action="post">
                <input type="hidden" id="editProductId" />
                <input
                  type="text"
                  id="nomPromotion"
                  name="evenement"
                  placeholder="Nom de la promotion"
                  required
                />
                <input
                  type="number"
                  id="pourcentagePromotion"
                  placeholder="Pourcentage"
                  name="rabais"
                  step="0.01"
                  required
                />
                <input  style="font-size:17px; padding:7px; margin-top:15px; border:none; width:40%; border-radius:20px" type="submit" value="Ajouter">
                
                <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Sélectionner tous les boutons de suppression
            const boutonsSupprimer = document.querySelectorAll(".boutonSupprimer");

            boutonsSupprimer.forEach(bouton => {
                bouton.addEventListener("click", function () {
                    const itemId = this.getAttribute("data-id");

                    if (!itemId) {
                        alert("ID de l'item introuvable !");
                        return;
                    }

                    // Demander confirmation avant de supprimer
                    if (!confirm("Voulez-vous vraiment supprimer cet item ?")) {
                        return;
                    }

                    // Envoyer une requête DELETE à l'API
                    fetch(`http://localhost:9090/PROJETWEB/api/item/${itemId}`, {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json"
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Erreur lors de la suppression");
                        }
                        return response.json();
                    })
                    .then(data => {
                        alert("Item supprimé avec succès !");
                        console.log("Succès:", data);

                        // Supprimer l'élément du DOM
                        this.closest("li.article").remove();
                    })
                    .catch(error => {
                        console.error("Erreur:", error);
                        location.reload(); // Recharger la page en cas d'erreur
                    });
                });
            });
        });
        </script>
        </main>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
</body>
</body>
</html>