<!-- PHP code to establish connection with the localserver -->
<?php
$username = 'bic_user';
$password = 'bic_user';
$database = 'bic_db';
$servername='localhost';
$mysqli = new mysqli($servername, $username, $password, $database);

if ($mysqli->connect_error) {
	die('Connect Error (' .
	$mysqli->connect_errno . ') '.
	$mysqli->connect_error);
}
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
	<div class="search">
		<form action="" method="POST">
			<input type="text" name="search" value="<?php if(isset($_POST['search'])){echo $_POST['search']; }?>" class="search_bar" placeholder="Search">
			<select name="top">
				<option value="">Top</option>
				<option value="blanc">blanc</option>
				<option value="noir">noir</option>
			</select>
			<select name="ring">
				<option value="">Ring</option>
				<option value="noire">noire</option>
				<option value="blanche">blanche</option>
			</select>
		<button type="submit" class="button">Search</button>
		</form>
	</div>
</section>
	<div class="main-inner wrapper">
		<ul class="product-list ul-reset">
			<?php
			$andd = 0;
			$query = "SELECT * FROM pen";
			if (isset($_POST['top'])) {
				$top_value = $_POST['top'];
				$query .= " WHERE top LIKE '%$top_value%'";
				$andd++;
			}
			if (isset($_POST['ring'])) {
				$ring_value = $_POST['ring'];
				if ($andd == 0) {
					$query .= " WHERE ring LIKE '%$ring_value%'";
				} else {
					$query .= " AND ring LIKE '%$ring_value%'";
				}
				$andd++;
			}
			if (isset($_POST['search'])) {
				$search_value = $_POST['search'];
				if ($andd == 0) {
					$query .= " WHERE body LIKE '%$search_value%'";
				} else {
					$query .= " AND body LIKE '%$search_value%'";
				}
			}
			//echo "<script>alert(\"" . $query . "\")</script>";
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
						echo 'Tag: ' . $rows['tag'];
					?>
        				</h1>
					<!-- /.product-item-title -->
					<div class="product-item-infos">
						<?php
							echo 'Body: ' . $rows['body'];
						?><br><?php
							echo 'Tube color: ' . $rows['tube_color'];
						?><br><?php
							echo 'Tube finition: ' .$rows['tube_finition'];
						?><br><?php
							echo 'Ring: ' . $rows['ring'];
						?><br><?php
							echo 'Top: ' . $rows['top'];
						?><br><?php
							echo 'Colors: ' . $rows['colors'];
						?><br><?php
							echo 'Thick: ' . $rows['thick'];
						?><br><?php
							echo 'Price: ' . $rows['price'] . '€';
						?><br><?php
							echo 'Rarity: ';
							for ($i = 0; $i < $stars; $i++) {
								echo '⭐';
							}
						?>
					</div>
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
			$_POST['search'] = '';
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
</script>
</body>
</html>
