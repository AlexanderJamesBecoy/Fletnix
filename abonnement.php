<?php include("core/header.php") ?>

		<div class="box" id="abonnementen">
			<table id="table-subscription">
				<tr>
					<th>Voyager</th>
					<th>Prijs per maand</th>
					<th>Films per dag</th>
					<th>Uw korting!</th>
				</tr>
				<tr>
				    <td>Millenium Falcon</td>
				    <td>€02.50</td>
					<td>10</td>
					<td>0.0%</td>
				</tr>
				<tr>
				    <td>Enterprise</td>
				    <td>€07.50</td>
					<td>20</td>
					<td>20.0%</td>
				</tr>
			  	<tr>
			  		<td>Mothership</td>
			    	<td>€10.00</td>
					<td>&infin;</td>
					<td>40.0%</td>
				</tr>
			</table>
			<div class="box" id="registreer">
				<form method="POST" action="index.php">
					<div class="form-register">
						<svg height="60" width="100%">
	    					<path d="M0,60 L50,0 L800,0 L750,60z" fill="#4286F4" />
		    				<a href="#registreer">
								<text x="400" y="37" font-weight="500">Registreer nu!</text>
		    				</a>
						</svg>
					</div>
					<div class="form-control">
						<div class="form-group">
							<label for="register_firstname">Voornaam</label>
							<input type="text" id="register_firstname" name="register_firstname" placeholder="Uw voornaam" required>
						</div>
						<div class="form-group">
							<label for="register_lastname">Achternaam</label>
							<input type="text" id="register_lastname" name="register_lastname" placeholder="Uw achternaam" required>
						</div>
						<div class="form-group">
							<label for="register_email">E-mail adres</label>
							<input type="text" id="register_email" name="register_email" placeholder="Uw email-adres" required>
						</div>
						<div class="form-group">
							<label for="register_gender">Geslacht</label>
							<select id="register_gender" name="register_gender" required>
								<option selected disabled hidden>--Je geslacht--</option>
								<option value="M">Man</option>
								<option value="F">Vrouw</option>
							</select>
						</div>
						<div class="form-group">
							<label for="register_username">Gebruikersnaam</label>
							<input type="text" id="register_username" name="register_username" placeholder="Uw gebruikersnaam" required>
						</div>
						<div class="form-group">
							<label for="register_birthdate">Geboortedatum</label>
							<input type="date" id="register_birthdate" name="register_birthdate" required>
						</div>
						<div class="form-group">
							<label for="register_password">Wachtwoord</label>
							<input type="password" id="register_password" name="register_password" required>
						</div>
						<div class="form-group">
							<label for="register_confirm_password">Wachtwoord bevestigen</label>
							<input type="password" id="register_confirm_password" name="register_confirm_password" required>
						</div>
						<div class="form-group">
							<label for="register_country">Land</label>
							<select id="register_country" name="register_country" required>
								<option selected disabled hidden>--Land--</option>
								<?php getCountry($dbh); ?>
							</select>
						</div>
						<div class="form-group">
							<label for="register_contract">Abonnement</label>
							<select id="register_contract" name="register_contract" required>
								<option value="" selected disabled hidden>--Kies een voyager--</option>
								<option value="Basic">Millenium Falcon</option>
								<option value="Premium">Enterprise</option>
								<option value="Pro">Mothership</option>
							</select>
						</div>
						<div class="form-group">
							<label for="register_payment_method">Betalingswijze</label>
							<select id="register_payment_method" name="register_payment_method" required>
								<option value="" selected disabled hidden>--Betalingswijze--</option>
								<?php getPaymentMethods($dbh); ?>
							</select>
						</div>
						<div class="form-group">
							<label for="register_payment_number">Rekeningnummer</label>
							<input type="text" id="register_payment_number" name="register_payment_number" placeholder="Uw rekeningnummer" maxlength="10" required>
						</div>
						<div class="form-group">
							<input type="submit" name="register" value="Registreer">
						</div>
					</div>
				</form>
			</div>
		</div>

<?php include("core/footer.php"); ?>
