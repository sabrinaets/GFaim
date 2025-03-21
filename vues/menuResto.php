<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFaim - livraison de repas</title>
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

    <main class="main" id="main-menu">
        <button id="toggle-panier">🛒 Fermer</button>
        <div class="panier">
            <h1>Mon panier</h1>
            <div class="panier-items">
                <div class="panier-item">
                    <div>
                        <h3>Item 1</h3>
                        <p>Prix: 10$</p>
                        <a>Retirer du panier</a>
                    </div>
                </div>
                <div class="panier-item">
                    <div>
                        <h3>Item 1</h3>
                        <p>Prix: 10$</p>
                        <a>Retirer du panier</a>
                    </div>
                </div>
                <div class="panier-item">
                    <div>
                        <h3>Item 1</h3>
                        <p>Prix: 10$</p>
                        <a>Retirer du panier</a>
                    </div>
                </div>
            </div>
            <div class="total">
                <br>
                <h2>Total: 30$</h2>
                <a class="commander-panier">Commander</a>
            </div>
        </div>

        <div class="carreMenu">
            <div class="menuResto">
                <h1 id="resto-nom">Restaurant l'escondite</h1>
                <br>
                <h2> - Menu - </h2>
                <div id="menu">
                    <div class="menu-item">
                        <img src="images/imageBurger.jpg" alt="burger" width ="250px" height="250px">
                        <div class="item-info">
                        <h3>Item 1</h3>
                        <p>Description de l'item 1</p>
                        <p>Prix: 10$</p>
                        <a>Ajouter au panier</a>
                        </div>
                    </div>
                    <div class="menu-item">
                        <img src="images/imageBurger.jpg" alt="burger" width ="250px" height="250px">
                        <div class="item-info">
                        <h3>Item 1</h3>
                        <p>Description de l'item 1</p>
                        <p>Prix: 10$</p>
                        <a>Ajouter au panier</a>
                        </div>
                    </div>
                    <div class="menu-item">
                        <img src="images/imageBurger.jpg" alt="burger" width ="250px" height="250px">
                        <div class="item-info">
                        <h3>Item 1</h3>
                        <p>Description de l'item 1</p>
                        <p>Prix: 10$</p>
                        <a>Ajouter au panier</a>
                        </div>
                    </div>
                </div>
            
        </div>
    </div>
    </main>
    <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
    <script>
        document.getElementById("toggle-panier").addEventListener("click", function () {
            let panier = document.querySelector(".panier");
            panier.classList.toggle("hidden");
            this.textContent = panier.classList.contains("hidden") ? "🛒 Ouvrir" : "🛒 Fermer";
        });
    </script>
    
</body>
</html>