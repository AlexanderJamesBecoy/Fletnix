<?php

	include('core/header.php');
	$page = isset($_GET['page'])? $_GET['page'] : 1;
	$search = isset($_GET['filter_search'])? $_GET['filter_search'] : NULL;
	$director = isset($_GET['filter_director'])? $_GET['filter_director'] : NULL;

?>
		<div class="box-films">
			<?php drawFilms($dbh, $page, $genre, $search, $director); ?>
		</div>

<?php include('core/footer.php'); ?>
