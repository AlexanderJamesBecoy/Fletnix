<?php

$greeting = "Greeting, Humans";
$PAGES = array('films', 'abonnement', 'login', 'over_ons');
$GREETINGS = array("Films", "Join The Revolution", "Beam Me Up, Scotty", "The Architects");

for($page = 0; $page < count($PAGES); $page++)
{
	if (getPage($PAGES[$page])) {
		$greeting = $GREETINGS[$page];
	}
}

?>
