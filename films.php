<?php

	include('core/header.php');
	$page = isset($_GET['page'])? $_GET['page'] : 1;

?>
		<div class="box-films">
			<?php retrieveMoviesInBox($dbh, $page, $genre); ?>
		</div>

<?php include('core/footer.php'); ?>
