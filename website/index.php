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

$sql = " SELECT * FROM pen";
$result = $mysqli->query($sql);
$mysqli->close();
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
	<div class="main-inner wrapper">
		<ul class="product-list ul-reset">
			<?php
			$n = 1;
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
							echo "<input type='button' value='See more' class='product-item-see-more' ";
							echo 'onclick="location.href=';
							echo "'bic/bic_" . $n . ".html'";
							echo '"/>';
							$n++;
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
</body>
</html>
