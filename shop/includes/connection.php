<?php
$db = mysql_connect("192.168.0.51","tilesbsu_liveusr","KLhsdf235U21");
	if (!$db)
	{
		echo "Database connection error! Please try again.";
		exit;
	}
	mysql_query("SET NAMES 'utf8'"); 
	mysql_select_db("tilemob_tilebsu_live");

?>