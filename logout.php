<?php
	session_start();
	session_destroy();
    header("Location: /Fletnix");
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Fletnix - Uitloggen</title>
        <link rel="icon" type="image/png" href="images/favicon.png">
	</head>
	<body>
		<meta http-equiv="refresh" content="1;url=/Fletnix?logged_out"/>
	</body>
</html>
