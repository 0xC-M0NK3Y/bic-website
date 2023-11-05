<?php
/* start session */
session_start();

/* database logins */
$username = 'bic_user';
$password = 'bic_user';
$database = 'bic_db';
$servername='localhost';

/* Connect to database */
$mysqli = new mysqli($servername, $username, $password, $database);
if ($mysqli->connect_error) {
	die('Connect Error (' .
	$mysqli->connect_errno . ') '.
	$mysqli->connect_error);
}

/* Functions */
function intersect($v, $w) {
	$lv = strlen($v);
	$lw = strlen($w);
	$m = min($lv, $lw);
	for ($i = 0; $i < $m; $i++) {
		 if ($v[$i] != $w[$i]) {
			return substr($v, 0, $i);
		}
	}
	if ($lv <= $lw) {
		 return $v;
	}
	return $w;
}
function tronque($w) {
	$w = trim($w);
	$lw = strlen($w);
	if ($w[$lw - 1] == '(' || $w[$lw - 1] == ',') {
		 $w = substr($w, 0, -1);
	}
	return trim($w);
}
function isInList($val, $list, $list_len) {
	for ($i = 0; $i < $list_len; $i++) {
		if ($val == $list[$i]) {
			return 1;
		}
	}
	return 0;
}
function addToQuery($mysqli, $query, $values, $first, $field, $match_strict) {
	$i = 0;
	$size = count($values);
	if ($size == 0) {
		return $query;
	}
	for ($j = 0; $j < $size; $j++) {
		$values[$j] = $mysqli->real_escape_string($values[$j]);
	}
	if ($first == 1) {
		if ($size > 1) {
			if ($values[0] == "other_ink_colors") {
				$query .= " WHERE ((ink_colors!='rouge, noir, vert, bleu' AND ink_colors!='rose, violet, vert citron, turquoise' AND ink_colors!='rose, violet, orange, jaune') OR";
			} elseif ($match_strict == 1) {
				$query .= " WHERE (" .$field ."='$values[0]' OR";
			} else {
				$query .= " WHERE (" .$field ." LIKE '%$values[0]%' OR";
			}
		} else {
			if ($values[0] == "other_ink_colors") {
				$query .= " WHERE (ink_colors!='rouge, noir, vert, bleu' AND ink_colors!='rose, violet, vert citron, turquoise' AND ink_colors!='rose, violet, orange, jaune')";
			} elseif ($match_strict == 1) {
				$query .= " WHERE " . $field . "='$values[0]'";
			} else {
				$query .= " WHERE " . $field . " LIKE '%$values[0]%'";
			}
			return $query;
		}
		$i++;
	} else {
		$query .= " AND (";
	}
	for (;$i < $size; $i++) {
		if ($values[$i] == "other_ink_colors") {
			$query .= " (ink_colors!='rouge, noir, vert, bleu' AND ink_colors!='rose, violet, vert citron, turquoise' AND ink_colors!='rose, violet, orange, jaune')";
		} elseif ($match_strict == 1) {
			$query .= " " . $field . "='$values[$i]'";
		} else {
			$query .= " " . $field . " LIKE '%$values[$i]%'";
		}
		if ($i != $size-1) {
			$query .= " OR";
		}
	}
	$query .= ")";
	return $query;
}

/* Create the principal query*/
$first = 1;
$query = "SELECT latitude,longitude,name FROM pen";
if (isset($_GET['top'])) {
	$query = addToQuery($mysqli, $query, $_GET['top'], $first, "top", 1);
	$first = 0;	}
if (isset($_GET['ring_color'])) {
	$query = addToQuery($mysqli, $query, $_GET['ring_color'], $first, "ring_color", 1);
	$first = 0; }
if (isset($_GET['tube_color'])) {
	$query = addToQuery($mysqli, $query, $_GET['tube_color'], $first, "tube_color", 1);
	$first = 0; }
if (isset($_GET['tube_finish'])) {
	$query = addToQuery($mysqli, $query, $_GET['tube_finish'], $first, "tube_finish", 1);
	$first = 0; }
if (isset($_GET['family'])) {
	$query = addToQuery($mysqli, $query, $_GET['family'], $first, "family", 0);
	$first = 0; }
if (isset($_GET['ink_colors'])) {
	$query = addToQuery($mysqli, $query, $_GET['ink_colors'], $first, "ink_colors", 1);
	$first = 0;	}
if (isset($_GET['rarity'])) {
	$query = addToQuery($mysqli, $query, $_GET['rarity'], $first, "rarity", 1);
	$first = 0;	}
if (isset($_GET['tag'])) {
	$query = addToQuery($mysqli, $query, $_GET['tag'], $first, "tag", 0);
	$first = 0;	}
if (isset($_GET['search'])) {
	$search_value = $mysqli->real_escape_string($_GET['search']);
	$search_value = trim($search_value);
	if ($first == 1) {
		$query .= " WHERE name LIKE '%$search_value%'";
		$first = 0;
	} else {
		$query .= " AND name LIKE '%$search_value%'";
	}
}
if ($first == 1) {
	$query .= " WHERE latitude IS NOT NULL ORDER BY latitude";
} else {
	$query .= " AND latitude IS NOT NULL ORDER BY latitude";
}

/* Execute principal query and count query */
$result = $mysqli->query($query);
/* Close database connection */
$mysqli->close();

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="icon" type="image/png" href="./favicon.png" >
		<link rel="apple-touch-icon" type="image/png" href="./favicon.png" >
		<link rel="apple-touch-icon-precomposed" type="image/png" href="./favicon.png" >
		<link rel="shortcut icon" type="image/png" href="./favicon.png" >
		<script src="https://maps.google.com/maps/api/js?key=AIzaSyAle_MVu3GIXvuMBct9khTPcEfnWPg8Tms" type="text/javascript"></script>
		<script async type="text/javascript">
			var centerLat = 46.227638;
			var centerLon = 2.213749;
			var map = null;
			var markers = [
<?php

	$tab = $result->fetch_all(MYSQLI_NUM);
	$label = 1;
	$mot = $tab[0][2];
	$size = count($tab);
	for ($i = 0; $i <= ($size-2); $i++) {
		$latitude = $tab[$i][0];
		$longitude = $tab[$i][1];
		if ($latitude == $tab[$i + 1][0] && $longitude == $tab[$i + 1][1]) {
			$mot = intersect($mot, $tab[$i + 1][2]);
			$label++;
		} else {
			echo "\t\t\t\t[" . $latitude . ', ' . $longitude . ', "' . tronque($mot) . '", "' . $label . '"],' . PHP_EOL;
			$label = 1;
			$mot = $tab[$i + 1][2];
		}
	}
	echo "\t\t\t\t[" . $tab[$size - 1][0] . ', ' . $tab[$size - 1][1] . ', "' . tronque($mot) . '", "' . $label . '"]' . PHP_EOL;
	
?>
            ];
			function initMap() {
				map = new google.maps.Map(document.getElementById("map"), {
					center: new google.maps.LatLng(centerLat, centerLon),
					zoom: 6,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					mapTypeControl: true,
					mapTypeControlOptions: {
						style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
					},
                    scaleControl: true,
					scrollwheel: true,
					navigationControl: true,
					navigationControlOptions: {
						style: google.maps.NavigationControlStyle.ZOOM_PAN
					}
				});

				for (let i = 0; i < markers.length; i++) {
					var marker = new google.maps.Marker({
						title: markers[i][2],
                        label: markers[i][3],
						position: {lat: markers[i][0], lng: markers[i][1]},
                        map: map,
					});
					var popup = new google.maps.InfoWindow();
                    google.maps.event.addListener(marker,"click",()=>{
                        popup.setContent('<a href="https://bicophile.fr/?search=' + markers[i][2] + '">' + markers[i][2] + '</a>');
                        popup.setPosition({lat: markers[i][0], lng: markers[i][1]});
                        popup.open(map);
                    })
				}
			}

			window.onload = function(){
				initMap(); 
                document.getElementById("map").setAttribute("style", "height: " + (window.innerHeight - 20) +"px;");
				stylei = localStorage.getItem("styleact");
				if (stylei != null) {
					map.setMapTypeId(stylei);
				}
				
				zoomi = parseInt(localStorage.getItem("zoomact"));
				if (!(isNaN(zoomi))) {
					map.setZoom(zoomi);
				}
				
				lati = parseFloat(localStorage.getItem("latact")).toFixed(6);
				lngi = parseFloat(localStorage.getItem("lngact")).toFixed(6);
				if (typeof lati == undefined) {
					lati = 46.227638;
				}
				if (typeof lngi == undefined) {
					lngi = 2.213749;
				}
				map.setCenter(new google.maps.LatLng(lati, lngi));
			}

			window.onunload = function(){
				localStorage.setItem("styleact", map.getMapTypeId());
				localStorage.setItem("zoomact", map.getZoom());
				latiact = map.getCenter().lat();
				lngiact = map.getCenter().lng();
				localStorage.setItem("latact", latiact);
				localStorage.setItem("lngact", lngiact);
			}

		</script>
		<title>Carte</title>
	</head>
	<body>
		<div id="map">
		</div>
	</body>
</html>
