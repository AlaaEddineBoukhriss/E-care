<?php

require '.././vendor/autoload.php';
use Geocoder\Query\GeocodeQuery;
use Geocoder\Query\ReverseQuery;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medical";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM pharmacie";
$result = $conn->query($sql);

  $row = $result->fetch_assoc();
$httpClient = new \Http\Adapter\Guzzle6\Client();
        $provider = new \Geocoder\Provider\GoogleMaps\GoogleMaps($httpClient, null, 'AIzaSyCO6wmjvTDxFZwuR0Kn4qZmXqrIik8swDo');
        $geocoder = new \Geocoder\StatefulGeocoder($provider, 'en');



        //$rs = $geocoder->geocodeQuery(GeocodeQuery::create('Buckingham Palace, London'));
        //$result = $geocoder->reverseQuery(ReverseQuery::fromCoordinates(...));
        //dd($rs->first()->getCoordinates()->getLongitude());
		//dd($result->id);
		//dd($result->locations[0]);

// Demo locations
/*
$locations = array(
    array(
        'address' => '3324 N California Ave, Chicago, IL, 60618',
        'title' => 'Hot Dougs',
    ),
    array(
        'address' => '11 S White, Frankfort, IL, 60423',
        'title' => 'Museum',
    ),
    array(
        'address' => '1000 Sterling Ave, , Flossmoor, IL, 60422',
        'title' => 'Library',
    ),
    array(
        'address' => '2053 Ridge Rd, Homewood, IL, 60430',
        'title' => 'Twisted Q',
    )
);
*/

$mapdata = $marker_group = array();

foreach ($row as $key => $data) {
    // Try to geocode.
    try {
        $geocode =  $geocoder->geocodeQuery(GeocodeQuery::create($data.adresse));
        $longitude = $geocode->first()->getCoordinates()->getLongitude();
        $latitude = $geocode->first()->getCoordinates()->getLatitude();

        // Create map data array
        $mapdata[$key]['latitude'] = $latitude;
		$mapdata[$key]['longitude'] = $longitude;
		$mapdata[$key]['nom'] = $data.nom;
		$mapdata[$key]['adresse'] = $data.adresse;

        // Marker grouping array
        $marker_group[] = "marker{$key}";

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
//dd($mapdata);

function markerCreator($lat, $long, $label, $key) {
    return "var marker{$key} = L.marker([{$lat}, {$long}]).addTo(map);
    marker{$key}.bindPopup(\"{$label}\");";
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>A simple map for with Geocoder PHP and Leaflet.js</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.leafletjs.com/leaflet-0.6.4/leaflet.css" />
    <script src="//cdn.leafletjs.com/leaflet-0.6.4/leaflet.js"></script>
    <style>
        #mapCanvas {
    width: 100%;
    height: 650px;
}
    </style>
</head>

<body>

<div class="container">

    <div class="row">

        <div class="col-lg-12 page-header"><h1 id="header">A simple map with Geocoder PHP and Leaflet.js</h1></div>
        <div class="row-fluid">
            <div class="col-lg-8">

			<div id="mapCanvas"></div>


        </div>

    </div>

</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script>
function initMap() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
                    
    /* Display a map on the web page */
    map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
    map.setTilt(100);
        
    /* Multiple markers location, latitude, and longitude */
    var markers = <?php echo $mapdata; ?>;
                        
    /* Info window content */
    var infoWindowContent = [
        <?php
            while($mapdata){ ?>
                ['<div class="info_content">' +
                '<h3><?php echo $mapdata['nom']; ?></h3>' +
                '<p><?php echo $mapdata['adresse']; ?></p>' + '</div>'],
        <?php } 
       
        ?>
    ];
        
     /* Add multiple markers to map */
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
     /* Place each marker on the map  */
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][0], markers[i][1]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][2]
        });
        
         /* Add info window to marker   */
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][2]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

       /* Center the map to fit all markers on the screen */
        map.fitBounds(bounds);
    }

   /* Set zoom level */
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(14);
        google.maps.event.removeListener(boundsListener);
    });
}

/* Load initialize function */
google.maps.event.addDomListener(window, 'load', initMap);
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCO6wmjvTDxFZwuR0Kn4qZmXqrIik8swDo"></script>

</body>

</html>