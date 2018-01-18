<?php
	$siteIndex = 0;
	include("core/header.php");
	if(isset($_SESSION['user'])) {
		header("Location: films");
	}
?>

<div class="box">
	<div class="box-1-2">
		<img src="images/beyond_earth.jpg" alt="Beyond Earth">
	</div>
	<div class="box-1-2">
		<h2>Wat is Fletnix?</h2>
		<p>Wil jij Netflix kijken, maar alleen toekomstige en kan waar gebeuren coole dingen willen zien? Fletnix is een service waar jij, een geliefde science-fiction lover, offline alleen science-fiction films kan kijken.</p>
		<p>Doe nu mee voor minstens €2.50 en kijk alles die jij wilt ook tijdens een netwerk black-out!</p>
	</div>
</div>

<?php include("core/footer.php"); ?>
