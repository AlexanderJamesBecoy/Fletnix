<?php
	$siteIndex = 0;
	include("core/header.php");
	if(!isset($_SESSION['user'])) {
		header("Location: films");
	}
	$user = $_SESSION['user'];

	if(isset($_POST["change"])) {
		updateCustomerContract($dbh, $_SESSION['user']['customer_mail_address'], $_POST['register_abonnement']);
		$user = $_SESSION['user'];
	}
?>
<body>
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
			</tr>
			<tr>
				<th>Betalingswijze</th>
				<td><?php echo $user['payment_method']; ?></td>
			</tr>
			<tr>
				<th>Rekeningnummer</th>
				<td><?php echo $user['payment_card_number']; ?></td>
			</tr>
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
		<div class="user-change">
			<div class="update" >
				<button onclick="document.getElementById('id02').style.display='block'">Verander abonnement</button>
			</div>
			<div class="delete" >
				<button onclick="document.getElementById('id03').style.display='block'">Verwijder account</button>
			</div>
		</div>
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

<div id="id02" class="modal">
	  <form class="modal-content animate" action="user" method="POST">
	    <div class="imgcontainer">
	      <span onclick="document.getElementById('id02').style.display='none'" class="close">&times;</span>
	      <img src="images/img_avatar2.png" alt="Avatar" class="avatar">
	    </div>
	    <div class="form-group center">
			<label for="register_abonnement">Abonnement</label>
			<select id="type_new" name="register_abonnement" required>
				<option value="" selected disabled hidden>--Kies een voyager--</option>
				<option value="abonnement_millenium_falcon">Millenium Falcon</option>
				<option value="abonnement_enterprise">Enterprise</option>
				<option value="abonnement_mothership">Mothership</option>
			</select>
		</div>
		<div class="form-group">
			<input type="submit" name="change" value="Opslaan">
		</div>
	  </form>

	  <script>
		// change contract_type
		var modal = document.getElementById('id02');

		window.onclick = function(event) {
		    if (event.target === modal) {
		        modal.style.display = "none";
		    }
		}
	</script>
</div>

<div id="id03" class="modal">
	  <form class="modal-content animate" action="index.php" method="POST">
	    <div class="imgcontainer">
	      <span onclick="document.getElementById('id03').style.display='none'" class="close">&times;</span>
	      <img src="images/img_avatar2.png" alt="Avatar" class="avatar">
	    </div>
	    <div class="form-group center">
			<p>Weet u het zeker, dat u uw account wilt verwijderen?</p>
		</div>
		<div class="form-group">
			<input type="submit" name="delete" value="Verwijder">
		</div>
	  </form>

	  <script>
		// change contract_type
		var modal = document.getElementById('id03');

		window.onclick = function(event) {
		    if (event.target === modal) {
		        modal.style.display = "none";
		    }
		}
	</script>
</div>

<?php include("core/footer.php"); ?>
</body>
