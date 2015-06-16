<?
setcookie("11300","testcookie",time()+3600,"/");
setcookie("11350","testcookie",time()+3600,"/");
?>
<html>
<head>
<title></title>
<script language="javascript">
	document.cookie = "11450=testing2; expires=0; path=/";
</script>
</head>
<body>
<?
	echo "Tiles in your Collection: \n";
	//print_r($_COOKIE); 
	echo $_COOKIE["11300"]."\n";
	echo $_COOKIE["11350"]."\n";
	echo $_COOKIE["11450"]."\n";
?>
</body>
</html>