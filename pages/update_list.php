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

if (!isset($_POST['pen_id']) || !isset($_POST['account_id'])) {
	echo "Do some effort bro";
	die();
}

$pen_id = $mysqli->real_escape_string($_POST['pen_id']);
$account_id = $mysqli->real_escape_string($_POST['account_id']);

if ($account_id == "") {
	echo "You need to know your account_id if you want to make a bot";
	die();
}

if (!isset($_SESSION['logged_user'])) {
	echo "Connect bro";
	die();
} else {
	$username = $_SESSION['logged_user'];
	$check_query = "SELECT id FROM accounts WHERE username='" . $username ."'";
	$check_result = $mysqli->query($check_query);
	$check = $check_result->fetch_assoc();
	$check_id = $check['id'];
	if ($check_id != $account_id) {
		echo "WHAT THE FUCK ARE YOU TRYING DISGUSTING, GTFO";
		die();
	}
}

if (isset($_POST['list'])) {
	$list = $_POST['list'];
} else {
	echo "Missing something bro";
	die();
}

if ($list == 'wish' && isset($_POST['wished'])) {
	if ($_POST['wished'] == 1) {
		$query = "DELETE FROM wish_list WHERE account_id=" . $account_id . " AND pen_id=" . $pen_id;
	} else if ($_POST['wished'] == 0) {
		$query = "INSERT INTO wish_list(account_id,pen_id) VALUES (" . $account_id . "," . $pen_id . ")";
	} else {
		echo "OOOops";
		die();
	}
} else if ($list == 'got' && isset($_POST['got'])) {
	if ($_POST['got'] == 1) {
		$query = "DELETE FROM got_list WHERE account_id=" . $account_id . " AND pen_id=" . $pen_id;
	} else if ($_POST['got'] == 0) {
		$query = "INSERT INTO got_list(account_id,pen_id) VALUES (" . $account_id . "," . $pen_id . ")";
	} else {
		echo "Bro what are you trying";
		die();
	}
} else {
	die();
	echo "Just stop try if you are noob";
}

$result = $mysqli->query($query);
$mysqli->close();

//header('Location: ' . $_SERVER['HTTP_REFERER']);
//die();
?>
