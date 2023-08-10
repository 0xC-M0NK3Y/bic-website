<?php
$username = 'bic_user';
$password = 'bic_user';
$database = 'bic_db';
$servername='localhost';
$mysqli = new mysqli($servername, $username, $password, $database);

function addToQuery($query, $values, $first, $field, $match_strict) {
	$i = 0;
	$size = count($values);
	if ($size == 0) {
		return $query;
	}
	// bool for noobs (jk im just a c monkey)
	if ($first == 1) {
		if ($size > 1) {
			if ($values[0] == "other_ink_colors") {
				$query .= " WHERE ((ink_colors NOT LIKE 'rouge, noir, vert, bleu' AND ink_colors NOT LIKE 'rose, violet, vert citron, turquoise' AND ink_colors NOT LIKE 'rose, violet, orange, jaune') OR";
			} elseif ($match_strict == 1) {
				$query .= " WHERE (" .$field ." LIKE '$values[0]' OR";
			} else {
				$query .= " WHERE (" .$field ." LIKE '%$values[0]%' OR";
			}
		} else {
			if ($values[0] == "other_ink_colors") {
				$query .= " WHERE (ink_colors NOT LIKE 'rouge, noir, vert, bleu' AND ink_colors NOT LIKE 'rose, violet, vert citron, turquoise' AND ink_colors NOT LIKE 'rose, violet, orange, jaune')";
			} elseif ($match_strict == 1) {
				$query .= " WHERE " . $field . " LIKE '$values[0]'";
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
			$query .= " (ink_colors NOT LIKE 'rouge, noir, vert, bleu' AND ink_colors NOT LIKE 'rose, violet, vert citron, turquoise' AND ink_colors NOT LIKE 'rose, violet, orange, jaune')";
		} elseif ($match_strict == 1) {
			$query .= " " . $field . " LIKE '$values[$i]'";
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

if ($mysqli->connect_error) {
	die('Connect Error (' .
	$mysqli->connect_errno . ') '.
	$mysqli->connect_error);
}

$first = 1;
$query = "SELECT * FROM pen";

if (isset($_GET['top'])) {
	$query = addToQuery($query, $_GET['top'], $first, "top", 1);
	$first = 0;	}
if (isset($_GET['ring_color'])) {
	$query = addToQuery($query, $_GET['ring_color'], $first, "ring_color", 1);
	$first = 0; }
if (isset($_GET['tube_color'])) {
	$query = addToQuery($query, $_GET['tube_color'], $first, "tube_color", 1);
	$first = 0; }
if (isset($_GET['family'])) {
	$query = addToQuery($query, $_GET['family'], $first, "family", 1);
	$first = 0; }
if (isset($_GET['ink_colors'])) {
	$query = addToQuery($query, $_GET['ink_colors'], $first, "ink_colors", 1);
	$first = 0;	}
if (isset($_GET['rarity'])) {
	$query = addToQuery($query, $_GET['rarity'], $first, "rarity", 1);
	$first = 0;	}
if (isset($_GET['tag'])) {
	$query = addToQuery($query, $_GET['tag'], $first, "tag", 0);
	$first = 0;	}

if (isset($_GET['search'])) {
	$search_value = $_GET['search'];
	if ($first == 1) {
		$query .= " WHERE name LIKE '%$search_value%'";
	} else {
		$query .= " AND name LIKE '%$search_value%'";
	}
}
$result = $mysqli->query($query);
$tmp = explode('*', $query);
$count_query = $tmp[0] . "COUNT(*) as cnt" . $tmp[1];
$result_len = $mysqli->query($count_query);
$total_pens = $result_len->fetch_assoc();
$total = $total_pens['cnt'];
$mysqli->close();

$DISPLAY_TYPES=["none;", "block;"];
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>BIC COLLECTION</title>
	<header class="header">
		<div class="header-inner wrapper">
			<h1 class="title">
				Unofficial Bic Collection
			</h1>
			<!-- /.title -->
		</div>
		<link rel="stylesheet" href="index.css">
		<!-- /.header-inner wrapper -->
	</header>
	<!-- /.header -->
</head>
<body>
<script src="index.js"></script>
<main class="main" role="main">
<label class="total_count">
	Total: <?php echo $total; ?>
</label>
<section id="make_search">
	<div class="filter_menu">
		<form action="" method="GET">
			<div class="search_bar" placeholder="search">
				<input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; }?>" class="search_input" placeholder="Recherche" style="height: 28px; border-radius: 5px; color: #000000;">
				<input type="submit" value="Rechercher" style="width: 105px; color: black; height: 28px; border-radius: 8px;" />
			</div><br>
