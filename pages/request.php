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
	// bool for noobs (jk im just a c monkey)
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

$account_id = "";
/* Log in user */
if (isset($_SESSION['logged_user'])) {
	$username = $_SESSION['logged_user'];
	$account_id_query = "SELECT id FROM accounts WHERE username='" . $username . "'";
	$account_id = $mysqli->query($account_id_query);
	if ($account_id) {
		$account_id = $account_id->fetch_assoc();
		$account_id = $account_id['id'];
		$lists_query = "SELECT * FROM wish_list WHERE account_id=" . $account_id . ";";
		$lists_query .= "SELECT * FROM got_list WHERE account_id=" . $account_id . "";
		$mysqli->multi_query($lists_query);
		$i = 0;
		if ($wish_res = $mysqli->store_result()) {
			while ($row = $wish_res->fetch_row()) {
				$wish_list[$i] = $row[1];
				$i++;
			}
		}
		$wish_list_len = $i;
		if ($mysqli->more_results()) {
			$i = 0;
			$mysqli->next_result();
			if ($got_res = $mysqli->store_result()) {
				while ($row = $got_res->fetch_row()) {
					$got_list[$i] = $row[1];
					$i++;
				}
			}
			$got_list_len = $i;
		}
	} else {
		$account_id = "";
	}
}


/* Create the princiapl query*/
$first = 1;
$query = "SELECT * FROM pen";
$wish = 0;
$got = 0;
$not_wish = 0;
$not_got = 0;
if ($account_id != "") {
	if (isset($_GET['wish']) && $_GET['wish'] == 'on') {
		if (!isset($_GET['not_wish']) || (isset($_GET['not_wish']) && $_GET['not_wish'] != 'on')) {
			$query .= " JOIN wish_list ON pen.id=wish_list.pen_id";
			$wish = 1;
		}
	}
	if (isset($_GET['got']) && $_GET['got'] == 'on') {
		if (!isset($_GET['not_got']) || (isset($_GET['not_got']) && $_GET['not_got'] != 'on')) {
			$query .= " JOIN got_list ON pen.id=got_list.pen_id";
			$got = 1;
		}
	}
	if (isset($_GET['not_wish']) && $_GET['not_wish'] == 'on') {
		if (!isset($_GET['wish']) || (isset($_GET['wish']) && $_GET['wish'] != 'on')) {
			$not_wish = 1;
		}
	}
	if (isset($_GET['not_got']) && $_GET['not_got'] == 'on') {
		if (!isset($_GET['got']) || (isset($_GET['got']) && $_GET['got'] != 'on')) {
			$not_got = 1;
		}
	}
}
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
	if ($first == 1) {
		$query .= " WHERE name LIKE '%$search_value%'";
	} else {
		$query .= " AND name LIKE '%$search_value%'";
	}
}
if ($account_id != "") {
	if ($wish == 1) {
		$query .= " AND wish_list.account_id=" . $account_id . " ORDER BY pos";
	}
	if ($got == 1) {
		$query .= " AND got_list.account_id=" . $account_id . " ORDER BY pos";
	}
	if ($not_wish == 1) {
		$query .= " AND id NOT IN (SELECT pen_id FROM wish_list WHERE account_id=" . $account_id . ")";
	}
	if ($not_got == 1) {
		$query .= " AND id NOT IN (SELECT pen_id FROM got_list WHERE account_id=" . $account_id . ")";
	}
}
if (isset($_GET['page'])) {
	$page = $_GET['page'];
	$page = intval($page, 10);
	$page *= 256;
	$query .= " LIMIT " . $page . ", 256";
} else {
	$query .= " LIMIT 0, 256";
}

/* Execute principal query and count query */
$result = $mysqli->query($query);
$tmp = explode('*', $query);
$count_query = $tmp[0] . "COUNT(*) as cnt" . $tmp[1];
$result_len = $mysqli->query($count_query);
$total_pens = $result_len->fetch_assoc();
$total = $total_pens['cnt'];

/* Close database connection */
$mysqli->close();

?>
<div id="total_php" hidden="hidden">
<?php echo $total; ?>
</div>
<div id="account_id" hidden="hidden">
<?php echo $account_id; ?>
</div>
<?php

while($rows = $result->fetch_assoc()) {
	$id = $rows['id'];
	$img = $rows['image'];
	$stars = $rows['rarity'];
	$price = $rows['price'];
	if ($price == 0) {
		$price = "Indéterminé";
	} else {
		$price .= " €";
	}
	$price = str_replace('.', ',', $price)
?>
<a href="<?php echo 'bic/bic_' . $id . '.html' ?>">
<li class="product-item ib">
	<section class="product-item-inner">
		<div class="product-item-image">
		<?php
			echo "<img src='$img' style='border-radius: 15px;'></img>";
		?>
		</div>
		<!-- /.product-item-image -->
		<h1 class="product-item-title">
		<?php
			echo $rows['name'];
		?>
			</h1>
		<!-- /.product-item-title -->
		<div class="product-item-infos">
			<?php
				echo 'Prix: ' . $price;
			?><br><?php
				echo 'Rareté: ';
				for ($i = 0; $i < $stars; $i++) {
					echo '⭐';
				}
			?>
		</div><br><br>
		<form id="<?php echo 'update_form' . $id; ?>" action="update_list.php" method="post">
			<input type="hidden" name="pen_id" value="<?php echo $id; ?>">
			<input type="hidden" name="account_id" value="<?php echo $account_id; ?>">
			<input type="hidden" id="<?php echo 'list_name' . $id; ?>" name="list">
			<div class="product_got" onclick="<?php if($account_id==""){echo 'changeList(\'got\', ' . $id . ', 0)';}else{echo 'changeList(\'got\', ' . $id . ', 1)';} ?>">
				<input id="<?php echo 'got_input_' . $id; ?>" type="hidden" name="got" value="<?php if(isInList($id, $got_list, $got_list_len)){echo '1';}else{echo '0';} ?>">
				<img id="<?php echo 'got_img_' . $id; ?>" src="<?php if(isInList($id, $got_list, $got_list_len)){echo './assets/safe_on_64.png';}else{echo './assets/safe_off_64.png';} ?>"></img>
			</div>
			<div class="product_wished" onclick="<?php if($account_id==""){echo 'changeList(\'wish\', ' . $id . ', 0)';}else{echo 'changeList(\'wish\', ' . $id . ', 1)';} ?>">
				<input id="<?php echo 'wish_input_' . $id; ?>" type="hidden" name="wished" value="<?php if(isInList($id, $wish_list, $wish_list_len)){echo '1';}else{echo '0';} ?>">
				<img id="<?php echo 'wish_img_' . $id; ?>" src="<?php if(isInList($id, $wish_list, $wish_list_len)){echo './assets/heart_on_64.png';}else{echo './assets/heart_off_64.png';} ?>"></img>
			</div>
		</form>
	</section>
	<!-- /.product-item-inner -->
</li>
</a>
<?php
}
?>
<!-- /.product-item ib -->
