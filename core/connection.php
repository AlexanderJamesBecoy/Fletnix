<?php

$hostname = "(local)";
$dbname = "Fletnix";
$username = "sa";
$pw = "";

try {
    $dbh = new PDO("sqlsrv:Server=$hostname;Database=$dbname;
                    ConnectionPooling=0, $username, $pw");
} catch (PDOException $e) {
    echo '<div class="error-box"';
        echo "<p>Houston, we have a problem... The database won't connect.<br>";
        echo "{$e->getMessage()}</p>";
    echo "</div>";
}

?>
