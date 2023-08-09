<?php
$username = 'bic_user';
$password = 'bic_user';
$database = 'bic_db';
$servername='localhost';
$mysqli = new mysqli($servername, $username, $password, $database);

function addToQuery($query, $values, $first, $field) {
	$i = 0;
	$size = count($values);
	if ($size == 0) {
		return $query;
	}
	if ($first == 1) {
		if ($size > 1) {
			if ($values[0] == "other_ink_colors") {
				$query .= " WHERE ((ink_colors NOT LIKE 'rouge, noir, vert, bleu' AND ink_colors NOT LIKE 'rose, violet, vert citron, turquoise' AND ink_colors NOT LIKE 'rose, violet, orange, jaune') OR";
			} else {
				$query .= " WHERE (" .$field ." LIKE '$values[0]' OR";
			}
		} else {
			if ($values[0] == "other_ink_colors") {
				$query .= " WHERE (ink_colors NOT LIKE 'rouge, noir, vert, bleu' AND ink_colors NOT LIKE 'rose, violet, vert citron, turquoise' AND ink_colors NOT LIKE 'rose, violet, orange, jaune')";
			} else {
				$query .= " WHERE " . $field . " LIKE '$values[0]'";
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
		} else {
			$query .= " " . $field . " LIKE '$values[$i]'";
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
<section id="make_search">
	<div class="filter_menu">
		<form action="" method="GET">
			<div class="search_bar" placeholder="search">
				<input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; }?>" class="search_input" placeholder="Recherche">
				<input type="submit" value="Rechercher" />
			</div><br>
