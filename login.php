<?php include("core/header.php"); ?>

		<div id="box-login">
			<form method="GET" action="index_ingelogd.html">
				<svg height="60" width=100%>
	    			<path d="M0,60 L50,0 L420,0 L1000,0 1000,60z" fill="#4286F4" />
					<text x="50" y="37" font-size="18" font-weight="500" fill="white">Inloggen</text>
				</svg>
				<div class="form-control">
					<div class="form-group">
						<label for="login_gebruikersnaam">Gebruikersnaam</label>
						<input type="text" name="login_gebruikersnaam" id="login_gebruikersnaam" required>
					</div>
					<div class="form-group">
						<label for="login_wachtwoord">Wachtwoord</label>
						<input type="password" name="login_wachtwoord" id="login_wachtwoord" required>
					</div>
					<div class="form-group">
						<span>
							<input type="checkbox" name="login_herinneren" value="Remember Me">
							Remember Me
						</span>
					</div>
					<div class="form-group">
						<input type="submit" name="verzenden" value="Inloggen">
					</div>
				</div>
			</form>
		</div>

<?php include("core/footer.php"); ?>
