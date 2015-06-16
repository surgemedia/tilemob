<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>The Tile Mob</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" --><!-- TemplateEndEditable -->
<?
$server_dir_main = 'http://'.$_SERVER["SERVER_NAME"].substr($_SERVER["SCRIPT_NAME"], 0, strpos($_SERVER["SCRIPT_NAME"], "/", 2)+1); //Server main directory address
?>
<link href="<?=$server_dir_main?>styles.css" rel="stylesheet" type="text/css" />
<link href="<?=$server_dir_main?>nav_main.css" rel="stylesheet" type="text/css" />
<?php include('../../../includes/attach_scripts.php'); ?>
</head>

<body>
<table width="720" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th width="710" scope="row"><table width="800" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th height="60" colspan="2" align="left" valign="bottom" background="<?=$server_dir_main?>images/bkg_header.gif" bgcolor="#f0f0f0" scope="row"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <th align="left" height="35" scope="row"><!-- TemplateBeginEditable name="Gallery Heading" --><img src="<?=$server_dir_main?>images/hdg_terracotta.gif" alt="Terracotta"/><!-- TemplateEndEditable --></th>
				<td width="359" align="right" valign="middle">			  
					<?php 
						include($_SERVER["DOCUMENT_ROOT"]."/tm_catalogue/"."nav_main.inc");
					?>
				</td>
            </tr>
        </table>
          
          <table width="800" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <th scope="row"><img src="<?=$server_dir_main?>/images/img_help_top.gif" /></th>
            </tr>
          </table>          </th>
      </tr>
      <tr>
        <th width="420" height="10" align="left" scope="row">&nbsp;</th>
        <th width="380" scope="row">&nbsp;</th>
        </tr>
      <tr>
        <th align="left" valign="top" scope="row"><table width="380" border="0" align="right" cellpadding="0" cellspacing="0">
            <tr>
              <th align="left" valign="top" scope="row"><?php include("gallery.inc");?></th>
            </tr>
            <tr>
              <th align="right" valign="top" scope="row"><span class="the-tile-mob"><?php include("../pagelinks.inc");?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
            </tr>
          </table>
            <p></p></th>
        <th valign="top" scope="row"><table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <th height="300" scope="row"> <iframe onload="disableContextMenu();" src="iframe_display.php" name="iframe_display" width="300" height="310" scrolling="No" frameborder="0" id="iframe_display"></iframe></th>
            </tr>
            <tr>
              <th height="15" valign="top" scope="row"> </th>
            </tr>
            <tr>
              <th height="103" scope="row"> <iframe onload="disableContextMenu();" 
			src="iframe_display_info.php" name="iframe_display_info" width="300" height="103" scrolling="No" frameborder="0" id="iframe_display_info"></iframe></th>
            </tr>
        </table></th>
        </tr>
      
      <tr>
        <th height="37" colspan="2" align="left" valign="baseline" background="<?=$server_dir_main?>images/bkg_footer.gif" scope="row"><img src="<?=$server_dir_main?>/images/img_help_bottom.gif" alt="How to use the Catalogue system" /></th>
      </tr>
      <tr>
        <th height="140" colspan="2" align="left" valign="baseline" scope="row"><iframe onload="disableContextMenu();" src="<?=$server_dir_main?>iframe_collection.php" allowtransparency="true" name="iframe_collection" width="700" height="140" scrolling="Auto" frameborder="0" id="iframe_collection"></iframe></th>
      </tr>
      <tr>
        <th height="30" colspan="2" valign="middle" background="<?=$server_dir_main?>images/bkg_footer.gif" bgcolor="#f0f0f0" scope="row"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="90%" align="left" class="the-tile-mob" scope="row"><?PHP include($server_dir_main.'footer.inc');?></td>
            </tr>
        </table></th>
      </tr>
    </table>
    </th>
  </tr>
</table>
</body>
</html>
