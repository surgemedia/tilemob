<?php
$db = mysql_connect("localhost","tilesbsu_liveusr","KLhsdf235U21");
	if (!$db)
	{
		echo "Database connection error! Please try again.";
		exit;
	}
	mysql_query("SET NAMES 'utf8'"); 
	mysql_select_db("tilesbsu_live");

?>