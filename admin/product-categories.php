<?php
session_start();
include('includes/prerun.php');
include('includes/connection.php'); //Database connections
include('includes/checklogin.php'); //Check login 

if(!empty($_POST['delete_id'])) {	
	$delete_category_id = $_POST['delete_id'];
	mysql_query("UPDATE content SET is_deleted='1' WHERE ID='$delete_category_id'");
	header('location:pages.php?s2=Page was successfully deleted.');
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
function deleteContent(category_id) {
	if(prompt('Do you wish to delete this page?\nPlease type yes below:') == 'yes') {
		document.getElementById('delete_id').value = category_id;
		document.getElementById('deleteform').submit();
	} else {
		document.getElementById('delete_id').value = '';
	}
}

function expandCategory(category_id) {
	document.getElementById('products_'+category_id).style.display = '';
	document.getElementById('collapse_category_button_'+category_id).style.display = '';
	document.getElementById('expand_category_button_'+category_id).style.display = 'none';
}

function collapseCategory(category_id) {
	document.getElementById('products_'+category_id).style.display = 'none';
	document.getElementById('expand_category_button_'+category_id).style.display = '';
	document.getElementById('collapse_category_button_'+category_id).style.display = 'none';	
}
</script>
</head>
<body>
<?php include('includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('includes/header.php'); ?></div>
	<div id="navigation" class="navigation"><?php include('includes/navigation.php'); ?></div>
	<div id="middle" class="middle" style="width:800px;">
		<h1>Manage product categories</h1>
		<?php
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
						<th align="left">Category name</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$string = '';
				$result_category = mysql_query("SELECT * FROM category WHERE under_category_id='0' AND is_active='1' ORDER BY ordering ASC");
				$category_count = 1;
				//CATEGORIES
				while($row_category = mysql_fetch_array($result_category)) {
					$category_id = $row_category['category_id'];
					if($row_category['is_hidden']==1){$show_hidden = '<em style="color:#CCCCCC;">hidden</em>';}else{$show_hidden='';}
					$string .= '
					<tr>
						<td align="left">
							<div class="float_left">
								<a id="expand_category_button_'.$category_id.'" href="javascript:void(0);" title="Expand" onclick="expandCategory('.$category_id.');" style="display:block;">
								<img src="images/ico_expand.png" alt="+" border="0" align="absmiddle" style="margin-right:3px;" />
								<b>'.strip_tags($row_category['name']).'</b> '.$show_hidden.'</a>
								<a id="collapse_category_button_'.$category_id.'" href="javascript:void(0);" title="Expand" onclick="collapseCategory('.$category_id.');" style="display:none;">
								<img src="images/ico_expand.png" alt="+" border="0" align="absmiddle" style="margin-right:3px;" />
								<b>'.strip_tags($row_category['name']).'</b> '.$show_hidden.'</a>
							</div>
							<div class="float_right"><a href="edit-product-category.php?id='.$category_id.'" title="Edit this category">edit</a></div>
							<div class="clear"></div>';
					//PRODUCTS
					$product_count = 1;
					$result_product = mysql_query("SELECT * FROM product WHERE category_id='$category_id' AND is_active='1'");
					if(mysql_num_rows($result_product) > 0) {
						$string .= '<div id="products_'.$category_id.'" class="clear" style="display:none;">';
						while($row_product = mysql_fetch_array($result_product)) {
							$product_id = $row_product['product_id'];
							$string .= '
							<div class="contentrow1" style="margin-left:25px;">
								<div class="float_left"><a href="edit-product.php?id='.$product_id.'">'.$product_count.'. '.$row_product['name'].' ($'.number_format($row_product['price'],2).')</a></div>
								<div class="float_right"><a href="edit-product.php?id='.$product_id.'">edit</a></div>
								<div class="clear"></div>
							</div>
							';
							$product_count++;
						}
						$string .= '</div>';
					}
					/*$result_subcategory = mysql_query("SELECT * FROM category WHERE under_category_id = '$category_id' AND is_active = '1' ORDER BY ordering ASC");
					$subcategory_count = 1;
					if(mysql_num_rows($result_subcategory) > 0) {
						$string .= '<table width="100%" class="table2">';
						while($row_subcategory = mysql_fetch_array($result_subcategory)) {
							$subcategory_id = $row_subcategory['subcategory_id'];
							if($row_subcategory['is_hidden']==1){$show_hidden = '<em style="color:#CCCCCC;">hidden</em>';}else{$show_hidden='';}
							$string .= '
							<tr>
								<td width="20" align="left">&nbsp;</td>
								<td align="left"><a href="edit-product-category.php?id='.$subcategory_id.'" title="Edit this page">'.strip_tags($row_subcategory['name']).' '.$show_hidden.'</a></td>
								<td align="right"><a href="edit-product-category.php?id='.$subcategory_id.'" title="Edit this page">edit</a><!-- | <a href="#" onclick="deleteContent('.$subcategory_id.');">delete</a>--></td>
							</tr>';
							$subcontent_count++;
						}
						$string .= '</table>';
					}*/
					$string .= '</td></tr>';
					$category_count++;
				}
				echo $string;
				?>
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
<?php
if(!empty($_GET['show'])) {
	echo '<script>expandCategory('.$_GET['show'].');</script>';
}
include('includes/end_body.php');
?>
</body>
</html>