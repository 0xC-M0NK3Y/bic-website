<!DOCTYPE html>
<?php

session_start();

$username = 'bic_user';
$password = 'bic_user';
$database = 'bic_db';
$servername='localhost';


if (isset($_GET['admin_pass']) && $_GET['admin_pass'] == 'azertyuiop') {
	if (isset($_SESSION['logged_user']) && ($_SESSION['logged_user'] == 'Gillian' || $_SESSION['logged_user'] == 'Tim')) {
		$mysqli = new mysqli($servername, $username, $password, $database);
		if ($mysqli->connect_error) {
			die('Connect Error (' .
			$mysqli->connect_errno . ') '.
			$mysqli->connect_error);
		}
		$query = "SELECT username,email,creation_date FROM accounts";

		$result = $mysqli->query($query);
		if ($result) {
			echo '<table>';
			echo '<tr style="border: 2px solid skyblue;">';
			echo '<th style="border: 2px solid skyblue;">Pseudo</th>';
			echo '<th style="border: 2px solid skyblue;">Email</th>';
			echo '<th style="border: 2px solid skyblue;">Date de création</th>';
			echo '</tr>';

			while($rows = $result->fetch_assoc()) {
				$user = $rows['username'];
				$email = $rows['email'];
				$date = $rows['creation_date'];

				echo '<tr style="border: 2px solid skyblue;">';
				echo '<td style="border: 2px solid skyblue;">' . $user . "</td>";
				echo '<td style="border: 2px solid skyblue;">' . $email . "</td>";
				echo '<td style="border: 2px solid skyblue;">' . $date . "</td>";
				echo '</tr>';
			}
			echo '</table>';
		} else {
			echo '<video id="rickroll" autoplay loop muted>';
			echo '<source src="assets/rickroll.mp4" type="video/mp4"/>';
			echo '</video>';
		}
	}
} else if (isset($_GET['admin_pass'])) {
	echo '<video id="rickroll" autoplay loop muted>';
	echo '<source src="assets/rickroll.mp4" type="video/mp4"/>';
	echo '</video>';
}
?>
<form method='GET' action="" id='admin_form'>
	<input type="hidden" id='admin_pass' name='admin_pass' value="<?php if(isset($_GET['admin_pass'])){echo $_GET['admin_pass'];} ?>">
</form>
<script>

window.addEventListener("load", (event) => {
	if (document.getElementById("admin_pass").value === "") {
		let pass = prompt("Mot de passe");
		if (pass != null) {
			document.getElementById("admin_pass").value = pass;
			document.getElementById('admin_form').submit();
		}
	}
});
</script>
