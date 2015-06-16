<?
$server = "MYSQL-3.tilemob.com.au";
$username = "mybook1020";
$password = "BdNLQvta";
$database = "bookingform_tilemob_com_au";

$dbh = mysql_connect ($server, $username, $password) or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ($database, $dbh);

?>