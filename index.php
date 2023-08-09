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
			<div class="filter checkboxes-container">
				<div class="filter_title" onclick="toggleValues('familyShow','familyFilter')">
					<span class="filter_name">Famille</span>
					<input type="hidden" name="family_show" value="<?php if(!isset($_GET['family_show'])){echo '0';}else{echo $_GET['family_show'];}?>" id="familyShow">
				</div>
				<div class="filters_values" style="display: <?php if(isset($_GET['family_show'])){echo $DISPLAY_TYPES[intval($_GET['family_show'],10)];}else{echo 'none;';} ?>" id="familyFilter">
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">basique</span>
							<input type="checkbox" name="family[]" value="basique" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('basique',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">uni</span>
							<input type="checkbox" name="family[]" value="uni" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('uni',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">grip</span>
							<input type="checkbox" name="family[]" value="grip" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('grip',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">protoype</span>
							<input type="checkbox" name="family[]" value="protoype" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('protoype',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">2 couleurs</span>
							<input type="checkbox" name="family[]" value="2 couleurs" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('2 couleurs',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">décor</span>
							<input type="checkbox" name="family[]" value="décor" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('décor',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">édition limitée</span>
							<input type="checkbox" name="family[]" value="édition limitée" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('édition limitée',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">message</span>
							<input type="checkbox" name="family[]" value="message" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('message',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">musée</span>
							<input type="checkbox" name="family[]" value="musée" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('musée',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">pub</span>
							<input type="checkbox" name="family[]" value="pub" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('pub',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">pub asso</span>
							<input type="checkbox" name="family[]" value="pub asso" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('pub asso',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">pub club</span>
							<input type="checkbox" name="family[]" value="pub club" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('pub club',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">pub géo</span>
							<input type="checkbox" name="family[]" value="pub géo" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('pub géo',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">pub parc</span>
							<input type="checkbox" name="family[]" value="pub parc" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('pub parc',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">pub site</span>
							<input type="checkbox" name="family[]" value="pub site" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('pub site',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">pub zoo</span>
							<input type="checkbox" name="family[]" value="pub zoo" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('pub zoo',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">shine</span>
							<input type="checkbox" name="family[]" value="shine" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('shine',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">shine charm</span>
							<input type="checkbox" name="family[]" value="shine charm" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('shine charm',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">shine glacé</span>
							<input type="checkbox" name="family[]" value="shine glacé" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('shine glacé',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">shine gradient</span>
							<input type="checkbox" name="family[]" value="shine gradient" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('shine gradient',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">shine paillettes</span>
							<input type="checkbox" name="family[]" value="shine paillettes" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('shine paillettes',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">soft</span>
							<input type="checkbox" name="family[]" value="soft" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('soft',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">velours</span>
							<input type="checkbox" name="family[]" value="velours" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('velours',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">wood style</span>
							<input type="checkbox" name="family[]" value="wood style" onchange="submitReq()" <?php if(isset($_GET['family'])&&in_array('wood style',$_GET['family'])){echo 'checked="checked"';} ?>>
						</label>
					</div>

				</div>
			</div><br>

			<div class="filter checkboxes-container">
				<div class="filter_title" onclick="toggleValues('tube_colorShow','tube_colorFilter')">
					<span class="filter_name">Couleur du tube</span>
					<input type="hidden" name="tube_color_show" value="<?php if(!isset($_GET['tube_color_show'])){echo '0';}else{echo $_GET['tube_color_show'];}?>" id="tube_colorShow">
				</div>
				<div class="filters_values" style="display: <?php if(isset($_GET['tube_color_show'])){echo $DISPLAY_TYPES[intval($_GET['tube_color_show'],10)];}else{echo 'none;';} ?>" id="tube_colorFilter">
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">bleu</span>
							<input type="checkbox" name="tube_color[]" value="bleu" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('bleu',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">orange</span>
							<input type="checkbox" name="tube_color[]" value="orange" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('orange',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">noir</span>
							<input type="checkbox" name="tube_color[]" value="noir" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('noir',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">bleu ciel</span>
							<input type="checkbox" name="tube_color[]" value="bleu ciel" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('bleu ciel',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">lilas</span>
							<input type="checkbox" name="tube_color[]" value="lilas" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('lilas',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">vert pomme</span>
							<input type="checkbox" name="tube_color[]" value="vert pomme" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('vert pomme',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">violet</span>
							<input type="checkbox" name="tube_color[]" value="violet" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('violet',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">jaune</span>
							<input type="checkbox" name="tube_color[]" value="jaune" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('jaune',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">vert</span>
							<input type="checkbox" name="tube_color[]" value="vert" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('vert',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">gris</span>
							<input type="checkbox" name="tube_color[]" value="gris" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('gris',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">bleu foncé</span>
							<input type="checkbox" name="tube_color[]" value="bleu foncé" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('bleu foncé',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">rose</span>
							<input type="checkbox" name="tube_color[]" value="rose" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('rose',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">vert foncé</span>
							<input type="checkbox" name="tube_color[]" value="vert foncé" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('vert foncé',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">blanc</span>
							<input type="checkbox" name="tube_color[]" value="blanc" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('blanc',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">naturel</span>
							<input type="checkbox" name="tube_color[]" value="naturel" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('naturel',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">rouge</span>
							<input type="checkbox" name="tube_color[]" value="rouge" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('rouge',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">or</span>
							<input type="checkbox" name="tube_color[]" value="or" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('or',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">argent</span>
							<input type="checkbox" name="tube_color[]" value="argent" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('argent',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">or rose</span>
							<input type="checkbox" name="tube_color[]" value="or rose" onchange="submitReq()" <?php if(isset($_GET['tube_color'])&&in_array('or rose',$_GET['tube_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>

				</div>
			</div><br>

			<div class="filter checkboxes-container">
				<div class="filter_title" onclick="toggleValues('topShow','topFilter')">
					<span class="filter_name">Couleur du haut</span>
					<input type="hidden" name="top_show" value="<?php if(!isset($_GET['top_show'])){echo '0';}else{echo $_GET['top_show'];}?>" id="topShow">
				</div>
				<div class="filters_values" style="display: <?php if(isset($_GET['top_show'])){echo $DISPLAY_TYPES[intval($_GET['top_show'],10)];}else{echo 'none;';} ?>" id="topFilter">
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">blanc</span>
							<input type="checkbox" name="top[]" value="blanc" onchange="submitReq()" <?php if(isset($_GET['top'])&&in_array('blanc',$_GET['top'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">noir</span>
							<input type="checkbox" name="top[]" value="noir" onchange="submitReq()" <?php if(isset($_GET['top'])&&in_array('noir',$_GET['top'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">stylus blanc</span>
							<input type="checkbox" name="top[]" value="stylus blanc" onchange="submitReq()" <?php if(isset($_GET['top'])&&in_array('stylus blanc',$_GET['top'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">stylus gris</span>
							<input type="checkbox" name="top[]" value="stylus gris" onchange="submitReq()" <?php if(isset($_GET['top'])&&in_array('stylus gris',$_GET['top'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">gris</span>
							<input type="checkbox" name="top[]" value="gris" onchange="submitReq()" <?php if(isset($_GET['top'])&&in_array('gris',$_GET['top'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">stylus noir</span>
							<input type="checkbox" name="top[]" value="stylus noir" onchange="submitReq()" <?php if(isset($_GET['top'])&&in_array('stylus noir',$_GET['top'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">bleu foncé</span>
							<input type="checkbox" name="top[]" value="bleu foncé" onchange="submitReq()" <?php if(isset($_GET['top'])&&in_array('bleu foncé',$_GET['top'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">rose</span>
							<input type="checkbox" name="top[]" value="rose" onchange="submitReq()" <?php if(isset($_GET['top'])&&in_array('rose',$_GET['top'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">vert</span>
							<input type="checkbox" name="top[]" value="vert" onchange="submitReq()" <?php if(isset($_GET['top'])&&in_array('vert',$_GET['top'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">bleu ciel</span>
							<input type="checkbox" name="top[]" value="bleu ciel" onchange="submitReq()" <?php if(isset($_GET['top'])&&in_array('bleu ciel',$_GET['top'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">jaune</span>
							<input type="checkbox" name="top[]" value="jaune" onchange="submitReq()" <?php if(isset($_GET['top'])&&in_array('jaune',$_GET['top'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">lilas</span>
							<input type="checkbox" name="top[]" value="lilas" onchange="submitReq()" <?php if(isset($_GET['top'])&&in_array('lilas',$_GET['top'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">blanc décoré</span>
							<input type="checkbox" name="top[]" value="blanc décoré" onchange="submitReq()" <?php if(isset($_GET['top'])&&in_array('blanc décoré',$_GET['top'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">stylus blanc décoré</span>
							<input type="checkbox" name="top[]" value="stylus blanc décoré" onchange="submitReq()" <?php if(isset($_GET['top'])&&in_array('stylus blanc décoré',$_GET['top'])){echo 'checked="checked"';} ?>>
						</label>
					</div>

				</div>
			</div><br>

			<div class="filter checkboxes-container">
				<div class="filter_title" onclick="toggleValues('ring_colorShow','ring_colorFilter')">
					<span class="filter_name">Couleur de l'anneau</span>
					<input type="hidden" name="ring_color_show" value="<?php if(!isset($_GET['ring_color_show'])){echo '0';}else{echo $_GET['ring_color_show'];}?>" id="ring_colorShow">
				</div>
				<div class="filters_values" style="display: <?php if(isset($_GET['ring_color_show'])){echo $DISPLAY_TYPES[intval($_GET['ring_color_show'],10)];}else{echo 'none;';} ?>" id="ring_colorFilter">
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">noire</span>
							<input type="checkbox" name="ring_color[]" value="noire" onchange="submitReq()" <?php if(isset($_GET['ring_color'])&&in_array('noire',$_GET['ring_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">orange</span>
							<input type="checkbox" name="ring_color[]" value="orange" onchange="submitReq()" <?php if(isset($_GET['ring_color'])&&in_array('orange',$_GET['ring_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">verte</span>
							<input type="checkbox" name="ring_color[]" value="verte" onchange="submitReq()" <?php if(isset($_GET['ring_color'])&&in_array('verte',$_GET['ring_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">blanche</span>
							<input type="checkbox" name="ring_color[]" value="blanche" onchange="submitReq()" <?php if(isset($_GET['ring_color'])&&in_array('blanche',$_GET['ring_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">noire ondulée</span>
							<input type="checkbox" name="ring_color[]" value="noire ondulée" onchange="submitReq()" <?php if(isset($_GET['ring_color'])&&in_array('noire ondulée',$_GET['ring_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">bleue ondulée</span>
							<input type="checkbox" name="ring_color[]" value="bleue ondulée" onchange="submitReq()" <?php if(isset($_GET['ring_color'])&&in_array('bleue ondulée',$_GET['ring_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">orange ondulée</span>
							<input type="checkbox" name="ring_color[]" value="orange ondulée" onchange="submitReq()" <?php if(isset($_GET['ring_color'])&&in_array('orange ondulée',$_GET['ring_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">violette ondulée</span>
							<input type="checkbox" name="ring_color[]" value="violette ondulée" onchange="submitReq()" <?php if(isset($_GET['ring_color'])&&in_array('violette ondulée',$_GET['ring_color'])){echo 'checked="checked"';} ?>>
						</label>
					</div>

				</div>
			</div><br>

			<div class="filter checkboxes-container">
				<div class="filter_title" onclick="toggleValues('ink_colorsShow','ink_colorsFilter')">
					<span class="filter_name">Couleur de l'encre</span>
					<input type="hidden" name="ink_colors_show" value="<?php if(!isset($_GET['ink_colors_show'])){echo '0';}else{echo $_GET['ink_colors_show'];}?>" id="ink_colorsShow">
				</div>
				<div class="filters_values" style="display: <?php if(isset($_GET['ink_colors_show'])){echo $DISPLAY_TYPES[intval($_GET['ink_colors_show'],10)];}else{echo 'none;';} ?>" id="ink_colorsFilter">
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">rouge, noir, vert, bleu</span>
							<input type="checkbox" name="ink_colors[]" value="rouge, noir, vert, bleu" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('rouge, noir, vert, bleu',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">rouge, noir, vert, bleu clair</span>
							<input type="checkbox" name="ink_colors[]" value="rouge, noir, vert, bleu clair" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('rouge, noir, vert, bleu clair',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">rose, violet, vert citron, turquoise</span>
							<input type="checkbox" name="ink_colors[]" value="rose, violet, vert citron, turquoise" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('rose, violet, vert citron, turquoise',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">rose, violet, orange, jaune</span>
							<input type="checkbox" name="ink_colors[]" value="rose, violet, orange, jaune" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('rose, violet, orange, jaune',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">rouge, noir, jaune fluo, bleu</span>
							<input type="checkbox" name="ink_colors[]" value="rouge, noir, jaune fluo, bleu" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('rouge, noir, jaune fluo, bleu',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">noir, rouge, bleu, crayon</span>
							<input type="checkbox" name="ink_colors[]" value="noir, rouge, bleu, crayon" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('noir, rouge, bleu, crayon',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">noir, rouge, vert, bleu</span>
							<input type="checkbox" name="ink_colors[]" value="noir, rouge, vert, bleu" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('noir, rouge, vert, bleu',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">vert, noir, turquoise, rouge</span>
							<input type="checkbox" name="ink_colors[]" value="vert, noir, turquoise, rouge" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('vert, noir, turquoise, rouge',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">rouge, noir, gris, bleu</span>
							<input type="checkbox" name="ink_colors[]" value="rouge, noir, gris, bleu" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('rouge, noir, gris, bleu',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">bleu, bleu foncé</span>
							<input type="checkbox" name="ink_colors[]" value="bleu, bleu foncé" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('bleu, bleu foncé',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">rose, bleu</span>
							<input type="checkbox" name="ink_colors[]" value="rose, bleu" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('rose, bleu',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">bleu, vert</span>
							<input type="checkbox" name="ink_colors[]" value="bleu, vert" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('bleu, vert',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">rouge, bleu</span>
							<input type="checkbox" name="ink_colors[]" value="rouge, bleu" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('rouge, bleu',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">blanc *4</span>
							<input type="checkbox" name="ink_colors[]" value="blanc *4" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('blanc *4',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">noir *4</span>
							<input type="checkbox" name="ink_colors[]" value="noir *4" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('noir *4',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">vert, noir, bleu, rouge</span>
							<input type="checkbox" name="ink_colors[]" value="vert, noir, bleu, rouge" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('vert, noir, bleu, rouge',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">noir, violet, vert citron, bleu</span>
							<input type="checkbox" name="ink_colors[]" value="noir, violet, vert citron, bleu" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('noir, violet, vert citron, bleu',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">rouge, noir, violet, bleu</span>
							<input type="checkbox" name="ink_colors[]" value="rouge, noir, violet, bleu" onchange="submitReq()" <?php if(isset($_GET['ink_colors'])&&in_array('rouge, noir, violet, bleu',$_GET['ink_colors'])){echo 'checked="checked"';} ?>>
						</label>
					</div>

				</div>
			</div><br>

			<div class="filter checkboxes-container">
				<div class="filter_title" onclick="toggleValues('rarityShow','rarityFilter')">
					<span class="filter_name">Rareté</span>
					<input type="hidden" name="rarity_show" value="<?php if(!isset($_GET['rarity_show'])){echo '0';}else{echo $_GET['rarity_show'];}?>" id="rarityShow">
				</div>
				<div class="filters_values" style="display: <?php if(isset($_GET['rarity_show'])){echo $DISPLAY_TYPES[intval($_GET['rarity_show'],10)];}else{echo 'none;';} ?>" id="rarityFilter">
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">1</span>
							<input type="checkbox" name="rarity[]" value="1" onchange="submitReq()" <?php if(isset($_GET['rarity'])&&in_array('1',$_GET['rarity'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">5</span>
							<input type="checkbox" name="rarity[]" value="5" onchange="submitReq()" <?php if(isset($_GET['rarity'])&&in_array('5',$_GET['rarity'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">4</span>
							<input type="checkbox" name="rarity[]" value="4" onchange="submitReq()" <?php if(isset($_GET['rarity'])&&in_array('4',$_GET['rarity'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">2</span>
							<input type="checkbox" name="rarity[]" value="2" onchange="submitReq()" <?php if(isset($_GET['rarity'])&&in_array('2',$_GET['rarity'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">3</span>
							<input type="checkbox" name="rarity[]" value="3" onchange="submitReq()" <?php if(isset($_GET['rarity'])&&in_array('3',$_GET['rarity'])){echo 'checked="checked"';} ?>>
						</label>
					</div>

				</div>
			</div><br>

			<div class="filter checkboxes-container">
				<div class="filter_title" onclick="toggleValues('priceShow','priceFilter')">
					<span class="filter_name">Prix</span>
					<input type="hidden" name="price_show" value="<?php if(!isset($_GET['price_show'])){echo '0';}else{echo $_GET['price_show'];}?>" id="priceShow">
				</div>
				<div class="filters_values" style="display: <?php if(isset($_GET['price_show'])){echo $DISPLAY_TYPES[intval($_GET['price_show'],10)];}else{echo 'none;';} ?>" id="priceFilter">
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">1.4</span>
							<input type="checkbox" name="price[]" value="1.4" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('1.4',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">0.0</span>
							<input type="checkbox" name="price[]" value="0.0" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('0.0',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">1.6</span>
							<input type="checkbox" name="price[]" value="1.6" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('1.6',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">2.0</span>
							<input type="checkbox" name="price[]" value="2.0" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('2.0',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">1.7</span>
							<input type="checkbox" name="price[]" value="1.7" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('1.7',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">1.3</span>
							<input type="checkbox" name="price[]" value="1.3" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('1.3',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">2.2</span>
							<input type="checkbox" name="price[]" value="2.2" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('2.2',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">1.9</span>
							<input type="checkbox" name="price[]" value="1.9" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('1.9',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">2.6</span>
							<input type="checkbox" name="price[]" value="2.6" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('2.6',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">10.5</span>
							<input type="checkbox" name="price[]" value="10.5" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('10.5',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">4.9</span>
							<input type="checkbox" name="price[]" value="4.9" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('4.9',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">2.5</span>
							<input type="checkbox" name="price[]" value="2.5" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('2.5',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">3.0</span>
							<input type="checkbox" name="price[]" value="3.0" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('3.0',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">2.3</span>
							<input type="checkbox" name="price[]" value="2.3" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('2.3',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">4.0</span>
							<input type="checkbox" name="price[]" value="4.0" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('4.0',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">6.6</span>
							<input type="checkbox" name="price[]" value="6.6" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('6.6',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">6.0</span>
							<input type="checkbox" name="price[]" value="6.0" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('6.0',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">2.4</span>
							<input type="checkbox" name="price[]" value="2.4" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('2.4',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">3.3</span>
							<input type="checkbox" name="price[]" value="3.3" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('3.3',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">5.0</span>
							<input type="checkbox" name="price[]" value="5.0" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('5.0',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">2.7</span>
							<input type="checkbox" name="price[]" value="2.7" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('2.7',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">2.8</span>
							<input type="checkbox" name="price[]" value="2.8" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('2.8',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">3.2</span>
							<input type="checkbox" name="price[]" value="3.2" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('3.2',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">3.4</span>
							<input type="checkbox" name="price[]" value="3.4" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('3.4',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">1.8</span>
							<input type="checkbox" name="price[]" value="1.8" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('1.8',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">4.5</span>
							<input type="checkbox" name="price[]" value="4.5" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('4.5',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">5.9</span>
							<input type="checkbox" name="price[]" value="5.9" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('5.9',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">7.0</span>
							<input type="checkbox" name="price[]" value="7.0" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('7.0',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">6.5</span>
							<input type="checkbox" name="price[]" value="6.5" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('6.5',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">7.5</span>
							<input type="checkbox" name="price[]" value="7.5" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('7.5',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">5.3</span>
							<input type="checkbox" name="price[]" value="5.3" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('5.3',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">3.5</span>
							<input type="checkbox" name="price[]" value="3.5" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('3.5',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">6.1</span>
							<input type="checkbox" name="price[]" value="6.1" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('6.1',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">7.3</span>
							<input type="checkbox" name="price[]" value="7.3" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('7.3',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">4.8</span>
							<input type="checkbox" name="price[]" value="4.8" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('4.8',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">4.1</span>
							<input type="checkbox" name="price[]" value="4.1" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('4.1',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">5.4</span>
							<input type="checkbox" name="price[]" value="5.4" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('5.4',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">5.5</span>
							<input type="checkbox" name="price[]" value="5.5" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('5.5',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">6.7</span>
							<input type="checkbox" name="price[]" value="6.7" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('6.7',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">2.9</span>
							<input type="checkbox" name="price[]" value="2.9" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('2.9',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">9.0</span>
							<input type="checkbox" name="price[]" value="9.0" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('9.0',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">8.0</span>
							<input type="checkbox" name="price[]" value="8.0" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('8.0',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">3.9</span>
							<input type="checkbox" name="price[]" value="3.9" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('3.9',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">12.0</span>
							<input type="checkbox" name="price[]" value="12.0" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('12.0',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">5.8</span>
							<input type="checkbox" name="price[]" value="5.8" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('5.8',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">2.1</span>
							<input type="checkbox" name="price[]" value="2.1" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('2.1',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">3.8</span>
							<input type="checkbox" name="price[]" value="3.8" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('3.8',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">1.2</span>
							<input type="checkbox" name="price[]" value="1.2" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('1.2',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">3.1</span>
							<input type="checkbox" name="price[]" value="3.1" onchange="submitReq()" <?php if(isset($_GET['price'])&&in_array('3.1',$_GET['price'])){echo 'checked="checked"';} ?>>
						</label>
					</div>

				</div>
			</div><br>

			<input type="submit" value="Submit request" />
		</form>
	</div>
</section>
	<div class="main-inner wrapper">
		<ul class="product-list ul-reset">
			<?php
			$first = 1;
			$query = "SELECT * FROM pen";

			if (isset($_GET['top'])) {
				$query = addToQuery($query, $_GET['top'], $first, "top");
				$first = 0;	}
			if (isset($_GET['ring_color'])) {
				$query = addToQuery($query, $_GET['ring_color'], $first, "ring_color");
				$first = 0; }
			if (isset($_GET['tube_color'])) {
				$query = addToQuery($query, $_GET['tube_color'], $first, "tube_color");
				$first = 0; }
			if (isset($_GET['family'])) {
				$query = addToQuery($query, $_GET['family'], $first, "family");
				$first = 0; }
			if (isset($_GET['ink_colors'])) {
				$query = addToQuery($query, $_GET['ink_colors'], $first, "ink_colors");
				$first = 0;	}
			if (isset($_GET['rarity'])) {
				$query = addToQuery($query, $_GET['rarity'], $first, "rarity");
				$first = 0;	}
			if (isset($_GET['price'])) {
				$query = addToQuery($query, $_GET['price'], $first, "price");
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
			$mysqli->close();
			while($rows = $result->fetch_assoc()) {
				$img = $rows['image'];
				$stars = $rows['rarity'];
			?>
			<li class="product-item ib">
				<section class="product-item-inner">
					<div class="product-item-image">
					<?php
						echo "<img width='50' height='350' src='$img'></img>";
					?>
					</div>
					<!-- /.product-item-image -->
					<h1 class="product-item-title">
					<?php
						echo 'Nom: ' . $rows['name'];
					?>
        				</h1>
					<!-- /.product-item-title -->
					<div class="product-item-infos">
						<?php
							echo 'Couleur du tube: ' . $rows['tube_color'];
						?><br><?php
							echo 'Haut: ' . $rows['top'];
						?><br><?php
							echo 'Couleur des ancres: ' . $rows['ink_colors'];
						?><br><?php
							echo 'Price: ' . $rows['price'] . '€';
						?><br><?php
							echo 'Rarity: ';
							for ($i = 0; $i < $stars; $i++) {
								echo '⭐';
							}
						?>
					</div><br><br>
					<div class="product-item-lower">
						<div class="product-item-short-description">
							<?php
								echo $rows['comments'];
							?>
						</div>
						<br><br><br>
						<?php
							$n = $rows['id'];
							echo "<input type='button' value='See more' class='product-item-see-more' ";
							echo 'onclick="location.href=';
							echo "'bic/bic_" . $n . ".html'";
							echo '"/>';
						?>
					</div>
				</section>
				<!-- /.product-item-inner -->
			</li>
			<?php
			}
			?>
			<!-- /.product-item ib -->
		</ul>
		<!-- /.product-list ul-reset -->
	</div>
	<!-- /.main-inner wrapper -->
</main>
<!-- /.main -->

<footer class="footer">
	<div class="footer-inner wrapper">
		Made by <a href="https://github.com/0xC-M0NK3Y">0xC-M0NK3Y</a>.
	</div>
	<!-- /.footer-inner wrapper -->
</footer>
<!-- /.footer -->
<script>
<!-- events listenners -->

function toggleValues(getVar, filterId) {
	var val = document.getElementById(getVar);
	if (val.value === "0") {
		val.value = "1";
		document.getElementById(filterId).style = "display: block;";
	} else {
		val.value = "0";
		document.getElementById(filterId).style = "display: none;";
	}
}

function submitReq() {
	document.querySelector("form").submit();
}
</script>
</body>
</html>
