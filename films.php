<?php

	include('core/header.php');
	$page = isset($_GET['page'])? strip_tags($_GET['page']) : 1;
	$search = isset($_GET['filter_search'])? strip_tags($_GET['filter_search']) : NULL;
	$director = isset($_GET['filter_director'])? strip_tags($_GET['filter_director']) : NULL;

?>
		<div class="box-films">
			<?php drawFilms($dbh, $page, $genre, $search, $director); ?>
		</div>

<?php include('core/footer.php'); ?>
