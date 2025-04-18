
<?php
if(!isset($_SESSION)) {
    session_start(); 
}
//Jai du installer composer puis telecharger la librairie phpdotenv (composer require vlucas/phpdotenv)
//nos cles dapi sont dans le .env sous la variable 'GOOGLE_MAPS_API_KEY'

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
        .carre{
            display:flex;
            justify-content: center;
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
        $restaurant = RestaurantDao::findById($commande->getIdRestaurant());
    }
    ?>

    <div id="map"></div>

    </section>

    <script>
        const apiKey = "<?php echo $apiKey; ?>";

        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initMap`; // Remplace par la clé API
        script.async = true;
        script.defer = true;
        
        // Ajoute le script à la page
        document.head.appendChild(script);


        let map;
        let infoWindow;
        let posClient,posResto,posLivreur;

        function initMap(){
        var codePostal = "<?php echo htmlspecialchars($client->getCodePostal());?>";
        var adresseResto = "<?php echo htmlspecialchars($restaurant->getAdresse())?>";

        console.log(adresseResto);
        const geocoder = new google.maps.Geocoder();


        //geolocaliser le client
        geocoder.geocode({ address: codePostal},function(results,status){
            if (status==="OK"){
                posClient = results[0].geometry.location;

                map = new google.maps.Map(document.getElementById("map"),{
                    zoom:12,
                    center:posClient,
                });

                infoWindow = new google.maps.InfoWindow();

                new google.maps.Marker({
                    map:map,
                    position: posClient,
                    title:"Client"
                });


                //Geolocaliser le resto
                geocoder.geocode({ address:adresseResto},function(resultsResto,statusResto){
                    if (statusResto==="OK"){
                        posResto = resultsResto[0].geometry.location;

                        new google.maps.Marker({
                            map: map,
                            position: posResto,
                            title: "Restaurant",
                           
                        });



                        //Geolocaliser le livreur
                        if (navigator.geolocation){
                            navigator.geolocation.getCurrentPosition(
                            (position)=>{
                            posLivreur = {
                                lat:position.coords.latitude,
                                lng: position.coords.longitude,
                            };
                            infoWindow.setPosition(posLivreur);
                            infoWindow.setContent("Votre position.");
                            infoWindow.open(map);
                            map.setCenter(posLivreur);

                            tracerItineraire();
                        },
                        ()=>{
                             handleLocationError(true,infoWindow,map.getCenter());
                        }
                    );
                        }
                        else{
                            //Si le navigateur n'a pas active la localisation
                            handleLocationError(false, infoWindow, map.getCenter());
                        }
                    }
                    else{
                        alert("Geocodage du resto echoue"+statusResto);
                        console.log(statusResto);
                    }
                })

            }
                else {
                    alert("Geocodage du client echoue: "+status);
                }
            
        })
   
    
        function handleLocationError(browserHasGeolocation, infoWindow, pos){
            infoWindow.setPosition(posLivreur);
            infoWindow.setContent(
            browserHasGeolocation ? "Erreur : le service de géolocalisation a échoué.": "Erreur : votre navigateur ne supporte pas la géolocalisation."
        );
        infoWindow.open(map);
        }


        //Itineraire du livreur, au restaurant jusqu'a chez le client
        function tracerItineraire(){
        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer();

        directionsRenderer.setMap(map);

        directionsService.route(
            {
                origin:posLivreur,
                destination:posClient,
                waypoints:[
                    {location:posResto,stopover:true}
                ],
                travelMode: google.maps.TravelMode.DRIVING,
            },
            (response,status)=>{
                if (status === "OK"){
                    directionsRenderer.setDirections(response);
                }
                else{
                    alert("Impossible de tracer l'itinéraire"+status);
                }
            }
        )
    }
}
    </script>
        <footer>
        <p>@2025 tous droits reservés GFaim</p>
    </footer>
</body>
</html>