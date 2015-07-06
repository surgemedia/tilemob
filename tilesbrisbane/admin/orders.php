<?php
session_start();
include('includes/prerun.php');
include('includes/connection.php'); //Database connections
include('includes/checklogin.php'); //Check login 
$orderNo       = trim($_POST['orderNo']);
$customerName  = trim($_POST['customerName']);
$orderstatus   = $_POST['orderstatus'];
///////////////////////////////////////////////////
$sql           = '';
$sql          .= "SELECT od.*,bi.*  FROM order_details as od INNER JOIN billing_info as bi ON od.order_id = bi.order_id ";

if($orderNo)
{
     $sql          .= "WHERE od.order_id = $orderNo " ;
}
if($orderNo && $customerName)
{
     $sql .= "AND ";
}
if(!$orderNo && $customerName)
{
     $sql .= "WHERE ";
}
if($customerName)
{
    $sql          .= " CONCAT( bi.first_name,  ' ', bi.last_name ) LIKE  '%$customerName%' "; 
}
if($orderstatus && $customerName && $orderNo)
{
     $sql .= "AND ";
}
if(!$orderNo && !$customerName && $orderstatus)
{
     $sql .= "WHERE ";
}
if($orderstatus)
{
     $sql .= "od.order_status= '$orderstatus'";
}
$sql.= "GROUP BY od.order_id";
//echo $sql;
$result_use   = mysql_query($sql);
$total_results = 0;
if($result_use){
$total_results = mysql_num_rows($result_use);
}
$pagenumbers = '';
$results_per_page = 10;				
$total_pages = ceil($total_results/$results_per_page);
if(!empty($_GET['p'])){$page=trim($_GET['p']);}else{$page=1;}
$end_row = $page*$results_per_page;
$start_row = ($end_row-$results_per_page);
if($total_pages>1) {
$pagenumbers .= '<div class="pagenumbers clearfix">';
if($page>1){$pagenumbers.='<div class="prev"><a href="orders.php?'.$_parse_url['query'].'&p='.($page-1).'" title="Prev">Prev</a></div>';}
for($i=1;$i<=$total_pages;$i++) {
if($i==$page){$page_class='page_selected';}else{$page_class='page';}
$pagenumbers .= '<div class="'.$page_class.'"><a href="orders.php?'.$_parse_url['query'].'&p='.$i.'" title="'.$i.'">'.$i.'</a></div>';						
}
if($page<$total_pages){$pagenumbers.='<div class="next"><a href="orders.php?'.$_parse_url['query'].'&p='.($page+1).'" title="Next">Next</a></div>';}
$pagenumbers .= '<div class="clear"></div></div>';
}


//////////////////////////////////////////////////
$sql           = '';
$sql          .= "SELECT od.*,bi.*  FROM order_details as od INNER JOIN billing_info as bi ON od.order_id = bi.order_id ";

if($orderNo)
{
     $sql          .= "WHERE od.order_id = $orderNo " ;
}
if($orderNo && $customerName)
{
     $sql .= "AND ";
}
if(!$orderNo && $customerName)
{
     $sql .= "WHERE ";
}
if($customerName)
{
     $sql          .= " CONCAT( bi.first_name,  ' ', bi.last_name ) LIKE  '%$customerName%' "; 
}
if(($orderstatus && $customerName && $orderNo) || ($orderNo && $orderstatus))
{
     $sql .= "AND ";
}
if(!$orderNo && !$customerName && $orderstatus)
{
     $sql .= "WHERE ";
}
if($orderstatus)
{
     $sql .= "od.order_status= '$orderstatus'";
}
$sql.= "GROUP BY od.order_id ";
if(!$orderNo && !$customerName && !$orderstatus){
     $sql .= "LIMIT $start_row,$results_per_page";
}
//echo $sql;
$result_use   = mysql_query($sql);




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
			echo '<h1>Orders List</h1>';
		?>
            <div id="content" class="content">
			<form id="submitform" name="submitform" method="post">
			<table id="content-table" width="100%" class="table1">
				
                                    
                                        
                                    Search Order
					<tr>
						<td align="left">Order No</td>
                                                <td><input class="txt-style" type="text" id="orderNo" name="orderNo" value="<?=$orderNo?>"></input></td>
                                                <td align="left">Customer Name</td>
                                                <td><input class="txt-style" type="text" id="customerName" name="customerName" value="<?=$customerName?>"></input></td>
                                                <td align="left">Order Status</td>
                                                <td>
                                                    <select name="orderstatus" id="orderstatus" class="txt-style">
                                                        <option value="">Select</option>
                                                        <option value="">All</option>
                                                        <option value="active" <?=($orderstatus=="active")?'selected':''?>>Active</option>
                                                        <option value="pending" <?=($orderstatus=="pending")?'selected':''?>>Pending</option>
                                                    </select>
                                                </td>
                                                <td><input type="submit" name="submit" class="btn" value="Search"></input></td>
                                       </tr>
				
				
				
			</table>
			</form>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		<div id="content" class="content">
			<form id="" name="" method="post">
			<table id="content-table" width="100%" class="table1">
				<thead>
					<tr>
						<th align="left">Order No</th>
                                                <th align="left">Customer Name</th>
                                                <th align="left">Email</th>
                                                <th align="left">Order Status</th>
                                                <th align="left">Payment Status</th>
                                                <th align="left">Shipping Status</th>
                                       </tr>
				</thead>
				<tbody>
                                    <?php
                                    if($result_use){
					while($row = mysql_fetch_array($result_use))
                                        {
                                    ?>
                                        <tr>
                                        <td><a href="orderDetails.php?id=<?=$row['order_id']?>" style="text-decoration:underline"><?=$row['order_id']?></a></td>
                                        <td><?=$row['first_name']." ".$row['last_name']?></td>
                                        <td><?=$row['email']?></td>
                                        <td><?=$row['order_status']?></td>
                                        <td><?=$row['payment_status']?></td>
                                        <td><?=$row['shipping_status']?></td>
                                        </tr>
                                    <?php 
                                        }
                                    }
                                    ?>
				</tbody>
			</table>
                            <?=$pagenumbers?>
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
