<?php

require("functions.php");
require("configs.php");

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
			<li>
				<a href="films">Films</a>
				<ul>
					<li><a href="films#adventure">Adventure</a></li>
					<li><a href="films#comedy">Comedy</a></li>
					<li><a href="films#action">Action</a></li>
					<li><a href="films#drama">Drama</a></li>
					<li><a href="films#horror">Horror</a></li>
				</ul>
			</li>
			<li><a href="abonnement">Abonnement</a></li>
			<li><a href="login">Inloggen</a></li>
			<li><a href="over_ons">Over Ons</a></li>
		</ul>
	</nav>
	<div class="container">
		<header>
			<a class="logo" href="/Fletnix"><img src="images/logo.png" alt="logo"></a>
			<?php
				if (getPage('films')){
				     echo '<form method="GET">
								<input type="text" name="zoekveld" size="30" placeholder="Zoek een film...">
								<input type="submit" name="zoek" value="Zoek">
								<select name="filter_genre">
									<option selected disabled hidden>-- Kies een genre --</option>
									<option value="genre_default">Alles</option>
									<option value="genre_adventure">Adventure</option>
									<option value="genre_adventure">Action</option>
									<option value="genre_adventure">Comedy</option>
									<option value="genre_adventure">Drama</option>
									<option value="genre_adventure">Horror</option>
								</select>
							</form>';
				}
			echo "<h1>$greeting</h1>";
			?>
		</header>
