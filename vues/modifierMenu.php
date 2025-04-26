<?php
if(!isset($_SESSION)) {
    session_start(); 
}
$idResto = isset($_GET['id']) ? $_GET['id'] : null; 
echo "<script>const restaurantId = " . json_encode($idResto) . ";</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - GFaim</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .boutonModifier{
            padding:none;
            text-decoration: none;
        }
        .boutonSupprimer{
            height:60px;
        }
    </style>
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
            afficherMonMenu($controleur->getMesItems()); 
        }
        ?>
       
                <script>
        document.addEventListener("DOMContentLoaded", function () {
           
            const boutonsSupprimer = document.querySelectorAll(".boutonSupprimer");

            boutonsSupprimer.forEach(bouton => {
                bouton.addEventListener("click", function () {
                    const itemId = this.getAttribute("data-id");

                    if (!itemId) {
                        alert("ID de l'item introuvable !");
                        return;
                    }

                    
                    if (!confirm("Voulez-vous vraiment supprimer cet item ?")) {
                        return;
                    }

                    
                    fetch(`http://localhost:8001/api/item/${itemId}`, {
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