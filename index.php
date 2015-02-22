<html>
<head>
<?php 
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
				//
			}
		}
	}
	$editicon = "<img src='https://cdn2.iconfinder.com/data/icons/flat-ui-icons-24-px/24/new-24-128.png' style='height: 16; width: 16;'>";

?>
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
</head>
<body>
<h1>ZIM2015</h1>
<h2>South America adventure</h2>
<div id="map" style="height: 500px; width: 500px;  position: relative;"></div>
<div id="table"><table>
<script>
// create a map in the "map" div, set the view to a given place and zoom
var map = L.map('map').setView([-33.4500, -70.6667], 8);

// add an OpenStreetMap tile layer
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Add event to map.
var travelevents = <?php echo json_encode($travelevents); ?>;
var latlngs = [];
if (travelevents) {
	console.log(travelevents[0]);
	var headers = [];
	document.write('<tr><th>action</th>');
	for (var i = 1; i < Object.keys((travelevents)[0]).length; i++) {
		headers[i] = Object.keys((travelevents)[0])[i];
		document.write('<th>' + headers[i] + '</th>');
	}
	document.write('</tr>');
	for (var i = 0; i < travelevents.length - 1; i++) {
		document.write('<tr>');
		document.write("<td><?php echo $editicon; ?></td>"); // Empty for now.
		for (var j = 1; j < Object.keys((travelevents)[0]).length; j++) {
			document.write('<td>' + travelevents[i][headers[j]] + '</td>');
		}
		latlngs.push(new L.LatLng(travelevents[i].lat, travelevents[i].long));
		L.marker([travelevents[i].lat, travelevents[i].long]).addTo(map)
	    .bindPopup(travelevents[i].title)
	    .openPopup();
	    document.write('</tr>');
	};
	console.log(latlngs);
	var polyline = L.polyline(latlngs, {color: 'red'}).addTo(map);
	
}
    </script>
    </table>
    </div>
</body>
</html>