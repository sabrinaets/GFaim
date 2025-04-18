<?php
if(!isset($_SESSION)) {
    session_start(); 
}
require __DIR__ . '/../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$apiKey = $_ENV['GOOGLE_MAPS_API_KEY'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFaim - itineraire</title>
    <link rel="stylesheet" href="style.css">

    
    <style>
        #map{
            width:80%;
            height:80%;
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
    <section class="carre">
    <h1 style="Color:white;">Itineraire</h1>
    <?php
    $commande = $controleur->getCommandeAVoir();
    if (!($commande)){
        echo 'aucune commande';
    }
    else{
        $client = UserDAO::findById($commande->getIdClient());
        echo '<h2>'.htmlspecialchars($client->getUserName()).' - '
        .htmlspecialchars($client->getCodePostal()). ' - '.
        htmlspecialchars($client->getPhone()).'</h2>';
    }
    ?>

    <div  style="justify-content:center" id="map"></div>

    </section>

    <script>
        const apiKey = "<?php echo $apiKey; ?>";
        console.log("Clé API Google Maps : ", apiKey);

        console.log("Clé API Google Maps : ", apiKey);
        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initMap`; // Remplace par la clé API
        script.async = true;
        script.defer = true;
        
        // Ajoute le script à la page
        document.head.appendChild(script);

    </script>
    <script>

        function initMap(){
        var codePostal = "<?php echo htmlspecialchars($client->getCodePostal());?>";

        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ address: codePostal},function(results,status){
            if (status==="OK"){
                const location = results[0].geometry.location;

                const map = new google.maps.Map(document.getElementById("map"),{
                    zoom:14,
                    center:location,
                });

                new google.maps.Marker({
                    map:map,
                    position: location,
                });

            }
                else {
                    alert("Geocodage echoue: "+status);
                }
            
        })
   
        }
    </script>
</body>
</html>