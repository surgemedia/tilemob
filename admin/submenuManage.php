<?php
ob_start();
include('includes/prerun.php');
include('../../dbconnect.php'); //Database connections
include('includes/checklogin.php'); //Check login 
 
//print_r($_POST['is_active']);
//$arr = $_POST['is_active'];
$query  = "SELECT * FROM shop_sub_heading ORDER BY recordListingID ASC";

if($_POST['submit']=="Update"){
	 $arr 	  = $_POST['is_active'];
         $status  = $_POST['bulkStatus'];
	 if($status == "Active")
	 {
	 	$status = 1;
	 }
	 if($status == "Inactive")
	 {
	 	$status = 0;
	 }
         if(count($arr)){
	 foreach($arr as $val){
  		 $sql = "UPDATE shop_sub_heading SET is_active = " . $status  . " WHERE heading_id = " . $val;
	     mysql_query($sql) or die('Error, insert query failed');
         }
         }
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
<script language="javascript">
function check_checkboxes()
{
  var c = document.getElementsByTagName('input');
  for (var i = 0; i < c.length; i++)
  {
    if (c[i].type == 'checkbox')
    {
       if (c[i].checked) {return true}
    }
  }
  return false;
}
function checkFields() {
    	emptyfields = "";
			
	if(document.getElementById('bulkStatus').value == '') {
		emptyfields += "\n   Select a status *";
	}
	if(!check_checkboxes())
        {
          emptyfields += "\n   Select a menu item *";
       
        }
       	//alert("checking fields");
	if (emptyfields!="") { //mandatories not completed!
		alertmessage = "You've forgotten these fields:\n";
		alert(alertmessage+emptyfields);
		return false;
	} else { //all mandatories filled in!
		return true;
	}
}
</script>
<script type="text/javascript" src="scripts/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery-ui-1.7.1.custom.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){ 
	$(function() {
		$("#contentLeft ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=updateRecordsListings'; 
			$.post("updateSubmenuSort.php", order, function(theResponse , status){
                           //$("#contentRight").html(theResponse);
                            $("#msg").show();
                            $("#msg").html("Sorting action completed successfully").fadeOut('10000');
                           
			}).fail(function(err, status) {
                         $("#msg").show();
                         $("#msg").html("something went wrong Please try again").fadeOut('10000');
                       }); 															 
		}								  
		});
	});
      

});	
</script>

<style>
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	margin-top: 10px;
}

ul {
	margin: 0;
}

#contentWrap {
	width: 700px;
	margin: 0 auto;
	height: auto;
	overflow: hidden;
}

#contentTop {
	width: 600px;
	padding: 10px;
	margin-left: 30px;
}

#contentLeft {
	float: left;
	width: 400px;
}

#contentLeft li {
	list-style: none;
	margin: 0 0 4px 0;
	padding: 10px;
	background-color:#3e3e4b;
	border: #CCCCCC solid 1px;
	color:#fff;
}


	

#contentRight {
	float: right;
	width: 260px;
	padding:10px;
	background-color:#336600;
	color:#FFFFFF;
}

</style>
</head>
<body>
<?php include('includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('includes/header.php'); ?></div>
	<div id="navigation" class="navigation"><?php include('includes/navigation.php'); ?></div>
	<div id="middle" class="middle">		
		
		<div id="content" class="content">
			<table id="content-table" width="100%" class="table1">
				<thead>
					<tr>
						<th align="left" colspan="2"> Manage Sub Menu</th>
                                        </tr>
				</thead>
				<tbody>
                                        <tr>
                                            <td>
					<div id="contentWrap">

		<div id="contentTop">
		  
	  </div>
	
		<div id="contentLeft">
                    <div id="msg"></div>
			<form action="" method="post" onsubmit="return checkFields();">
			<ul>
				<?php
				$result = mysql_query($query);
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
				?>
					<li id="recordsArray_<?php echo $row['heading_id']; ?>" style="cursor:move"><input type="checkbox" name="is_active[]" id="is_active" value="<?php echo $row['heading_id']; ?>">&nbsp;&nbsp;&nbsp;<img src="images/active_<?=$row['is_active']?>.png">&nbsp;&nbsp;&nbsp;<?php echo $row['Description']; ?></li>
				<?php } ?>
                                        <select class="select-box width-auto" id="bulkStatus" name="bulkStatus">
					<option value="" selected="selected">Select an option</option>
					<option value="Active">Activate</option>
					<option value="Inactive">Inactivate</option>
				        </select>
				        <input type="submit" name="submit" id="submit" value="Update" />
				<!--<input type="submit" name="submit" value="Save" />-->
			</ul>
			</form>
		</div>
		
	
	</div></td>
                                            </tr>
				</tbody>
			</table>
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