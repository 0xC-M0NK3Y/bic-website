		</form>
	</div>
</section>
	<div class="main-inner wrapper">
		<ul class="product-list ul-reset">
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
						echo "<img src='$img' style='border-radius: 20px;'></img>";
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
	<div class="footer-inner">
		Bicophile.fr, bic.
	</div>
	<!-- /.footer-inner wrapper -->
</footer>
<!-- /.footer -->
<script>
<!-- events listenners -->

window.addEventListener("beforeunload", () => {
	localStorage.setItem("scrollPositon", document.querySelector(".filter_menu").scrollTop);
});

window.addEventListener("load", (event) => {
	var markedCheckbox = document.querySelectorAll('input[type="checkbox"]:checked');

	document.querySelector(".filter_menu").scrollTop = localStorage.getItem("scrollPositon") || 0;

	for (var checkbox of markedCheckbox) {
		var name = checkbox.name;

		name = name.substr(0, name.length-2);
		name += "_span";
		var tmp = document.getElementById(name).innerHTML;

		if (tmp.includes("✅") === false) {
			tmp += " ✅";
			document.getElementById(name).innerHTML = tmp;
		}
	}
});

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
