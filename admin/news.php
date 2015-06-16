<?php
session_start();
include('includes/prerun.php');
include('includes/connection.php'); //Database connections
include('includes/checklogin.php'); //Check login 

if(!empty($_POST['delete_id'])) {	
	$delete_news_id = $_POST['delete_id'];
	if(mysql_query("UPDATE news SET is_active='0' WHERE news_id='$delete_news_id'")) {
		header('location:news.php?s2=News item was successfully deleted.');
	} else {
		header('location:news.php?s3=News item could not be deleted. Please try again.');
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
<script type="text/javascript">
function deleteNews(new_id) {
	if(prompt('Do you wish to delete this news item?\nPlease type yes below:') == 'yes') {
		document.getElementById('delete_id').value = new_id;
		document.getElementById('deleteform').submit();
	} else {
		document.getElementById('delete_id').value = '';
	}
}

function disableSelection(element) {
	element.onselectstart = function() {
		return false;
	};
	element.unselectable = "on";
	element.style.MozUserSelect = "none";
}
</script>
</head>
<body>
<?php include('includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('includes/header.php'); ?></div>
	<div id="navigation" class="navigation"><?php include('includes/navigation.php'); ?></div>
	<div id="middle" class="middle">
		<h1>News</h1>
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
			<div class="float_right">
				<input id="create1" name="create1" type="button" value="Create a news item &raquo;" onclick="location.href='edit-news.php';" class="button2" />
			</div>
			<div class="clear"></div>
			<hr/>
			<form id="submitform" name="submitform" method="post">
			<table id="content-table" width="100%" class="table1">
				<thead>
					<tr>
						<th width="150" align="left">Release</th>
						<th align="left">News</th>
						<th width="80" align="center">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$string = '';
				$result_news = mysql_query("SELECT * FROM news WHERE is_active='1' ORDER BY news_id DESC");
				$total_news = mysql_num_rows($result_news);
				$restrict_news_pp = 10; //Number of news items to show per page
				$news_count = 1;

				//Page numbering system
				$total_pages = ceil($total_news / $restrict_news_pp); //round up always
				if($_GET['page'] != '') {
				$current_page = trim($_GET['page']); } else { $current_page = 1; }
				$end_index = $restrict_news_pp*$current_page;
				$start_index = $end_index - $restrict_news_pp;
				
				if($total_news > 0) {
					while($row_news = mysql_fetch_array($result_news)) { //listing news
						if($news_count >= $start_index && $news_count <= $end_index) { //make sure we only show between restrictions
							$news_id = $row_news['news_id'];
							$news_category_id = $row_news['news_category_id'];
							$result_news_category = mysql_query("SELECT * FROM news_category WHERE news_category_id='$news_category_id' AND is_active='1'");
							if($row_news_category = mysql_fetch_array($result_news_category)) {
								$news_category_name = $row_news_category['name'];
							} else {
								$news_category_name = '';
							}
							$string .= '
							<tr>
								<td align="left"><a href="edit-news.php?id='.$news_id.'" title="edit">'.$row_news['releasedate'].'</a></td>
								<td align="left"><a href="edit-news.php?id='.$news_id.'" title="edit">'.$row_news['heading'].'</a></td>
								<td align="center"><a href="edit-news.php?id='.$news_id.'" title="edit">edit</a> | <a href="javascript:void(0);" title="delete" onclick="deleteNews('.$news_id.');">delete</a></td>
							</tr>';
						}
						$news_count++;
					}
				}
				echo $string;
				?>
				</tbody>
			</table>
			</form>
			<div class="clear" style="height:10px;"></div>
			<div class="float_right">
				<input id="create2" name="create2" type="button" value="Create a news item &raquo;" onclick="location.href='edit-news.php';" class="button2" />
			</div>
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