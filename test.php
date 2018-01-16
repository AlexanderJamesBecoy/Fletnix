<?php include("core/header.php");

$data = $dbh->query("SELECT * FROM Customer");

while($user = $data->fetch()) {
    echo $user['customer_mail_address'].'<br>';
}

?>
