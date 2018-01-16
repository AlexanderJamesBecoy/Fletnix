<?php
	include("core/header.php");
    if(isset($user)) {
        $user = $user;
    }
?>

<div class="box">
	<div class="box-1-2">
		<img src="images/HAL9000.svg.png" alt="HAL-9000" width="200px">
	</div>
	<div class="box-1-2">
		<h2>I'm Sorry <?php echo $user; ?>, I Can't Let You Do That</h2>
		<p>Error 404 - page not found.</p>
	</div>
</div>

<?php include("core/footer.php"); ?>
