
let trackingStarted = false;
function envoyerPositionLivreur(idLivreur){

    if (trackingStarted){return};
    
    trackingStarted = true;
    if (!navigator.geolocation) {
        console.warn("Géolocalisation non supportée par le navigateur.");
        return;
      }
    setInterval(()=>{
        navigator.geolocation.getCurrentPosition(position=>
            fetch("../../api/update_position.php", {
                method:"POST",
                headers:{"Content-Type":"application/json"},
                body:JSON.stringify({
                    idLivreur: idLivreur,
                    latitude:position.coords.latitude,
                    longitude:position.coords.longitude
                })
            })
            .then(response=>response.text())
            .then(data=>{
                console.log("Position envoyée:",data);
            })
            .catch(error =>{
                console.error("Erreur lors de l'envoi de la position: ",error);
            })
        )
    },10000)
}