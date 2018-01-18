<?php
if(!isset($_COOKIE["PHPSESSID"]))
{
  session_start();
}
include("core/header.php");
require_once("core/connection.php");
require_once("core/functions.php");
require_once("core/configs.php");

if(isset($_POST["submit2"])) {
	$user = createUser($dbh, $_POST['register_voornaam'], $_POST['register_achternaam'], $_POST['register_email'], $_POST['register_gebruikersnaam'],
	$_POST['register_gebruikersnaam'],$_POST['register_wachtwoord'],$_POST['register_wachtwoord_bevestigen'],$_POST['register_land'], 
	$_POST['register_abonnement'], $_POST['register_rekening']);
}
?>


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
					<td>10.0%</td>
				</tr>
			  	<tr>
			  		<td>Mothership</td>
			    	<td>€10.00</td>
					<td>&infin;</td>
					<td>25.0%</td>
				</tr>
			</table>
			<div class="box" id="registreer">
				<form method="POST" action="http://localhost/Fletnix/">
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
							<label for="register_voornaam">Voornaam</label>
							<input type="text" id="register_voornaam" name="register_voornaam" placeholder="Uw voornaam" required>
						</div>
						<div class="form-group">
							<label for="register_achternaam">Achternaam</label>
							<input type="text" id="register_achternaam" name="register_achternaam" placeholder="Uw achternaam" required>
						</div>
						<div class="form-group">
							<label for="register_email">E-mail adres</label>
							<input type="text" id="register_email" name="register_email" placeholder="Uw email-adres" required>
						</div>
						<div class="form-group">
							<label for="register_gebruikersnaam">Gebruikersnaam</label>
							<input type="text" id="register_gebruikersnaam" name="register_gebruikersnaam" placeholder="Uw gebruikersnaam" required>
						</div>
						<div class="form-group">
							<label for="register_geboorte">Geboortedatum</label>
							<input type="date" id="register_geboorte" name="register_geboorte" required>
						</div>
						<div class="form-group">
							<label for="register_wachtwoord">Wachtwoord</label>
							<input type="password" id="register_wachtwoord" name="register_wachtwoord" required>
						</div>
						<div class="form-group">
							<label for="register_wachtwoord_bevestigen">Wachtwoord bevestigen</label>
							<input type="password" id="register_wachtwoord_bevestigen" name="register_wachtwoord_bevestigen" required>
						</div>
						<div class="form-group">
							<label for="register_land">Land</label>
							<select id="register_land" name="register_land" required>
								<option value="" selected disabled hidden>--Land--</option>
								<option value="netherlands">Nederland</option>
								<option value="chile">chili</option>
								<option value="luxembourg">luxemburg</option>
							</select>
						</div>
						<div class="form-group center">
							<label for="register_abonnement">Abonnement</label>
							<select id="register_abonnement" name="register_abonnement" required>
								<option value="" selected disabled hidden>--Kies een voyager--</option>
								<option value="basic">Millenium Falcon</option>
								<option value="premium">Enterprise</option>
								<option value="pro">Mothership</option>
							</select>
						</div>
						<div class="form-group">
							<label for="register_rekening">Rekeningnummer</label>
							<input type="text" id="register_rekening" name="register_rekening" placeholder="Uw rekeningnummer" required>
						</div>
						<div class="form-group">
							<input type="submit" name="submit2" value="Registreer">
						</div>
					</div>
				</form>
			</div>
		</div>

<?php include("core/footer.php"); ?>
