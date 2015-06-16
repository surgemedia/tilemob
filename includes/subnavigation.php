<div id="subnavigation" class="subnavigation">
	<ul>
		<?php
		$subnavigation_links = array('bathroom.php'=>'Bathroom','kitchen.php'=>'Kitchen','outdoor.php'=>'Outdoor',
		'internal.php'=>'Internal','pool.php'=>'Pool','specials.php'=>'Specials','latest.php'=>'Latest');
		$subnavigation_string = $footer_subnavigation_string = '';
		foreach($subnavigation_links as $subnavgation_link => $subnavgation_name) {
			//if($_GET['ke']==$subnavgation_name){$li_selected_style=' style="color:#EF3E34;"';}else{$li_selected_style='';}
			$li_selected_style = '';
			$subnavigation_string .= '<li><a href="'.$subnavgation_link.'" title="'.$subnavgation_name.'"'.$li_selected_style.'>'.$subnavgation_name.'</a></li>';
			$footer_subnavigation_string .= '<li><a href="'.$subnavgation_link.'" title="'.$subnavgation_name.'"'.$li_selected_style.'>'.$subnavgation_name.'</a></li>';
		}
		echo $subnavigation_string;
		?>
	</ul>
	<div class="clear"></div>
</div>
<div class="clear"></div>
