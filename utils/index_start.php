<?php
/* start session */
session_start();

if (isset($_GET['search'])) {
	$search_value = $_GET['search'];
}

$reg_err = 0;
if(isset($_GET['not_same_password']) || isset($_GET['username_already_used']) || isset($_GET['not_valid_email']) || isset($_GET['email_already_used'])) {
	$reg_err = 1;
}

$log_err = 0;
if(isset($_GET['account_not_found']) || isset($_GET['bad_password'])) {
	$log_err = 1;
}

/* Utils */
$DISPLAY_TYPES=["none;", "block;"];
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>BIC COLLECTION</title>
	<link rel="icon" type="image/png" href="./favicon.png" >
	<link rel="apple-touch-icon" type="image/png" href="./favicon.png" >
	<link rel="apple-touch-icon-precomposed" type="image/png" href="./favicon.png" >
	<link rel="shortcut icon" type="image/png" href="./favicon.png" >
	<link rel="stylesheet" href="index.css">
	<header class="header">
		<div class="header-inner wrapper">
			<h1 class="title">
				Unofficial Bic Collection
			</h1>
			<!-- /.title -->
		</div>
		<!-- /.header-inner wrapper -->
	</header>
	<!-- /.header -->
</head>
<body>
<main class="main" role="main">

<div id="connect_button" style="<?php if (isset($_SESSION['logged_user'])) { echo 'opacity: 0.5;'; } ?>">
	<div class="login_button" value="0" id="log_btn" onclick="toggleValues('log_btn', 'login_form')">
		<img src="assets/login.png"></img>
	</div>
	<div class="register_button" value="0" id="reg_btn" onclick="toggleValues('reg_btn', 'register_form')">
		<img src="assets/register.png"></img>
	</div>
</div>
<h5 style="position: fixed; left: 20px; top: 5px; margin-top: 0px;"><?php if (isset($_SESSION['logged_user'])){ echo 'Bienvenue ' . $_SESSION['logged_user']; } ?></h5>
<label class="total_count" id="total_count">
</label>
<div class="register_form" id="register_form" style="display: <?php echo $DISPLAY_TYPES[intval($reg_err, 10)]; ?>">
	<form action="register.php" method="POST">
		<img src="assets/white_cross.png" style="cursor: pointer; position: relative; margin-left: 77%;" onclick='removeForms()'></img>
		<h1 style="top: 0; position: absolute;">S'inscrire</h1>
		<hr>

		<label><b>Pseudo</b></label>
		<input type="text" placeholder="Enter Username" name="register_username" style="width: 280;" id="username" required>

		<label><b>Email</b></label>
		<input type="text" placeholder="Enter Email" name="register_email" style="width: 280;" id="email" required>

		<label><b>Mot de passe</b></label>
		<input type="password" placeholder="Enter Password" name="register_password" style="width: 280;" id="password" required>

		<label><b>Mot de passe confirmation</b></label>
		<input type="password" placeholder="Repeat Password" name="register_password_repeat" style="width: 280;" id="password_repeat" required>
		<hr>

		<?php
			if (isset($_GET['not_same_password'])) {
				echo '<p style="color: #FF0000;">Not same passwords</p>';
			}
			if (isset($_GET['not_valid_email'])) {
				echo '<p style="color: #FF0000;">Not valid email</p>';
			}
			if (isset($_GET['username_already_used'])) {
				echo '<p style="color: #FF0000;">Username already used</p>';
			}
			if (isset($_GET['email_already_used'])) {
				echo '<p style="color: #FF0000;">Email already used</p>';
			}
		?>
		<button type="submit" class="registerbtn">Register</button>
	</form>
</div>
<div class="login_form" id="login_form"  style="display: <?php echo $DISPLAY_TYPES[intval($log_err, 10)]; ?>">
	<form action="login.php" method="POST">
		<img src="assets/white_cross.png" style="cursor: pointer; position: relative; margin-left: 82%;" onclick="removeForms()"></img>
		<h1 style="top: 0; position: absolute;">Se connecter</h1>
		<hr>

		<label><b>Pseudo</b></label>
		<input type="text" placeholder="Enter Username" name="login_username" style="width: 280;" id="username" required>

		<label><b>Mot de passe</b></label>
		<input type="password" placeholder="Enter Password" name="login_password" style="width: 280;" id="password" required>
		<hr>

		<?php
			if (isset($_GET['account_not_found'])) {
				echo '<p style="color: #FF0000;">Username not found</p>';
			}
			if (isset($_GET['bad_password'])) {
				echo '<p style="color: #FF0000;">Bad password</p>';
			}
		?>
		<button type="submit" class="loginbtn">Login</button>
	</form>
</div>
<section id="make_search">
	<div class="filter_menu">
		<form id="form1" action="" method="GET">
			<div class="wish_filter">
				<input type="checkbox" name="wish" id="wish_check" style="position: relative; bottom: 20px;" onchange="submitReq()" <?php if (isset($_GET['wish'])&&$_GET['wish']=='on'){echo 'checked="checked"';} ?>>
				<img src="assets/heart_on_64.png">
				<input type="checkbox" name="not_wish" id="not_wish_check" style="position: relative; bottom: 20px;" onchange="submitReq()" <?php if (isset($_GET['not_wish'])&&$_GET['not_wish']=='on'){echo 'checked="checked"';} ?>>
				<img src="assets/heart_off_64.png">
			</div>
			<div class="got_filter">
				<input type="checkbox" name="got" id="got_check" style="position: relative; bottom: 20px;" onchange="submitReq()" <?php if (isset($_GET['got'])&&$_GET['got']=='on'){echo 'checked="checked"';} ?>>
				<img src="assets/safe_on_64.png">
				<input type="checkbox" name="not_got" id="not_got_check" style="position: relative; bottom: 20px;" onchange="submitReq()" <?php if (isset($_GET['not_got'])&&$_GET['not_got']=='on'){echo 'checked="checked"';} ?>>
				<img src="assets/safe_off_64.png">
			</div>
			<div class="search_bar" placeholder="search">
				<input type="text" name="search" value="<?php echo $search_value; ?>" class="search_input" placeholder="Recherche" style="height: 28px; border-radius: 5px; color: #000000; cursor: text; padding: 4px;">
				<input type="submit" value="Rechercher" style="width: 105px; color: black; height: 28px; border-radius: 8px;" />
			</div><br>
