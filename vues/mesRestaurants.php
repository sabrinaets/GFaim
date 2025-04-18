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
        <h1>Voici vos Restaurants</h1>
        <?php if($controleur->isAdmin()):?>
        <a class="boutonAjouter"href="?action=ajouterResto">Nouveau Restaurant</a>
        <?php endif; ?>
        <?php if(!$controleur->isAdmin()):?>
            <h2>Pour ouvrir un Nouveau restaurant</h2>
            <a class="boutonAjouter"href="mailto:GFaim@gmail.com?subject=Demande%20d'ouverture%20de%20restaurant">Nous contacter</a>
        <?php endif; ?>

        <?php
        if(empty($controleur->getMesRestos()))
        {
            echo "<h1>Aucun restaurant trouvé</h1>";
        }
        else{
            afficherMesRestaurants($controleur->getMesRestos()); // Affiche la liste des restaurants
        }
        ?>
        <!---<ul class="liste-commandes">
            <li class="article">
                <a href="?action=voirMonMenu" style="font-size: 24px; font-weight: bold; color: #D2691E; text-transform: uppercase; height: 40px; line-height: 50px; margin-top: 10px;">
                Trois Amigos</a><br>
                <span class="description" style ="margin-top: 20px;">Un restaurant servant les meilleurs plats mexicain au monde du fameux tacos au queso fondido</span><br>
                <a class="boutonModifier" href="?action=modifierResto">Modifier Restaurant</a>
                <button class="boutonSupprimer">Supprimer</button>
            </li>
        </ul>--->

        <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Sélectionner tous les boutons de suppression
            const boutonsSupprimer = document.querySelectorAll(".boutonSupprimer");

            boutonsSupprimer.forEach(bouton => {
                bouton.addEventListener("click", function () {
                    const restaurantId = this.getAttribute("data-id");

                    if (!restaurantId) {
                        alert("ID du restaurant introuvable !");
                        return;
                    }

                    // Demander confirmation avant de supprimer
                    if (!confirm("Voulez-vous vraiment supprimer ce restaurant ?")) {
                        return;
                    }

                    // Envoyer une requête DELETE à l'API
                    fetch(`http://localhost:9090/PROJETWEB/api/restaurant/${restaurantId}`, {
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
                        alert("Restaurant supprimé avec succès !");
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