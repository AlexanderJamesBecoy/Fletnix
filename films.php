<?php

	include('core/header.php');
	$page = isset($_GET['page'])? $_GET['page'] : 1;

?>
		<div class="box-films">
			<?php drawFilms($dbh, $page, $genre, $search); ?>
		</div>

<?php include('core/footer.php'); ?>
