<?
//Force no-cache
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
session_start();

include('../../../CdbSecurityFolders/dbconnection.php'); //Database connections
include('includes/checklogin.php'); //Check login 

if(!empty($_POST['title']) && !empty($_POST['body'])) { 
	$title = trim($_POST['title']);
	$url = trim($_POST['url']);
	$body = $_POST['body'];
	$body = str_replace('<p>','',$body);
	$body = str_replace('</p>','',$body);
	$body = str_replace('font-size: 14px;','font-size:14px;line-height:16px;>',$body);
	$body = str_replace('font-size: 16px;','font-size:16px;line-height:18px;>',$body);
	$body = str_replace('font-size: 18px;','font-size:18px;line-height:20px;>',$body);
	$body = str_replace('font-size: 20px;','font-size:20px;line-height:22px;>',$body);
	$body = str_replace('font-size: 22px;','font-size:22px;line-height:24px;>',$body);
	$body = str_replace('font-size: 24px;','font-size:24px;line-height:26px;>',$body);
	$body = str_replace('font-size: 26px;','font-size:26px;line-height:28px;>',$body);
	$body = str_replace('font-size: 28px;','font-size:28px;line-height:30px;>',$body);
	$body = trim($body);
	
	$lastupdated =  date('d/m/Y (h:i a)');
	
	mysql_query("UPDATE news SET 
				title = '$title',
				url = '$url',
				body = '$body',
				lastupdated = '$lastupdated'
				WHERE news_id = '1'") or die(mysql_error());	//Done.

	//All done
	header('location:manage_newsflash.php?s2='.$title.' was successfully updated.');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?
include('includes/meta.php'); //Meta tags
include('includes/variables.php'); //Global variables
include('includes/security.php'); //Security features
include('includes/attach_styles.php'); //Cascading Style Sheets
include('includes/attach_scripts.php'); //Javascripts and scripts
include('includes/other.php'); //Other things missed out

$result_news = mysql_query("SELECT * FROM news WHERE news_id = '1'");
if($row_news = mysql_fetch_array($result_news)) {
	$title = $row_news['title'];
	$url = $row_news['url'];
	$body = $row_news['body'];
}
?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script>
<?php
$cur_servdir = '/'.substr(dirname($_SERVER['PHP_SELF']), 1).'/';
?>
function loadHomeEditor() {
	var editor = CKEDITOR.replace('body',{
	height:"130",
	toolbar:'toolbar2',
	filebrowserBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php',
	filebrowserImageBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php',
	filebrowserFlashBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php'
	});
	CKEDITOR.config.contentsCss = 'ckeditor/css/editor.css' ;
	CKEDITOR.config.forcePasteAsPlainText = true;
	CKEDITOR.config.resize_enabled = false;
	CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
}
function checkFields() {
	//alert("checking fields");
	emptyfields = "";
	if (document.getElementById('title').value == "") {
		emptyfields += "\n   * Heading";
	}
	if (document.getElementById('body').value == "") {
		emptyfields += "\n   * Body";
	}
	
	//alert("checking fields");
	if (emptyfields!= "") { //mandatories not completed!
		emptyfields = "These fields cannot be empty:\n" +
		emptyfields + "\n\nPlease fill in all fields marked with *";
		alert(emptyfields);
		return false;
	} else { //all mandatories filled in!
		return true;
	}
}
</script>
</head>
<body>
<div class="container">
   <div class="header"></div>
   <div class="navigation">
      <? include('includes/navigation.php'); ?>
   </div>
	<? include('sub_menu2.php');?>
   <div class="middle">
      <h1>Edit/Delete Projects</h1>
                <table width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="20" bgcolor="#CCCCCC" align="center" valign="middle">Project name</td>
                    <td height="20" bgcolor="#CCCCCC" align="center" valign="middle" colspan="2">Action</td>
                  </tr>
      <?
				  		if($_POST['client_id']!=""){
							$query0 = "UPDATE file_projects SET enable_option = 0 WHERE id = ".$_POST['client_id'];
							mysql_query($query0);
						}
				  		$page_count=20; //the limit values to show in each time
						$query = "SELECT * FROM file_projects WHERE enable_option = 1 ORDER BY id";
						$result = mysql_query($query);
						$num_results = mysql_num_rows($result); 
							
						$page_total=intval($num_results/$page_count);
						if ($num_results % $page_count)  
						$page_total++;  
						if (isset($_POST['page'])){  
							$page=intval($_POST['page']);  
						}  
						else{  
							$page=1;  
						}  
						$move=$page_count * ($page - 1); 
					
						$sql_data_move=mysql_query($query ." limit $move,$page_count"); 
							
				
							if ($row = mysql_fetch_array($sql_data_move)) {  
								$counter=0;  
								do	{  
								$counter++;  
								//--------------------------Content
									echo '
									  <tr>
										<td>&nbsp; '.$row['id'].'. '.$row['name'].'</td>
										<td width="20">
										<form action="#" method="post">
											<input type="hidden" value="'.$row['id'].'" name="client_id">
											<input type="submit" value="DEL" class="control_btn  btn_color" style="text-align:center;">
										</form>
										</td>
										<td width="40">
											<form action="job_edit.php" method="post">
											<input type="hidden" value="'.$row['id'].'" name="client_id">
											<input type="submit" value="Edit" class="control_btn2  btn_color" style="text-align:center;">
											</form>
										</td>
									  </tr>
									';
								//----------------------------------------------  
						
								}  
							
							while ($row = mysql_fetch_array($sql_data_move));  
							
							} 
	  ?>
<tr>
                    <td colspan="6">
                    <form action="#" method="post">
					Page: <select name="page" onchange='this.form.submit()'>
                        <?
                            for($loop=1; $loop<=$page_total;$loop++){
                                echo '
                                    <option value="'.$loop.'" ';
                                    if($loop==$_POST['page']){echo 'selected';}
                                echo '>'.$page1.$loop.$page2.'</option>
                                ';
                            }
                        ?>
                    </select>                
                    </td>
                  </tr>
                  </table>
   </div>
   <div class="footer"></div>
</div>
<script>loadHomeEditor();</script>
</body>
</html>
