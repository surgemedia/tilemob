<html>
<head>
<title>Catalogue Browser</title>
<?
error_reporting(0);
$open = $_GET['open'];
if ($open == null) {
	$open = "gallery/tiles/wall/bathrooms/page1/index.php?page=1";
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="images/tilemob.ico" type="images/ico" />
<link rel="shortcut icon" href="images/tilemob.ico" />
<link href="styles.css" rel="stylesheet" type="text/css">
<script type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('images/Tiles-Home-Over.gif','images/Tiles-About-Us-Over.gif','images/Tiles-New-in-Store-Over.gif','images/Tiles-E3-Performance-Over.gif','images/Tiles-Conditions-of-Sale-Ov.gif','images/Tiles-Photo-Gallery-Over.gif','images/Tiles-Contact-Map-Over.gif')">
<!-- ImageReady Slices (Template-About-Alt.psd) -->
<table width="800" height="0" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
	<tr>
		<td>
			<a href="../index.php"><img src="images/The-tile-mob-brisbane.gif" alt="Welcome to the Tile Mob" width="227" height="169" border="0"></a></td>
		<td width="573" height="169" colspan="7"><img src="images/Tile-Mob-Gallery.jpg" width="573" height="169" alt=""></td>
	</tr>
	<tr>
		<td width="227" height="31">
			<img src="images/spacer.gif" width="227" height="31" alt=""></td>
		<td><a href="http://www.tilemob.com.au" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Home','','images/Tiles-Home-Over.gif',1)"><img src="images/Tiles-Home.gif" alt="Home" name="Home" width="48" height="31" border="0"></a></td>
		<td><a href="http://www.tilemob.com.au/About-us.html" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('About-us','','images/Tiles-About-Us-Over.gif',1)"><img src="images/Tiles-About-Us.gif" alt="About Us" name="About-us" width="62" height="31" border="0"></a></td>
		<td><a href="http://www.tilemob.com.au/new-in-store.html" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('New-in-Store','','images/Tiles-New-in-Store-Over.gif',1)"><img src="images/Tiles-New-in-Store.gif" alt="New in Store" name="New-in-Store" width="83" height="31" border="0"></a></td>
		<td><a href="http://www.tilemob.com.au/e3-performance-system.html" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('E3-Performance','','images/Tiles-E3-Performance-Over.gif',1)"><img src="images/Tiles-E3-Performance.gif" alt="E3 Performance" name="E3-Performance" width="92" height="31" border="0"></a></td>
		<td><a href="http://www.tilemob.com.au/tm_catalogue/" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Conditions-of-Sale','','images/Tiles-Conditions-of-Sale-Ov.gif',1)"><img src="images/Tiles-Conditions-of-Sale.gif" alt="Catalogue Browser" name="Conditions-of-Sale" width="105" height="31" border="0"></a></td>
		<td><a href="http://www.tilemob.com.au/photo-gallery.html" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Photo-Gallery','','images/Tiles-Photo-Gallery-Over.gif',1)"><img src="images/Tiles-Photo-Gallery.gif" alt="Photo Gallery" name="Photo-Gallery" width="82" height="31" border="0"></a></td>
		<td><a href="http://www.tilemob.com.au/contact-map.html" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Contact-Map','','images/Tiles-Contact-Map-Over.gif',1)"><img src="images/Tiles-Contact-Map.gif" alt="Contact and Map" name="Contact-Map" width="101" height="31" border="0"></a></td>
	</tr>
	<tr>
	  <td width="800" height="0" colspan="8" align="center"><table width="720" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th scope="row">&nbsp;</th>
        </tr>
        <tr>
          <th align="left" scope="row"><img src="images/hdg_tm_catalogue.gif" alt="the Tile Mob Catalogue" width="318" height="40"></th>
        </tr>

        <tr>
          <th scope="row">&nbsp;</th>
        </tr>
        <tr>
          <th scope="row">
		  <iframe
			  name="iframe_catalogue" width="800" height="712"
			  style="border:1px solid #dddddd" frameborder=0 scrolling=no
			  src="<?=$open?>">		  </iframe>		  </th>
        </tr>
        <tr>
          <th scope="row">&nbsp;</th>
        </tr>
      </table></td>
	</tr>
	<tr>
		<td colspan="6">
			<img src="images/Premium-wall-tiles.gif" width="617" height="11" alt=""></td>
		<td colspan="2" rowspan="3" valign="top"><img src="images/Tested-Tiles-4.gif" width="183" height="64"></td>
	</tr>
	<tr>
	  <td height="50" colspan="6"><span class="the-tile-mob"><a href="http://dmwcreative.com.au" target="_blank">Website design by dmwcreative</a> - content copyright The Tile Mob | <a href="../Conditions-of-Sale.html">Conditions of Sale</a> |  <a href="#">Building Resources</a> | <a href="#" onclick=
	"window.open('../general_enquiry_form.php','Enquire','status=yes,width=790,height=350')" value="Make Enquiry">Enquiry form</a> </span></td>
  </tr>
	<tr>

    <td width="155" height="0" colspan="4" valign="middle" class="the-tile-mob">&nbsp;</td>
	<td width="154" colspan="2" valign="middle" class="the-tile-mob">&nbsp;</td>
	</tr>
</table>
<!-- End ImageReady Slices -->
</body>
</html>