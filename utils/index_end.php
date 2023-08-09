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
				$id = $rows['id'];
				$img = $rows['image'];
				$stars = $rows['rarity'];
				$price = $rows['price'];
				if ($price == 0) {
					$price = "Indéterminé";
				} else {
					$price .= " €";
				}
			?>
			<a href="<?php echo 'bic/bic_' . $id . '.html' ?>">
			<li class="product-item ib">
				<section class="product-item-inner">
					<div class="product-item-image">
					<?php
						echo "<img height='350' src='$img'></img>";
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
				</section>
				<!-- /.product-item-inner -->
			</li>
			</a>
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
