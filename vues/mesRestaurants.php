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
            afficherMesRestaurants($controleur->getMesRestos());
        }
        ?>
        

        <script>
        document.addEventListener("DOMContentLoaded", function () {
          
            const boutonsSupprimer = document.querySelectorAll(".boutonSupprimer");

            boutonsSupprimer.forEach(bouton => {
                bouton.addEventListener("click", function () {
                    const restaurantId = this.getAttribute("data-id");

                    if (!restaurantId) {
                        alert("ID du restaurant introuvable !");
                        return;
                    }

                    
                    if (!confirm("Voulez-vous vraiment supprimer ce restaurant ?")) {
                        return;
                    }

                    fetch(`http://localhost:8001/api/restaurant/${restaurantId}`, {
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

                        
                        this.closest("li.article").remove();
                    })
                    .catch(error => {
                        console.error("Erreur:", error);
                        location.reload();
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