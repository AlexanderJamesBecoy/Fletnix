<?php

$greeting = "Greeting, Humans";
$PAGES = array('films', 'abonnement', 'login', 'over_ons', 'view_movie', 'user');
$GREETINGS = array("Films", "Join The Revolution", "Beam Me Up, Scotty", "The Architects", "Beep boop", "SYNCHRONIZE://");

for($pageIndex = 0; $pageIndex < count($PAGES); $pageIndex++)
{
	if (getPage($PAGES[$pageIndex])) {
		$greeting = $GREETINGS[$pageIndex];
	}
}

?>
