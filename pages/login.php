<?php

/* start session */
session_start();

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

$login = $mysqli->real_escape_string($_POST['login_username']); // Échapper les caractères spéciaux

$query = "SELECT password FROM accounts WHERE username='" . $login . "'";

echo $query;
echo "<br>";

$result = $mysqli->query($query);

if ($result) {
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$pass = $row['password'];
		if (password_verify($_POST['login_password'], $pass)) {
			session_start();
			$_SESSION['logged_user'] = $login;
			header('Location: index.php');
			die();
		} else {
			header("Location: index.php?bad_password=1");
			die();
		}
	} else {
		header("Location: index.php?account_not_found=1");
		die();
	}
	$result->close();
} else {
	echo "Erreur dans la requête : " . $mysqli->error;
}

$mysqli->close();

?>
<h1>login</h1>
