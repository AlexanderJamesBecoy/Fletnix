<?php

session_start();
require_once("connection.php");
require_once("functions.php");
require_once("configs.php");

if(isset($_POST["submit"])) {
	//$_SESSION['user'] = $_POST["email"];
	$result = compareLogin($_SESSION['email'], $_SESSION['psw']);
	$user = getUserInfo($result);
	$_SESSION['user'] = $user['firstname'];
}

if(isset($_SESSION['user'])) $user = $_SESSION['user'];
$genre = isset($_GET['filter_genre'])? $_GET['filter_genre'] : NULL;

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
	<title>Fletnix - Kijk sci-fi's!</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="bg-gradient"></div>
	<nav>
		<ul>
			<?php
			if(isset($user)) {
				echo '<li>
						Welkom terug, '.$user.'!
						<a class="user-a" href="user">Bekijk profiel</a>
						<a class="user-a" href="logout">Uitloggen</a>
					</li>
					<li>
						<a href="films">Film</a>'.getGenres($dbh).'
					</li>
					';
			} else {
				echo '<button onclick="document.getElementById(\'id01\').style.display=\'block\'">Login</button>';
				echo '<li><a href="abonnement">Abonnement</a></li>';
			}
			?>
			<li><a href="over_ons">Over Ons</a></li>
		</ul>
	</nav>

<div id="id01" class="modal">

  <form class="modal-content animate" action="#" method="POST">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
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
			<a class="logo" href="/Fletnix"><img src="images/logo.png" alt="logo"></a>
			<?php
				if (isset($user)&&(getPage('films') || getPage('view_movie'))){ viewFilmHeader($dbh, $genre); }
				echo "<h1>$greeting</h1>";
			?>


<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
		</header>
