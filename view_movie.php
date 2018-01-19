<?php

	include('core/header.php');
	$movie_id = strip_tags($_GET['id']);
	$query = $dbh->prepare("SELECT * FROM Movie WHERE movie_id = ?");
	$query->execute(array($movie_id));
	$movie = $query->fetch();
	if(count($movie) < 1) {
		header("Location: error");
	}

?>

		<div class="box">
			<div class="box">
				<h1><?php echo $movie['title']; ?></h1>
			</div>
			<div class="box-1-2">
				<div id="movie-poster">
					<img src="<?php echo getFilmPoster($movie['cover_image']); ?>" alt="movie-poster">
				</div>
			</div>
			<div class="box-1-2">
				<?php getDetailFromMovie($dbh, $movie, $_SESSION['user']); ?>
			</div>
			<?php
				if(isset($movie['URL'])) {
					$url = substr($movie['URL'], -11);
					echo '<iframe id="trailer" height="400px" src="https://www.youtube.com/embed/'.$url.'"></iframe>';
				}
			?>
		</div>

<?php include('core/footer.php'); ?>
