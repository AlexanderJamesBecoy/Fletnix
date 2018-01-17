<?php

$greeting = "Greeting, Humans";
$PAGES = array('films', 'abonnement', 'login', 'over_ons', 'view_movie');
$GREETINGS = array("Films", "Join The Revolution", "Beam Me Up, Scotty", "The Architects", "Beep boop");

for($pageIndex = 0; $pageIndex < count($PAGES); $pageIndex++)
{
	if (getPage($PAGES[$pageIndex])) {
		$greeting = $GREETINGS[$pageIndex];
	}
}

?>
