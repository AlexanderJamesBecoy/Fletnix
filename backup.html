<?php

require_once("connection.php");
require_once("functions.php");
require_once("configs.php");

$user = "Tim";
$genre = isset($_GET['filter_genre'])? $_GET['filter_genre'] : NULL;
$search = isset($_GET['filter_search'])? $_GET['filter_search'] : NULL;
$director = isset($_GET['filter_director'])? $_GET['filter_director'] : NULL;
//$order = isset($_GET['filter_order'])? $_GET['filter_order'] : 'title';

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
	<title>Fletnix - Kijk sci-fi's offline</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div class="bg-gradient"></div>
	<nav>
		<ul>
			<?php
			if($user != NULL) {
				echo '<li>
						Welkom terug, '.$user.'!
						<p>'.translateDate(date('D'), date('d'), date('m')).'</p>
						<p>Ingelogd sinds xxx</p>
						<a class="user-a" href="user">Bekijk profiel</a>
						<a class="user-a" href="logout">Uitloggen</a>
					</li>
					<li><a href="films">Film</a>'.getGenres($dbh).'</li>';
			} else {
				echo '<li><a href="login">Inloggen</a></li>';
				echo '<li><a href="abonnement">Abonnement</a></li>';
			}
			?>
			<li><a href="over_ons">Over Ons</a></li>
		</ul>
	</nav>
	<div class="container">
		<header>
			<a class="logo" href="/Fletnix"><img src="images/logo.png" alt="logo"></a>
			<?php
				if (getPage('films') || getPage('view_movie')){ viewFilmHeader($dbh, $genre, $director); }
				echo "<h1>$greeting</h1>";
			?>
		</header>
