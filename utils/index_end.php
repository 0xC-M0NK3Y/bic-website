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
		Bicophile.fr, bic.<br>
		<p style="font-size: 0.5em; text-align: center; margin-right: 150px;">Pour les modèles spéciaux, les prix affichés sont les prix en boutique hors frais de port.</p>
		<p style="font-size: 0.5em; text-align: center; margin-right: 150px;">Pour les modèles vendus en supermarché, le prix est indicatif du blister individuel et peut fortement varier dès lors que le stylo fait partie d'un blister mélangé</p>
	</div>
	<!-- /.footer-inner wrapper -->
</footer>
<!-- /.footer -->
<script>
<!-- events listenners -->

window.addEventListener("DOMContentLoaded", (event) => {
	var markedCheckbox = document.querySelectorAll('input[type="checkbox"]:checked');

	document.querySelector(".filter_menu").scrollTop = localStorage.getItem("scrollPositon") || 0;

	for (var checkbox of markedCheckbox) {
		var name = checkbox.name;

		name = name.substr(0, name.length-2);
		name += "_check";
		document.getElementById(name).checked = true;
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

function removeChecks(checkboxId, name) {
	if (document.getElementById(checkboxId).checked === true) {
		document.getElementById(checkboxId).checked = false;
		return;
	}
	var checkboxes = document.getElementsByName(name);

	for (var checkbox of checkboxes) {
		checkbox.checked = false;
	}
	var tmp = name.substr(name, name.length-2);

	toggleValues(tmp+"Show", tmp+"Filter");
	submitReq();
}

function submitReq() {
	localStorage.setItem("scrollPositon", document.querySelector(".filter_menu").scrollTop);
	document.querySelector("form").submit();
}
</script>
</body>
</html>
