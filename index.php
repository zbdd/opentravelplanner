<html>
<head>
<?php
	require_once('config.php');
	$connection = mysqli_connect('localhost', 'root', '', 'zimtravel');
	// Error on fail.
	if (mysqli_connect_errno()) {
		echo 'Problem DB101.';
	}

	if ($connection) {
		$result = $connection->query("SELECT * FROM travelevent");
		$travelevents = array();
		if ($result) {
			while ($travelevents[] = $result->fetch_assoc()) {
				// Build array.
			}
		}
	}
	$editicon = "<img src='https://cdn2.iconfinder.com/data/icons/flat-ui-icons-24-px/24/new-24-128.png' style='height: 16; width: 16;'>";

	// Init table.
	$table = "<table><tr>";

	// Table headers.
	foreach (array_slice($travelevents[0], 1) as $key => $value) {
		$table = $table . "<th>" . $key . "</th>";
	}
	$table = $table . "</tr>";

	// Table content.
	foreach ($travelevents as $key => $value) {
		if ($value) {
			$table = $table . "<tr>";	
			foreach (array_slice($value, 1) as $key => $value) {
				$table = $table . "<td>" . $value . "</td>";
			}
			$table = $table . "</tr>";
		}
	}

	// Table end.
	$table = $table . "</table>";

?>
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
</head>
<body>
<h1>ZIM2015</h1>
<h2>South America adventure</h2>
<div id="map" style="height: 500px; width: 500px;  position: relative;"></div>
<div id="table"><?php echo $table; ?></div>
</body>
<script>
// create a map in the "map" div, set the view to a given place and zoom
var map = L.map('map').setView([-33.4500, -70.6667], 8);
refreshMap();

// add an OpenStreetMap tile layer
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Add event to map.
function refreshMap() {
	var travelevents = <?php echo json_encode($travelevents); ?>;
	var latlngs = [];

	if (travelevents) {
		for (var i = 0; i < travelevents.length - 1; i++) {
			latlngs.push(new L.LatLng(travelevents[i].lat, travelevents[i].long));
			L.marker([travelevents[i].lat, travelevents[i].long]).addTo(map)
		    .bindPopup(travelevents[i].title)
		    .openPopup();
		};

		var polyline = L.polyline(latlngs, {color: 'red'}).addTo(map);
	}
}
</script>
</html>