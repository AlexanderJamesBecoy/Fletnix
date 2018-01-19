<?php

session_start();
require_once("connection.php");
require_once("functions.php");
require_once("configs.php");

if((getPage('films') || getPage('view_movie') || getPage('user')) && (!isset($_SESSION['user']))) {
	header('Location: /Fletnix');
} elseif((getPage('/Fletnix') || getPage('abonnement')) && (isset($_SESSION['user']))) {
	header('Location: films');
} elseif((getPage('films?registered'))) {
	echo '<div class="notification-box">
				<dt>Nieuw account is aangemakt!</dt>
				<dd>Geniet nu van duizenden films!</dd>
			</div>';
}

if(isset($_POST["submit"])) {
	$user = compareLogin($dbh, strip_tags($_POST['email']), strip_tags($_POST['psw']));
	$_SESSION['user'] = $user;
	$_SESSION['logged_in'] = date('H:ia');
}

if(isset($_POST["delete"])) {
	deleteCustomer($dbh, strip_tags($_SESSION['user']['customer_mail_address']), strip_tags($_SESSION['user']['firstname']));
	$_SESSION['user'] = NULL;
}

if(isset($_POST["register"])) {
	$customerMailAddress = strip_tags($_POST['register_email']);
	$query = $dbh->prepare("SELECT * FROM Customer WHERE customer_mail_address = ?");
	$query->execute(array($customerMailAddress));
	$row = $query->fetch();
	if($row > 0) {
		echo '<div class="notification-box">
					<dt>Access denied!</dt>
					<dd>Account met de bijbehorende e-mail bestaat al.</dd>
				</div>';
	} else {
		$password = strip_tags($_POST['register_password']);
		$passwordConfirmed = strip_tags($_POST['register_confirm_password']);
		if($passwordConfirmed !== $password) {
			echo '<div class="notification-box">
						<dt>Access denied</dt>
						<dd>Wachtwoord komen niet overeen.</dd>
					</div>';
		} else {
			$firstname = strip_tags($_POST['register_firstname']);
			$lastname = strip_tags($_POST['register_lastname']);
			$username = strip_tags($_POST['register_username']);
			$birthDate = strip_tags($_POST['register_birthdate']);
			$countryName = strip_tags($_POST['register_country']);
			$contractType = strip_tags($_POST['register_contract']);
			$paymentMethod = strip_tags($_POST['register_payment_method']);
			$paymentCardNumber = strip_tags($_POST['register_payment_number']);
			$gender = strip_tags($_POST['register_gender']);
			createUser($dbh, $firstname, $lastname, $customerMailAddress, $username, $birthDate, $password, $countryName, $contractType, $paymentMethod, $paymentCardNumber, $gender);
		}
	}
}

$genre = isset($_GET['filter_genre'])? strip_tags($_GET['filter_genre']) : NULL;

?>

<!DOCTYPE html>
<html lang="NL">
<head>
	<meta charset="UTF-8">
	<meta name="author" content="Alexander James Becoy and Tim Klaassen">
	<meta name="description" content="An offline film service for ambitious Sci-Fi lovers.">
	<meta name="keywords" content="Sci-Fi, Fletnix, films, offline, space">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Fletnix - Kijk sci-fi's!</title>
</head>
<body>
<div class="bg-gradient"></div>
	<nav>
		<ul>
			<?php
			if(isset($_SESSION['user'])) {
				echo '<li>
						Groetens, '.$_SESSION['user']['firstname'].'!<br/>
						<p>'.translateDate(date('D'), date('d'), date('m')).'</p>
						<p>Laatst ingelogd: '.$_SESSION['logged_in'].'</p>
						<a class="user-a" href="user">Bekijk profiel</a>
						&nbsp;|&nbsp;
						<a class="user-a" href="logout">Uitloggen</a>
					</li>
					<li>
						<a href="films">Film</a>'.getGenres($dbh).'
					</li>';
			} else {
				echo '<button onclick="document.getElementById(\'id01\').style.display=\'block\'">Login</button>';
				echo '<li><a href="abonnement">Abonnement</a></li>';
			}
			?>
			<li><a href="over_ons">Over Ons</a></li>
		</ul>
	</nav>

	<div id="id01" class="modal">
	  <form class="modal-content animate" action="index.php" method="POST">
	    <div class="imgcontainer">
	      <span onclick="document.getElementById('id01').style.display='none'" class="close">&times;</span>
	      <img src="images/img_avatar2.png" alt="Avatar" class="avatar">
	    </div>

	    <div class="container">
	      <label><b>Email</b></label>
	      <input type="text" placeholder="email adres" name="email" required autofocus>

	      <label><b>Wachtwoord</b></label>
	      <input type="password" placeholder="wachtwoord" name="psw" required>
	      <input type="submit" name="submit" value="Inloggen">
	    </div>
	  </form>
	</div>

	<div class="container">
		<header>
			<a class="logo" href="../Fletnix/"><img src="images/logo.png" alt="logo"></a>
			<?php
				if(getPage('films') || getPage('view_movie')) { viewFilmHeader($dbh, $genre); }
				echo "<h1>$greeting</h1>";
			?>
		</header>

	<script>
		// Login
		var modal = document.getElementById('id01');

		window.onclick = function(event) {
		    if (event.target === modal) {
		        modal.style.display = "none";
		    }
		}
	</script>
