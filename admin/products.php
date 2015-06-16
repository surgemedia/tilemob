<?php
include('includes/prerun.php');
include('../../dbconnect.php'); //Database connections
include('includes/checklogin.php'); //Check login 

$table_body = '';
if(!empty($_GET['c'])) { //products
	$category_code = trim($_GET['c']);
	$result_use = mysql_query("SELECT * FROM shop_use WHERE Code='$category_code' AND is_active='1'");
	if($row_use = mysql_fetch_array($result_use)) {
		$category_id = $row_use['use_id'];
		$category_name = $row_use['Description'];
		$result_products = mysql_query("SELECT * FROM shop_webitems WHERE `Use`='$category_code' AND is_active='1'");
		$total_products = mysql_num_rows($result_products);
		if($total_products>0) {
			$product_count = 0;
			while($row_products = mysql_fetch_array($result_products)) {
				$product_id = $row_products['item_id'];
				$product_code = $row_products['Code'];
				$product_name = $row_products['Desc'];
				$product_count++;
				$table_body .= '
				<tr>
					<td align="left">
						<div class="float_left"><a href="product.php?id='.$product_id.'" title="Edit '.$product_code.'">'.$product_count.'. '.$product_code.' – '.$product_name.'</a></div>
						<div class="float_right"><a href="product.php?id='.$product_id.'" title="Edit '.$product_code.'">Edit</a></div>
					</td>
				</tr>
				';
			}
		} else {
			$table_body .= '<tr><td align="left"><div class="float_left">There are no products under '.$category_name.'.</div></td></tr>';	
		}
	} else {
		header('location:products.php');
	}
} else { //categories
	$result_use = mysql_query("SELECT * FROM shop_use WHERE is_active='1'");	
	$use_count = 0;
	if(mysql_num_rows($result_use)>0) {
		while($row_use = mysql_fetch_array($result_use)) {
			$use_id = $row_use['use_id'];
			$use_code = $row_use['Code'];
			$result_products = mysql_query("SELECT * FROM shop_webitems WHERE `Use`='$use_code' AND is_active='1'");
			$total_products = mysql_num_rows($result_products);
			$use_count++;
			$table_body .= '
			<tr>
				<td align="left">
					<div class="float_left"><a href="products.php?c='.urlencode($use_code).'" title="Edit this page">'.$use_count.'. <b>'.strip_tags($row_use['Description']).' ('.$total_products.')</b></a></div>
					<div class="float_right"><a href="products.php?c='.urlencode($use_code).'" title="Show products">Show products »</a></div>
				</td>
			</tr>';
		}		
	}
}

if(!empty($_POST['delete_id'])) {	
	$delete_content_id = $_POST['delete_id'];
	//mysql_query("UPDATE content SET is_deleted='1' WHERE ID='$delete_content_id'");
	//header('location:pages.php?s2=Page was successfully deleted.');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
include('includes/meta.php'); //Meta tags
include('includes/variables.php'); //Global variables
include('includes/security.php'); //Security features
include('includes/attach_styles.php'); //Cascading Style Sheets
include('includes/attach_scripts.php'); //Javascripts and scripts
include('includes/other.php'); //Other things missed out
?>
<script type="text/javascript">
function deleteContent(content_id) {
	if(prompt('Do you wish to delete this page?\nPlease type yes below:') == 'yes') {
		document.getElementById('delete_id').value = content_id;
		document.getElementById('deleteform').submit();
	} else {
		document.getElementById('delete_id').value = '';
	}
}
</script>
</head>
<body>
<?php include('includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('includes/header.php'); ?></div>
	<div id="navigation" class="navigation"><?php include('includes/navigation.php'); ?></div>
	<div id="middle" class="middle">		
		<?php
		if(!empty($category_name)) {
			echo '<h1>Products under '.$category_name.'</h1>';
		} else {
			echo '<h1>Select a category</h1>';
		}
		if(!empty($_GET['s1']) || !empty($_GET['s2']) || !empty($_GET['s3'])) {
			$string = '';
			if(!empty($_GET['s1'])){$s = 1;}else if(!empty($_GET['s2'])){$s = 2;}else if(!empty($_GET['s3'])){$s = 3;}
			$status = $_GET['s'.$s];
			//s1: notice | s2: success | s3: error 
			$string .= '<div class="status'.$s.'">'.$status.'</div>';
			$string .= '<div class="clear"></div>';
			echo $string;
		}
		?>
		<div id="content" class="content">
			<form id="submitform" name="submitform" method="post">
			<table id="content-table" width="100%" class="table1">
				<thead>
					<tr>
						<th align="left">Name</th>
					</tr>
				</thead>
				<tbody>
					<?php echo $table_body; ?>
				</tbody>
			</table>
			</form>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div id="footer" class="footer"><?php include('includes/footer.php'); ?></div>
</div>
<form id="deleteform" name="deleteform" method="post">
<input type="hidden" id="delete_id" name="delete_id" value="">
</form>
<?php include('includes/end_body.php'); ?>
</body>
</html>