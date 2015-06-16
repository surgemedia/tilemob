<?php $is_homepage = true; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<? include('includes/metatags.inc'); ?>
<link rel="shortcut icon" href="images/tilemob.ico" type="images/ico" />
<link href="styles.css" rel="stylesheet" type="text/css">
<link href="styles2.css" rel="stylesheet" type="text/css">
<link href="nav_main_home.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<script>
function initChristmasClosure() {
	document.getElementById("christmas_hoverpop").style.display = "block";
}

function close_christmas_hoverpop() {
	document.getElementById("christmas_hoverpop").style.display = "none";
	//Never display again (plant cookie)
	createCookie('neverdisplayagain','true',365);
}

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}
function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
function eraseCookie(name) {
	createCookie(name,"",-1);
}
</script>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('images/Home-over.gif','images/About-us-over.gif','images/New-in-store-over.gif','images/E3-Performance-over.gif','images/Conditions-of-sale-over.gif','images/Photo-gallery-over.gif','images/Contact-map-over.gif','images/btn_showroomclick_on.gif');">
<!-- ImageReady Slices (Template-6.psd) -->
<table width="800" height="659" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
  <tr>
    <td width="1%" colspan="9"><div align="center"><img src="images/The-Tile-Mob.gif" alt="Tiles Brisbane" width="313" height="131" border="0"><br />
        <table width="700" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center"><?php include("nav_main_home.inc");?></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td width="1%" height="401" colspan="4" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="spacer"><h1 style="font:16px Arial, Helvetica, sans-serif;color:#BBBBBB;margin:0;font-weight:bold;">Tiles Brisbane</h1>
            <h2 style="font:14px Arial, Helvetica, sans-serif;color:#BBBBBB;margin:0;margin-top:5px;font-weight:normal;">&nbsp;&nbsp;&nbsp;<img src="images/bullet-arrow.gif" alt="Visit the Tile Mob" border="0" align="absmiddle"/> <a href="http://www.tilemob.com.au/contact-map/" style="color:#EE3B33;">Visit the Tile Mob</a></h2></td>
        </tr>
        <tr>
          <td class="the-tile-mob"><br>
            <p>For quality <strong><a href="http://www.tilemob.com.au/tm_catalogue/index.php?open=gallery/tiles/floors/commercial/page1/index.php?page=1">tiles</a><a href="http://www.tilemob.com.au"> Brisbane</a></strong> look no further. The <strong><a href="http://www.tilemob.com.au">Tile Mob</a></strong> source the best <strong><a href="http://www.tilemob.com.au/tm_catalogue/index.php?open=gallery/stone/page1/index.php?page=1">stone</a>, <a href="http://www.tilemob.com.au/tm_catalogue/index.php?open=gallery/mosaics/page1/index.php?page=1">mosaics</a>, <a href="http://www.tilemob.com.au/tm_catalogue/index.php?open=gallery/slate/page1/index.php?page=1">slate</a>, <a href="http://www.tilemob.com.au/tm_catalogue/index.php?open=gallery/terracotta/page1/index.php?page=1">terracotta</a></strong> and <strong><a href="http://www.tilemob.com.au/tm_catalogue/index.php?open=gallery/terracotta/page1/index.php?page=1">ceramic</a></strong> tiles from manufacturers around the world to offer you Brisbane&rsquo;s widest selection of premium <strong><a href="http://www.tilemob.com.au/tm_catalogue/index.php?open=gallery/tiles/floors/commercial/page1/index.php?page=1">floor</a></strong> and <strong><a href="http://www.tilemob.com.au/tm_catalogue/index.php?open=gallery/tiles/wall/bathrooms/page1/index.php?page=1">wall</a></strong> tiles. </p>
            <p>Backed by our proven <a href="http://www.tilemob.com.au/e3-performance-system/"><strong>E3 performance system</strong></a>, our experienced team of tile stylists are ready to work with you to create compelling living or commercial spaces in Brisbane and surrounding areas.</p>
            <p> If you&rsquo;re after a guaranteed quality outcome for your next tile project, visit the team at The Tile Mob Brisbane today. </p>
            <!--<div style="text-align:right;margin-bottom:5px;width:100%;border-bottom:1px solid #DDDDDD;padding-bottom:5px;clear:both;"><img src="http://www.tilemob.com.au/images/img_creditcards.jpg" border="0" alt="We accept Visa, Mastercard and American Express" /></div>--></td>
        </tr>
        <tr>
          <td height="30" valign="middle"><span class="the-tile-mob2"><img src="images/bullet-arrow.gif" alt="Bullet Arrow" width="12" height="12" align="absmiddle">Check out the new <a href="http://www.tilemob.com.au/tm_catalogue/"><strong>Tile Catalogue Browser </strong></a></span></td>
        </tr>
        <tr>
          <td align="center"><a href="http://www.tilemob.com.au/booking_form.php" target="_blank" onmouseover="MM_swapImage('Visit our Showroom','','images/btn_showroomclick_on.gif',1)" onmouseout="MM_swapImgRestore()"><img src="images/btn_showroomclick_off.gif" alt="Tiles Brisbane showroom" name="Visit our Showroom" width="160" height="60" vspace="10" border="0" id="Visit our Showroom" /></a></td>
        </tr>
		<tr>
             <td height="30" align="center" class="the-tile-mob2"><img src="images/bullet-arrow.gif" alt="Bullet Arrow" width="12" height="12" align="absmiddle">&nbsp;<span style="font-size:16px;font-weight:bold;">Tel (07) 3355 5055</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table></td>
    <td colspan="2" valign="top"><img src="images/Premium-Floor-Tiles.jpg" width="118" height="401" alt="Premium Floor Tiles"></td>
    <td colspan="3" valign="top"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="368" height="401" title="The Tile Mob" style="z-index:800;">
        <param name="movie" value="flash/thetilemob.swf">
        <param NAME="wmode" VALUE="transparent">
        <param name="quality" value="high">
        <embed src="flash/thetilemob.swf" quality="high" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="368" height="401"></embed>
      </object></td>
  </tr>
  <tr>
    <td height="10" colspan="9" valign="bottom"><img src="images/greyline.gif" width="800" height="1" alt="Tile-Mob"></td>
  </tr>
  <tr>
    <td height="40" colspan="9" align="center"><table width="800" height="30" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><img src="images/bullet-arrow.gif" alt="Visit the Tile Mob" border="0" align="absmiddle"/>&nbsp;<span class="home_navlist"><a href="http://www.tilemob.com.au/index.php">Home</a></span></td>
          <td><img src="images/bullet-arrow.gif" alt="Visit the Tile Mob" border="0" align="absmiddle"/>&nbsp;<span class="home_navlist"><a href="http://www.tilemob.com.au/About-us/">About Us </a></span></td>
          <td><img src="images/bullet-arrow.gif" alt="Visit the Tile Mob" border="0" align="absmiddle"/>&nbsp;<span class="home_navlist"><a href="http://www.tilemob.com.au/new-in-store/">New in Store </a></span></td>
          <td><img src="images/bullet-arrow.gif" alt="Visit the Tile Mob" border="0" align="absmiddle"/>&nbsp;<span class="home_navlist"><a href="http://www.tilemob.com.au/e3-performance-system/">E3 Performance </a></span></td>
          <td><img src="images/bullet-arrow.gif" alt="Visit the Tile Mob" border="0" align="absmiddle"/>&nbsp;<span class="home_navlist"><a href="http://www.tilemob.com.au/conditions/">Conditions of Sale </a></span></td>
          <td><img src="images/bullet-arrow.gif" alt="Visit the Tile Mob" border="0" align="absmiddle"/>&nbsp;<span class="home_navlist"><a href="http://www.tilemob.com.au/photo-gallery/">Photo Gallery </a></span></td>
          <td><img src="images/bullet-arrow.gif" alt="Visit the Tile Mob" border="0" align="absmiddle"/>&nbsp;<span class="home_navlist"><a href="http://www.tilemob.com.au/contact-map/">Contact/Map</a></span></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="9"><img src="images/greyline.gif" width="800" height="1" alt="Tile-Mob" /></td>
  </tr>
  <tr>
          <td height="50" colspan="8" align="left" valign="middle"><? include('includes/footer.php'); ?></td>
          <td align="center" valign="middle"><span class="the-tile-mob" style="padding-left:0;"><img src="http://www.tilemob.com.au/images/img_creditcards.jpg" alt="We accept Visa, Mastercard and American Express" border="0" align="absmiddle" /></span></td>
  </tr>
  <tr>
          <td colspan="9" align="left" valign="top"><div style="width:100%;height:1px;border-top:1px solid #CCCCCC;"></div></td>
        </tr> 
  <tr>
    <td height="15" colspan="9" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td height="15" colspan="9"><span class="the-tile-mob" style="padding-left:0;">The <strong><a href="http://www.tilemob.com.au">Tile Mob Pty Ltd</a></strong> is a leading importer, wholesaler &amp; retail distributor of exclusive, <strong><a href="http://www.tilemob.com.au/tm_catalogue/index.php?open=gallery/stone/page1/index.php?page=1">stone</a></strong>, <strong><a href="http://www.tilemob.com.au/tm_catalogue/index.php?open=gallery/mosaics/page1/index.php?page=1">mosaics</a></strong>, <strong><a href="http://www.tilemob.com.au/tm_catalogue/index.php?open=gallery/slate/page1/index.php?page=1">slate</a></strong> &amp; <strong><a href="http://www.tilemob.com.au/tm_catalogue/index.php?open=gallery/terracotta/page1/index.php?page=1">terracotta tiles</a></strong> for domestic, commercial and premium residential projects.
      </p>
      <p>Our tile display centre &amp; showroom is located in the inner <strong><a href="http://www.tilemob.com.au">Brisbane</a></strong> suburb of Mitchelton. The Tile Mob specialises in assisting home owners, developers, project builders, architects, designers, interior decorators &amp; landscapers to select &amp; specify quality tiles &amp; pavers for their individual requirements.</p>
      <p>With a focus on professional advice and with your specific project &amp; budget in mind, The Tile Mob will present the perfect tile for your application.  Our range includes: <strong><a href="http://www.tilemob.com.au/tm_catalogue/gallery/tiles/wall/kitchen/page1/index.php?page=1">ceramic wall tiles</a></strong>, <strong><a href="http://www.tilemob.com.au/tm_catalogue/gallery/tiles/floors/internal/page1/index.php?page=1">ceramic floor tiles</a></strong>, <strong><a href="http://www.tilemob.com.au/tm_catalogue/gallery/stone/page1/index.php?page=1">porcelain tiles</a></strong>, <strong><a href="http://www.tilemob.com.au/tm_catalogue/gallery/tiles/floors/internal/page1/index.php?page=1">marble tiles</a></strong>, <strong><a href="http://www.tilemob.com.au/tm_catalogue/gallery/tiles/floors/external/page1/index.php?page=1">limestone tiles</a></strong>, <strong><a href="http://www.tilemob.com.au/tm_catalogue/gallery/slate/page1/index.php?page=1">granite tiles</a></strong>,<strong> <a href="http://www.tilemob.com.au/tm_catalogue/gallery/slate/page1/index.php?page=1">sandstone tiles</a></strong>, <strong><a href="http://www.tilemob.com.au/tm_catalogue/gallery/stone/page1/index.php?page=1">Himalayan Sandstone</a></strong>, <strong><a href="http://www.tilemob.com.au/tm_catalogue/gallery/slate/page1/index.php?page=1">slate tiles</a></strong>, <strong><a href="http://www.tilemob.com.au/tm_catalogue/gallery/terracotta/page1/index.php?page=1">terracotta tiles</a></strong>. </p>
      <p>Additionally, we also specialise in polished porcelain tiles, rectified tiles, large-format floor tiles, vitrified tiles, slip-resistant floor tiles, rockface tiles, commercial tiles, natural stone tiles.  Also on display in our showroom are: natural stone pavers, glass mosaics, Bisazza glass mosaics,  mosaic tiles, pool tiles &amp; pool copers and bullnose tiles.</p>
      <p>Our showroom is divided into sections displaying: <strong><a href="http://www.tilemob.com.au/tm_catalogue/index.php?open=gallery/tiles/wall/kitchen/page1/index.php?page=1">kitchen tiles</a></strong>, <strong><a href="http://www.tilemob.com.au/tm_catalogue/index.php?open=gallery/tiles/wall/bathrooms/page1/index.php?page=1">bathroom tiles</a></strong>, <strong><a href="http://www.tilemob.com.au/tm_catalogue/index.php?open=gallery/tiles/wall/commercial/page1/index.php?page=1">ensuite tiles</a></strong>, <strong> <a href="http://www.tilemob.com.au/tm_catalogue/index.php?open=gallery/tiles/wall/commercial/page1/index.php?page=1">laundry tiles</a></strong>, main floor area tiles, entry tiles, living area tiles, external tiles, balcony tiles, pool tiles, natural stone tiles, commercial tiles &amp; general wall tiles &amp; floor tiles.  Our outdoor tiles are suitable for use around swimming pools, pathways, driveways &amp; feature walls.</p>
      <p>Our commercial tile division supplies tiles to restaurants, retail shop fitouts, resort developments, unit developments, apartment developments, residential developments, shopping centres and exclusive designer homes.</p>
      <p>Through our distribution warehouse in <strong><a href="http://www.tilemob.com.au">Brisbane</a></strong>, we supply, stone, mosaics, slate &amp; terracotta tiles to <strong><a href="http://www.tilemob.com.au">Brisbane (Northside &amp; Southside)</a></strong>, <strong><a href="http://www.tilemob.com.au">North Queensland</a></strong>, <strong><a href="http://www.tilemob.com.au">South-East Queensland</a></strong>, <strong><a href="http://www.tilemob.com.au">Central Queensland</a></strong>, <strong><a href="http://www.tilemob.com.au">Gold Coast</a></strong>, <strong><a href="http://www.tilemob.com.au">Sunshine Coast</a></strong>, <strong><a href="http://www.tilemob.com.au">Northern New South Wales</a></strong> and <strong><a href="http://www.tilemob.com.au">Northern Rivers areas</a></strong>.  We are also able to arrange transport or delivery <strong><a href="http://www.tilemob.com.au">Australia</a></strong> wide if required.      </span></td>
  </tr>
  <tr>
    <td colspan="9"><div style="width:100%;height:1px;border-top:1px solid #DDDDDD;margin-top:10px;margin-bottom:15px;"></div></td>
  </tr>
  <tr>
    <td height="15" colspan="9"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="top"><span class="the-tile-mob" style="padding-left:0;"><strong>Quick Links</strong></span></td>
          <td align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td width="50%" align="left" valign="top" class="resourcelinks"><p><span class="the-tile-mob" style="padding-left:0;"><a href="http://www.tilesbrisbane.com.au" target="_blank">Tiles Brisbane</a></span></p>
            <p><span class="the-tile-mob" style="padding-left:0;"><a href="http://www.ceramictilesbrisbane.com.au" target="_blank">Ceramic Tiles Brisbane</a></span></p>
            <p><span class="the-tile-mob" style="padding-left:0;"><a href="http://www.walltilesbrisbane.com.au" target="_blank">Wall Tiles Brisbane</a></span></p>
            <p><span class="the-tile-mob" style="padding-left:0;"><a href="http://www.kitchentilesbrisbane.com.au" target="_blank">Kitchen Tiles Brisbane</a></span></p>
            <p><span class="the-tile-mob" style="padding-left:0;">Tile Talk Blog <a href="http://tilemob.blogspot.com/" target="_blank">http://tilemob.blogspot.com/</a></span></p>
            <span class="the-tile-mob" style="padding:0;">
            <p>Link Centre - <a href="http://linkcentre.com/home-and-garden/home-improvement" target="_blank">Directory and Search Engine</a></p>
            <p>Real Estate Australia - <br />
              <a href="http://directory.yourestate.com.au/index_386_ALL.php" target="_blank">Free property listings for real estate agents and property owners.</a></p>
            <p>Ldmstudio Directory &ndash;<a href="http://www.directory.ldmstudio.com" target="_blank"> International Directory</a></p>
            <p>Bahiacar.com &ndash; <a href="http://www.bahiacar.com/Home/Home_Improvement" target="_blank">Home improvement resources</a><br />
            </p>
            </span></td>
          <td width="50%" align="left" valign="top" class="resourcelinks"><p><span class="the-tile-mob" style="padding-left:0;"><a href="http://www.bathroomtilesbrisbane.com.au/" target="_blank">Bathroom Tiles Brisbane</a></span></p>
            <p><span class="the-tile-mob" style="padding-left:0;"><a href="http://www.floortilesbrisbane.com.au/" target="_blank">Floor Tiles Brisbane </a></span></p>
            <p><span class="the-tile-mob" style="padding-left:0;"><a href="http://www.twitter.com/TILEMOB" target="_blank">The Tile Mob on Twitter <img src="http://www.tilemob.com.au/images/twitter_logo.jpg" alt="The Tilemob on Twitter" border="0" align="absmiddle" /></a></span></p>
            <p><span class="the-tile-mob" style="padding-left:0;">A Web Directory &ndash;<a href="http://www.awebdirectory.info" target="_blank"> International Home Improvement Resources</a> </span></p>
            <span class="the-tile-mob" style="padding:0;">
            <p>AskBEE Free Directory &ndash;<a href="http://directory.kasan.us/" target="_blank"> International Web Directory</a></p>
            <p>Kasan Web Directory &ndash; <a href="http://directory.kasan.us/" target="_blank">Handy Resources</a></p>
            <p><a href="http://maps.google.com.au/maps?ie=UTF-8&amp;oe=utf-8&amp;rls=org.mozilla:en-US:official&amp;client=firefox-a&amp;um=1&amp;q=Tiles&amp;near=Brisbane+QLD&amp;fb=1&amp;view=text&amp;latlng=-27412987,152973801,14048825458836791553&amp;sa=X&amp;oi=local_result&amp;resnum=2&amp;ct=result" target="_blank">Local Brisbane Google results listing</a></p>
            <p><a href="http://www.hia.com.au" target="_blank"><img src="images/img_hiamembers.gif" alt="HIA Members" width="200" height="50" border="0" /></a><br />
            </p>
            </span></td>
        </tr>
        <tr>
          <td height="40" colspan="2" align="left" valign="top">&nbsp;</td>
        </tr>               
      </table></td>
  </tr>
  <tr>
    <td><img src="images/spacer.gif" width="81" height="1" alt=""></td>
    <td><img src="images/spacer.gif" width="95" height="1" alt=""></td>
    <td><img src="images/spacer.gif" width="121" height="1" alt=""></td>
    <td width="1%"><img src="images/spacer.gif" width="17" height="1" alt=""></td>
    <td width="2%"><img src="images/spacer.gif" width="112" height="1" alt=""></td>
    <td width="3%"><img src="images/spacer.gif" width="6" height="1" alt=""></td>
    <td width="6%"><img src="images/spacer.gif" width="137" height="1" alt=""></td>
    <td width="12%"><img src="images/spacer.gif" width="115" height="1" alt=""></td>
    <td><img src="images/spacer.gif" width="116" height="1" alt=""></td>
  </tr>
</table>
<!-- End ImageReady Slices -->
<div class="christmas_closure" id="christmas_hoverpop" style="display:none;"> <img src="images/christmas_closure_10.png" alt="Christmas Closure" name="non_ie6_image" border="0" usemap="#Map" id="non_ie6_image"/>
<!--[if IE 6]>
<div style="padding-top:8px;padding-left:8px;background:#FFFFFF;">
<img src="images/blank.gif" style="width: 350px; height: 210px; filter:
progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/christmas_closure_10.png', sizingMethod='scale')" usemap="#Map" border="0"/>
</div>
<script>
document.getElementById("non_ie6_image").style.display = "none";
</script>
<![endif]-->
  <map name="Map" id="Map">
    <area shape="rect" coords="89,225,266,245" href="#" alt="Thanks, close this notice" onclick="close_christmas_hoverpop();" />
    <area shape="rect" coords="85,160,260,185" href="#" alt="Thanks, close this notice" onclick="close_christmas_hoverpop();"/>
  </map>
</div>

<? include('includes/end_body.inc'); ?>
<?php
$exp_date = "2011-01-04"; 
$todays_date = date("Y-m-d"); 
$today = strtotime($todays_date); 
$expiration_date = strtotime($exp_date); 
if ($expiration_date > $today) { 
	echo '<script>initChristmasClosure();</script>';
}
?>
</body>
</html>
