<?php
session_start();
include('includes/prerun.php');
include('includes/connection.php'); //Database connections
include('includes/checklogin.php'); //Check login 
$orderNo        = $_REQUEST['id'];

if($_POST['submit'] && $_POST['submit'] == "Change Status")
{
    $orderStatus    = $_POST['orderstatus'];
    $paymentStatus  = $_POST['paymentstatus'];
    $shippingstatus = $_POST['shippingstatus'];
    $sqlUpdate      = "UPDATE order_details SET order_status = '$orderStatus',payment_status = '$paymentStatus',shipping_status = '$shippingstatus'  WHERE order_id = $orderNo";
    $result_update= mysql_query($sqlUpdate);
    if($result_update)
    {
        $msg = "Status Updated Successfully";
    }
}



$sql            = "SELECT od.*,bi.*  FROM order_details as od INNER JOIN billing_info as bi ON od.order_id = bi.order_id WHERE od.order_id = $orderNo " ;
$result_order   = mysql_query($sql);
$resOrder       = mysql_fetch_array($result_order);
//echo "<pre/>"; print_r($resOrder);
$sqlPurchase    = "SELECT * FROM shop_cart WHERE order_id ='$orderNo' AND qty>0 AND is_active='1'";
$result_purchase= mysql_query($sqlPurchase);


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
    <div id="header" class="header">
        <?php include('includes/header.php'); ?>
    </div>
    <div id="navigation" class="navigation">
        <?php include('includes/navigation.php'); ?>
    </div>
    <div id="middle" class="middle">
        <?php		
			echo '<h1>Orders List</h1><br/>';
		?>
        <?=$msg?>
        <br/>
        <div id="content" class="content">
            <form id="submitform" name="submitform" method="post">
                <table id="content-table" width="100%" class="table1">
                    <tr>
                        <td valign="top" width="50%"><fieldset>
                                <legend>Order Details</legend>
                                <table width="100%">
                                    <tr>
                                        <td>Order ID:</td>
                                        <td><?=$resOrder['order_id']?></td>
                                    </tr>
                                    <tr>
                                        <td>Order Date:</td>
                                        <td><?=$resOrder['order_date']?></td>
                                    </tr>
                                    <tr>
                                        <td>Order Status:</td>
                                        <td><?=$resOrder['order_status']?></td>
                                    </tr>
                                </table>
                            </fieldset></td>
                        <td width="50%"><fieldset>
                                <legend>Billing Info</legend>
                                <table width="100%">
                                    <tr>
                                        <td>Name:</td>
                                        <td><?=$resOrder['first_name'].'.'.$resOrder['last_name']?></td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td><?=$resOrder['email']?></td>
                                    </tr>
                                    <tr>
                                        <td>Phone:</td>
                                        <td><?=$resOrder['phone']?></td>
                                    </tr>
                                    <tr>
                                        <td>Address:</td>
                                        <td><?=$resOrder['address']?></td>
                                    </tr>
                                    <tr>
                                        <td>City:</td>
                                        <td><?=$resOrder['city']?></td>
                                    </tr>
                                    <tr>
                                        <td>State:</td>
                                        <td><?=$resOrder['state']?></td>
                                    </tr>
                                    <tr>
                                        <td>Zip:</td>
                                        <td><?=$resOrder['zip']?></td>
                                    </tr>
                                    <tr>
                                        <td>Country:</td>
                                        <td><?=$resOrder['country']?></td>
                                    </tr>
                                    <tr>
                                        <td>Shipping Option:</td>
                                        <td><?=$resOrder['shipping_option']?></td>
                                    </tr>
                                </table>
                            </fieldset></td>
                    </tr>
                    <tr>
                        <td colspan="2"><fieldset>
                                <legend>Products bought</legend>
                                <table width="100%">
                                    <tr>
                                        <td>ProductCode</td>
                                        <td>Qty</td>
                                        <td>Price</td>
                                    </tr>
                                    <?php
                                $total = 0;
                                while($row = mysql_fetch_array($result_purchase))
                                {
                                    $total  += $row['price'];
                                ?>
                                    <tr>
                                        <td><?=$row['item_code']?></td>
                                        <td><?=$row['qty']?></td>
                                        <td><?=$row['price']?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                    <tr>
                                        <td>Total :</td>
                                        <td><?=$total?></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                            </fieldset></td>
                    </tr>
                </table>
            </form>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div id="content" class="content">
            <form id="" name="" method="post">
                <table id="content-table" width="100%" class="table1">
                    <tr>
                        <td>Order Status</td>
                        <td><input type="hidden" name="id" id="id" value="<?=$orderNo?>">
                            </input>
                            <select name="orderstatus" id="orderstatus" class="txt-style">
                                <option value="active" <?=($resOrder['order_status'] == "active")?'selected':''?>>Active</option>
                                <option value="pending" <?=($resOrder['order_status'] == "pending")?'selected':''?>>Pending</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td>Payment Status</td>
                        <td><select name="paymentstatus" id="paymentstatus" class="txt-style">
                                <option value="active" <?=($resOrder['payment_status'] == "active")?'selected':''?>>Active</option>
                                <option value="pending" <?=($resOrder['payment_status'] == "pending")?'selected':''?>>Pending</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td>Shipping Status</td>
                        <td><select name="shippingstatus" id="shippingstatus" class="txt-style">
                                <option value="active" <?=($resOrder['shipping_status'] == "active")?'selected':''?>>Active</option>
                                <option value="pending" <?=($resOrder['shipping_status'] == "pending")?'selected':''?>>Pending</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td><input type="submit" class="btn btn-primary " id="submit" name="submit" value="Change Status">
                            </input></td>
                    </tr>
                </table>
            </form>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <div id="footer" class="footer">
        <?php include('includes/footer.php'); ?>
    </div>
</div>
<form id="deleteform" name="deleteform" method="post">
    <input type="hidden" id="delete_id" name="delete_id" value="">
</form>
<?php include('includes/end_body.php'); ?>
</body>
</html>
