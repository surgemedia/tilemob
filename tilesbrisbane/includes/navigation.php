<div id="navigation" class="navigation">
	<ul>
		<?php
		$navigation_string = $footer_navigation_string = '';
		$result_navigation = mysql_query("SELECT * FROM shop_content WHERE under_content_id='0' AND is_onmenu='1' AND is_hidden='0' AND is_active='1'");
		while($row_navigation = mysql_fetch_array($result_navigation)) {			
			$navigation_linkname = $row_navigation['linkname'];
			$navigation_pageurl = $row_navigation['pageurl'];
			if($_pageurl==$navigation_pageurl){$link_selected_style=' style="text-decoration:underline;"';}else{$link_selected_style='';}
			$navigation_string .= '<li><a href="'.$navigation_pageurl.'" title="'.$navigation_linkname.'"'.$link_selected_style.'>'.$navigation_linkname.'</a></li>';
			$footer_navigation_string .= '<li><a href="'.$navigation_pageurl.'" title="'.$navigation_linkname.'">'.$navigation_linkname.'</a></li>';
		}
		echo $navigation_string;
		?>
	</ul>
	<div class="clear"></div>
</div>
<div class="clear"></div>
