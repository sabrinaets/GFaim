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
    <title>GFaim - Localiser</title>
    <link rel="stylesheet" href="style.css">

    
    <style>
        #map{
            width:80%;
            height:70%;
        }
        .carre{
            display:flex;
            justify-content: center;
            height:700px;
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

    <?php

    if (!isset($_GET['id'])){
        echo "Aucun utilisateur connecte";
    }
    else{
        $commande =commandeDAO::findById($_GET['id']);
        $client = UserDAO::findById($commande->getIdClient());
        $restaurant = RestaurantDao::findById($commande->getIdRestaurant());

        //Recuperer la position du livreur si il a bien pris la commande
        if ($commande->getIdLivreur()===null){
            echo "Aucun livreur n'a pris en charge votre commande";
        }
        else{
            $idLivreur = $commande->getIdLivreur();
            $coordsLivreur = UserDAO::getPositionLivreur($idLivreur);
            $latLivreur = $coordsLivreur['latitude'];
            $lngLivreur = $coordsLivreur['longitude'];
        }
    }

    if (isset($latLivreur) && isset($lngLivreur)) {
        echo "<script>const latitude = " . json_encode($latLivreur) . ";
                      const longitude = " . json_encode($lngLivreur) . ";
              </script>";
    } else {
        echo "<script>alert('Le livreur n\'a pas encore été localisé.');</script>";
    }
    ?>
    <section class="carre">
        <h1>Localiser le livreur</h1>
        <div id=map></div>
        <div id="infos-trajet" style="margin-top:5px; font-weight: bold;"></div>
    </section>    
    <script>

        const apiKey = "<?php echo $apiKey; ?>";

        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initMap`; // Remplace par la clé API
        script.async = true;
        script.defer = true;

        // Ajoute le script a la page
        document.head.appendChild(script);


        
        let map;
        let infoWindow;
        let posClient,posLivreur,posResto;

        //Recuperer les coordonnees de l'emplacement du livreur

        posLivreur = {
            lat: parseFloat(latitude),
            lng: parseFloat(longitude)
        };

        function initMap(){
            var codePostal = "<?php echo htmlspecialchars($client->getCodePostal());?>";
            var adresseResto = "<?php echo htmlspecialchars($restaurant->getAdresse());?>";

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
                    title:"Vous êtes ici."
                });

                new google.maps.Marker({
                    map:map,
                    position:posLivreur,
                    title:"Votre livreur.",
                    icon: {
                        url: "https://images.icon-icons.com/1863/PNG/512/person-pin-circle_118813.png",
                        scaledSize: new google.maps.Size(35, 50)
                    }
                });


                //Geolocaliser le resto
                geocoder.geocode({address:adresseResto},function(resultsResto,statusResto){
                    if (statusResto ==="OK"){
                        posResto = resultsResto[0].geometry.location;

                        

                        new google.maps.Marker({
                            map:map,
                            position:posResto,
                            title:"Le restaurant.",
                            icon: {
                                url: "https://wallpapers.com/images/hd/burger-location-pin-icon-v4wiwz3aabk3mfgh.png",
                                scaledSize: new google.maps.Size(40, 50)
                            }
                        });

                       
                        setInterval(updateLivreurPosition, 10000);

                        updateLivreurPosition();

                        distanceLivreur();
                    }
                    else{
                        alert("Geocodage du resto echoue"+statusResto);
                        console.log(statusResto);
                    }
                })
        }
        else{
            alert("Geocodage du client echoue: "+status);
        }
    })

   
}
let livreurMarker;

function updateLivreurPosition() {
    fetch(`../api/get_position_livreur.php?idLivreur=<?php echo $idLivreur; ?>`)
        .then(response => response.json())
        .then(data => {
            const nouvellePosition = {
                lat: parseFloat(data.latitude),
                lng: parseFloat(data.longitude)
            };

            if (livreurMarker) {
                console.log("Coordonnées mises à jour du livreur :", data);
                livreurMarker.setPosition(nouvellePosition);
            } else {
                livreurMarker = new google.maps.Marker({
                    map: map,
                    position: nouvellePosition,
                    title: "Votre livreur.",
                    icon: {
                        url: "https://images.icon-icons.com/1863/PNG/512/person-pin-circle_118813.png",
                        scaledSize: new google.maps.Size(35, 50)
                    }
                });
            }

            posLivreur = nouvellePosition;
            distanceLivreur();
        })
        .catch(error => {
            console.error("Erreur mise à jour position livreur :", error);
        });
}

    function distanceLivreur(){
        
        const distanceService = new google.maps.DistanceMatrixService();
        distanceService.getDistanceMatrix(
            {
                origins:[posLivreur],
                destinations:[posResto,posClient],
                travelMode:google.maps.TravelMode.DRIVING,
                unitSystem:google.maps.UnitSystem.METRIC,
            },
        
        (distanceResponse,distanceStatus)=>{
            if (distanceStatus === "OK"){
                const toResto = distanceResponse.rows[0].elements[0];
                const toClient = distanceResponse.rows[0].elements[1];

                const totalDistance = toResto.distance.value + toClient.distance.value;
                const totalDuration = toResto.duration.value + toClient.duration.value;

                const infosDiv = document.getElementById("infos-trajet");
                infosDiv.innerHTML = `Trajet restant : ${(totalDistance / 1000).toFixed(2)} km, durée estimée : ${(totalDuration / 60).toFixed(1)} min`;
            }
            else{
                console.error("Erreur distance matrix: ",+distanceStatus);
            }
        })
    
    }
    </script>
</body>
</html>