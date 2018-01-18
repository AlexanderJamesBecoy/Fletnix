<?php

	include('core/header.php');
	if(!isset($_SESSION['user'])) {
		header("Location: /Fletnix");
	}
	$movie_id = strip_tags($_GET['id']);
	$query = $dbh->prepare("SELECT * FROM Movie WHERE movie_id = ?");
	$query->execute(array($movie_id));
	if($query->rowCount() == 0) { header("Location: error"); }
	$movie = $query->fetch();

?>

		<div class="box">
			<div class="box">
				<h1><?php echo $movie['title']; ?></h1>
				<!--
				<video controls autoplay>
					<source src="videos/trailer.mp4" type="video/mp4">
					Your browser does not support the video tag.
				</video>
				-->
			</div>
			<div class="box-1-2">
				<div id="movie-poster">
					<img src="<?php echo getFilmPoster($movie['cover_image']); ?>" alt="movie-poster">
				</div>
			</div>
			<div class="box-1-2">
				<?php getDetailFromMovie($dbh, $movie); ?>
			</div>
		</div>

<?php include('core/footer.php'); ?>
