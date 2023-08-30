<?php

/* start session */
session_start();

$username = 'bic_user';
$password = 'bic_user';
$database = 'bic_db';
$servername='localhost';

if (!isset($_POST['register_password']) || !isset($_POST['register_password_repeat']) || !isset($_POST['register_username']) || !isset($_POST['register_email'])) {
	header("Location: index.php");
	die();
}

if ($_POST['register_password'] != $_POST['register_password_repeat']) {
	header("Location: index.php?not_same_password=1");
	die();
}

if (!filter_var($_POST['register_email'], FILTER_VALIDATE_EMAIL)) {
	header("Location: index.php?not_valid_email=1");
	die();
}

$mysqli = new mysqli($servername, $username, $password, $database);

if ($mysqli->connect_error) {
	die('Connect Error (' .
	$mysqli->connect_errno . ') '.
	$mysqli->connect_error);
}

$username = $mysqli->real_escape_string($_POST['register_username']);
$password = password_hash($_POST["register_password"], PASSWORD_BCRYPT);
$email = $mysqli->real_escape_string($_POST['register_email']);
$ip = $_SERVER['REMOTE_ADDR'];

$query_check = "SELECT * FROM accounts WHERE username='" . $username . "';";
$query_check .= "SELECT * FROM accounts WHERE email='" . $email . "'";

$check = $mysqli->multi_query($query_check);
if ($check) {
	$result_check = $mysqli->store_result();
	if ($result_check->num_rows > 0) {
		header("Location: index.php?username_already_used=1");
		die();
	}
	$mysqli->next_result();
	$result_check = $mysqli->store_result();
	if ($result_check->num_rows > 0) {
		header("Location: index.php?email_already_used=1");
		die();
	}
}

$query = "INSERT INTO accounts(username,password,email,creation_ip) VALUES ";
$query .= "('" . $username . "',";
$query .= "'" . $password . "',";
$query .= "'" . $email . "',";
$query .= "'" . $ip  . "')";

$result = $mysqli->query($query);
$mysqli->close();

header("Location: index.php");
die();
?>

