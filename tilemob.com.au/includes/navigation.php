<ul id="suckerfishnav" class="sf-menu">
<?php
$nav_count = 1;
$navigation_string = '';
$result_navigation = mysql_query("SELECT * FROM content WHERE under_content_id = '0' AND is_custompage != '1' AND is_hidden != '1' AND is_deleted != '1' ORDER BY ordering ASC");
while($row_navigation = mysql_fetch_array($result_navigation)) {
	$content_id = $row_navigation['ID'];	
	if($row_navigation['pageurl']==$current_page_url){$li_style=' style="background:#636363;border-right:1px solid #636363;"';}else{$li_style='';}
	if($current_page_url=='index.php'){$nav_go_upper_dir='';}else{$nav_go_upper_dir='../';}
	$navigation_string .= '<li'.$li_style.'><a href="'.$nav_go_upper_dir.$row_navigation['pageurl'].'">'.$row_navigation['menulinkname'].'</a>';
	//submenus
	$result_submenus = mysql_query("SELECT * FROM content WHERE under_content_id = '$content_id' AND is_hidden != '1' AND is_deleted != '1' ORDER BY ordering ASC");
	if(mysql_num_rows($result_submenus) > 0) {	
		if($current_page_url=='index.php'){$nav_go_upper_dir='';}else{$nav_go_upper_dir='../';}
		$navigation_string .= '<ul style="border-top:1px solid #FFFFFF;">';
		$navigation_string .= '<li><a href="'.$nav_go_upper_dir.$row_navigation['pageurl'].'" title="'.$row_navigation['menulinkname'].'">'.$row_navigation['menulinkname'].'</a></li>';
		while($row_submenus = mysql_fetch_array($result_submenus)) {
			$navigation_string .= '<li><a href="'.$row_submenus['pageurl'].'" title="'.$row_submenus['menulinkname'].'">'.$row_submenus['menulinkname'].'</a></li>';
		}
		$navigation_string .= '</ul>';
	}
	$navigation_string .= '</li>';
	$nav_count++;
}
//$navigation_string .= '<li style="border-left:1px solid #3D3CB1;border-right:0;">&nbsp;</li>';
echo $navigation_string;
?>
</ul>