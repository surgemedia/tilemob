<?php 
session_start();
include('includes/prerun.php');
include('includes/connection.php');
include('includes/global_variables.php');
include('includes/requests.php');

$result_content = mysql_query("SELECT * FROM shop_content WHERE pageurl='$_pageurl' AND is_active='1'");
if($row_content = mysql_fetch_array($result_content)) {
	$content_id = $row_content['content_id'];
	$heading1 = $row_content['heading1'];
	$is_multicolumn = $row_content['is_multicolumn'];
	$indent_body2 = $row_content['indent_body2'];
	$body1 = str_replace("\'", "'", $row_content['body1']);
	$body1 = str_replace('\"', '"', $body1);
	$body2 = str_replace("\'", "'", $row_content['body2']);
	$body2 = str_replace('\"', '"', $body2);
	$metatitle = $row_content['metatitle'];
	$menulinkname = $row_content['menulinkname'];
	$pageurl = $row_content['pageurl'];
} else {
	header('location:index.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php 
include('includes/attach_styles.php'); //Cascading Style Sheets
include('includes/attach_scripts.php'); //Javascripts and scripts
?>
</head>

<body>
<?php include('includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('includes/header.php'); ?></div>
	<div id="body" class="body">
		<div id="body_left" class="body_left">
			<?php include('includes/finder.php'); ?>
			<?php include('includes/store-categories.php'); ?>
			<div class="clear"></div>
		</div>
		<div id="body_right" class="body_right">
			<div id="pagebody" class="pagebody">
				<?php 
				$string = '<h1>'.$heading1.'</h1>';
				if($is_multicolumn==1) {
					if($indent_body2==1){$require_indent_style='<div class="indent_body2"></div>';}else{$require_indent_style='';}
					$string .= '
					<div id="col1" class="col1">
						'.$body1.'
					</div>
					<div id="col2" class="col2">
						'.$require_indent_style.'
						'.$body2.'
					</div>';
				} else {
					$string .= $body1;
				}
				echo $string;
				?>
				<div class="clear"></div>
			</div>
			<div id="backtotop" class="backtotop"><?php include('includes/backtotop.php'); ?></div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div id="footer" class="footer"><?php include('includes/footer.php'); ?></div>
	<div class="clear"></div>
</div>
<?php include('includes/end_body.php'); ?>
</body>
</html>