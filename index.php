<!-- PHP code to establish connection with the localserver -->
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
		$query .= " WHERE " . $field . " LIKE '%$values[0]%'";
		if ($size > 1) {
			$query .= " OR";
		}
		$i++;
	} else {
		$query .= " AND";
	}
	for (;$i < $size; $i++) {
		$query .= " " . $field . " LIKE '%$values[$i]%'";
		if ($i != $size-1) {
			$query .= " OR";
		}
	}
	return $query;
}

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
	<div class="filter_menu">
		<form action="" method="POST">
			<div class="search_bar" placeholder="search">
				<input type="text" name="search" value="<?php if(isset($_POST['search'])){echo $_POST['search']; }?>" class="search_input" placeholder="Search">
			</div>
			<div class="filter checkboxes-container">
				<div class="filter_title" id="topFilter" onclick="toggleValues('topValues')">
					<span class="filter_name">Top</span>
				</div>
				<div class="filters_values" style="display: none;" id="topValues">
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">Noir</span>
							<input id="box1" type="checkbox" name="top[]" value="noir" onchange="submitReq()">
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">Blanc</span>
							<input id="box2" type="checkbox" name="top[]" value="blanc" onchange="submitReq()">
						</label>
					</div>
				</div>
			</div>
			<div class="filter checkboxes-container">
				<div class="filter_title" id="ringFilter" onclick="toggleValues('ringValues')">
					<span class="filter_name">Ring</span>
				</div>
				<div class="filters_values" style="display: none;" id="ringValues">
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">Noir</span>
							<input id="box3" type="checkbox" name="ring[]" value="noir" onchange="submitReq()">
						</label>
					</div>
					<div class="filter_value">
						<label class="filter_attribute">
							<span class="filter_label">Blanc</span>
							<input id="box4" type="checkbox" name="ring[]" value="blanc" onchange="submitReq()">
						</label>
					</div>
				</div>
			</div>
			<input type="submit" value="Submit request" />
		</form>
	</div>
</section>
	<div class="main-inner wrapper">
		<ul class="product-list ul-reset">
			<?php
			$first = 1;
			$query = "SELECT * FROM pen";
			if (isset($_POST['top'])) {
				$top_values = $_POST['top'];
				$query = addToQuery($query, $top_values, $first, "top");
				$first = 0;
			}
			if (isset($_POST['ring'])) {
				$ring_values = $_POST['ring'];
				$query = addToQuery($query, $ring_values, $first, "ring");
				$first = 0;
			}
			if (isset($_POST['search'])) {
				$search_value = $_POST['search'];
				if ($first == 1) {
					$query .= " WHERE body LIKE '%$search_value%'";
				} else {
					$query .= " AND body LIKE '%$search_value%'";
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

function toggleValues(id) {
    var valuesDiv = document.getElementById(id);
    if (valuesDiv.style.display === "none") {
        valuesDiv.style.display = "block";
    } else {
        valuesDiv.style.display = "none";
    }
}

function saveCheckboxState(checkbox) {
    if (checkbox.checked) {
        sessionStorage.setItem(checkbox.id, "checked");
    } else {
        sessionStorage.removeItem(checkbox.id);
    }
}

function submitReq() {
	document.querySelector("form").submit();
}

document.addEventListener("DOMContentLoaded", function () {
    var valuesDivs = document.querySelectorAll('.filters_values');
    valuesDivs.forEach(function (valuesDiv) {
        var shouldShowValues = sessionStorage.getItem(valuesDiv.id);

        if (shouldShowValues === "true") {
            valuesDiv.style.display = "block";
        }

        var checkboxes = valuesDiv.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function (checkbox) {
            var checkboxState = sessionStorage.getItem(checkbox.id);
            if (checkboxState === "checked") {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }

            checkbox.addEventListener("click", function () {
                submitReq(checkbox);
            });
        });
    });
});

document.querySelector("form").addEventListener("submit", function () {
    var valuesDivs = document.querySelectorAll('.filters_values');
    valuesDivs.forEach(function (valuesDiv) {
        sessionStorage.setItem(valuesDiv.id, valuesDiv.style.display === "block");

        var checkboxes = valuesDiv.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function (checkbox) {
            saveCheckboxState(checkbox);
        });
    });
});

</script>
</body>
</html>
