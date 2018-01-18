<?php

$hostname = "(local)";
$dbname = "FLETNIX_DOCENT";
$username = "sa";
$pw = "";

try {
    $dbh = new PDO("sqlsrv:Server=$hostname;Database=$dbname; ConnectionPooling=0, $username, $pw");
} catch (PDOException $e) {
    echo '<div class="notification-box>
            <dt>Houston, we have a problem... The database won\'t connect.</dt>
            <dd>'.$e->getMessage().'</dd>
        </div>';
}

?>
