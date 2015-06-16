<?php
$_server = "MYSQL-3.tilemob.com.au";
$_username = "mybook1020";
$_password = "BdNLQvta";
$_database = "bookingform_tilemob_com_au";

$_dbh = mysql_connect ($_server, $_username, $_password) or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ($_database, $_dbh);
?>
