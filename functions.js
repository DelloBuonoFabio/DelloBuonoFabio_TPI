var map;
var panel;
var direction;
var geocoder = new google.maps.Geocoder;
var name;

/**************************************
 * Projet :         MyPCConfig
 * Auteur :         Dello Buono Fabio
 * Date :           15.06.2016
 * Description :    Cette page contiens les scripts pour la géolocalisation et le calcule d'itinéraire
 **************************************/

/* verifie si le site peu utiliser la geolocalisation */
function getPosition(n) {
    if (navigator.geolocation)
    {
        name = n;
        var watchId = navigator.geolocation.getCurrentPosition(geocodeLatLng);
    }
    else
    {
        alert("Votre navigateur ne prend pas en compte la géolocalisation HTML5");
    }
}

function geocodeLatLng(position) {
    var latlng = {lat: position.coords.latitude, lng: position.coords.longitude};
    directionsService = new google.maps.DirectionsService();
    geocoder.geocode({'location': latlng}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            var tempo = results[1].formatted_address;
            document.getElementById(name).value = tempo;
        }
    });
}

/* Donne les parametres par default de la map */
function initMap() {
    var TempoIni = new google.maps.LatLng(46.2, 6.1667); // Correspond au coordonnées d'initialisation
    var myOptions = {
        zoom: 14, // Zoom par défaut
        center: TempoIni, // Coordonnées de départ
        mapTypeId: google.maps.MapTypeId.TERRAIN, // Type de carte, différentes valeurs possible HYBRID, ROADMAP, SATELLITE, TERRAIN
        maxZoom: 20,
        animation: google.maps.Animation.DROP
    };
    return myOptions;
}

/* initialize la map et utilise plusieurs fonctions */
function initialize() {

    map = new google.maps.Map(document.getElementById('Map'), initMap());
    panel = document.getElementById('panel');


    direction = new google.maps.DirectionsRenderer({
        map: map,
        panel: panel // Afficher les instructions d'itinéraire
    });
}
;

function calculate() {
    origin = document.getElementById('origin').value; // Le point départ
    destination = document.getElementById('destination').value; // Le point d'arrivé
    if (origin && destination) {
        var request = {
            origin: origin,
            destination: destination,
            travelMode: google.maps.DirectionsTravelMode.WALKING, // Mode de conduite
        }
        var directionsService = new google.maps.DirectionsService(); // Service de calcul d'itinéraire
        directionsService.route(request, function (response, status) { // Envoie de la requête pour calculer le parcours
            if (status == google.maps.DirectionsStatus.OK) {
                direction.setDirections(response); // Trace l'itinéraire sur la carte et les différentes étapes du parcours
            }
        });
    }
}
;
