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
			$query .= " WHERE (" .$field ." LIKE '%$values[0]%' OR";
		} else {
			$query .= " WHERE " . $field . " LIKE '%$values[0]%'";
			return $query;
		}
		$i++;
	} else {
		$query .= " AND (";
	}
	for (;$i < $size; $i++) {
		$query .= " " . $field . " LIKE '%$values[$i]%'";
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
				<input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; }?>" class="search_input" placeholder="Search">
			</div><br>
