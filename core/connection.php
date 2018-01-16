<?php

$hostname = "(local)";
$dbname = "gsdf";
$username = "sa";
$pw = "";

try {
    $dbh = new PDO("sqlsrv:Server=$hostname;Database=$dbname;
                    ConnectionPooling=0, $username, $pw");
} catch (PDOException $e) {
    echo '<div class="error-box"';
        echo "<dt>Houston, we have a problem... The database won't connect.</dt>";
        echo "<dd>{$e->getMessage()}</dd>";
    echo "</div>";
}

?>
