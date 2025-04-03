<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFaim - livraison de repas</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
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
        
        <div class="panier hidden">
            <h2>Mon panier</h2>
            <div class="panier-items">
                <div class="panier-item">
                   
                        <div>
                        <h3>Item 1</h3>
                        <p>Prix: 10$</p>
                        </div>
                        <a><i class="fa-solid fa-x"></i></a>
                    
                </div>
                <div class="panier-item">
                    
                        <div>
                        <h3>Item 1</h3>
                        <p>Prix: 10$</p>
                        </div>
                        <a><i class="fa-solid fa-x"></i></a>
                    
                </div>
                <div class="panier-item">
                    
                        <div>
                        <h3>Item 1</h3>
                        <p>Prix: 10$</p>
                        </div>
                        <a><i class="fa-solid fa-x"></i></a>
                   
                </div>
            </div>
            <div class="total">
                <h2>Total: 0$</h2>
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
    <script src="vues/fonctions/fonctions.js"></script>
    
</body>
</html>