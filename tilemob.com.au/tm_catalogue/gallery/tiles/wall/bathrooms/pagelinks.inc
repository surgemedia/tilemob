<?$pagecount=24;$server_dir_main="http://www.tilemob.com.au/tm_catalogue/";$this_image_folder_root="gallery/tiles/wall/bathrooms/";$currentpage=$_GET['page'];
			if ($currentpage > 1) {
			echo ' <a href="'.$server_dir_main.$this_image_folder_root.'page'.($currentpage-1).'/index.php?page='.($currentpage-1).'"> « Prev </a>';
			}
			for($i=0; $i<$pagecount; $i++) {
				if(($i+1) != $currentpage) {
					echo ' | ';
					echo '<a href="'.$server_dir_main.$this_image_folder_root.'page'.($i+1).'/index.php?page='.($i+1).'">';
					echo ''.($i+1).'';
					echo '</a>';
				} else {
					echo ' | ';
					echo '<span class="selectedpage">';
					echo '<a href="'.$server_dir_main.$this_image_folder_root.'page'.($i+1).'/index.php?page='.($i+1).'">';
					echo '<b>'.($i+1).'</b>';
					echo '</a>';
					echo '</span>';
				}
			}
			echo ' | ';
			if ($currentpage < $pagecount) {
			echo ' <a href="'.$server_dir_main.$this_image_folder_root.'page'.($currentpage+1).'/index.php?page='.($currentpage+1).'"> Next » </a>';
			}
			?>