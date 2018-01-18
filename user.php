<?php
	$siteIndex = 0;
	include("core/header.php");
	if(!isset($_SESSION['user'])) {
		header("Location: films");
	}
	$user = $_SESSION['user'];
?>

<div class="box">
	<h1>Astronaut <?php echo $user['user_name']; ?></h1>
	<div class="box-1-2">
		<img src="images/users/default_user.png" alt="astronaut" width="200px">
	</div>
	<div class="box-1-2">
		<table class="table-detail">
			<tr>
				<th>Naam</th>
				<td><?php echo $user['firstname'].' '.$user['lastname']; ?></td>
			</tr>
			<tr>
				<th>Geslacht</th>
				<td><?php echo getGender($user['gender']); ?></td>
			</tr>
			<tr>
				<th>Geboren op</th>
				<td><?php echo date("d/m/Y", strtotime($user['birth_date'])); ?></td>
			</tr>
			<tr>
				<th>Land</th>
				<td><?php echo $user['country_name']; ?></td>
			</tr>
			<tr>
				<th>Type contract</th>
				<td><?php echo getContract($user['contract_type']); ?></td>
			<tr>
				<th>Geabonneerd sinds</th>
				<td><?php echo date("d/m/Y", strtotime($user['subscription_start'])); ?></td>
			</tr>
			<tr>
				<th>Uitgegeven</th>
				<td><?php echo collectInvoiced($dbh, $user['customer_mail_address']); ?></td>
			</tr>
			<tr>
				<th>Schulden</th>
				<td><?php echo collectInvoiced($dbh, $user['customer_mail_address'], false); ?></td>
			</tr>
		</table>
		<hr>
		<table class="user-movie-detail">
			<h2>Meest bekeken films</h2>
				<tr>
					<th class="title">Film</th>
					<th>Uitgekomen</th>
					<th>Aantal keer gekeken</th>
				</tr>
				<?php mostViewedMovies($dbh, $user); ?>
		</table>
	</div>
</div>

<?php include("core/footer.php"); ?>
