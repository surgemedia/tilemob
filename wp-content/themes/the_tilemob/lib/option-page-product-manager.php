<?php 
add_action( 'admin_menu', 'register_my_custom_menu_page' );

function register_my_custom_menu_page(){
	add_menu_page( 'Manage Products', 'Manage Products', 'manage_options', 'custompage', 'my_custom_menu_page', 'dashicons-schedule', 5 ); 
}

function my_custom_menu_page(){
	echo "<iframe height='1000px' width='100%' src='http://tilemob.local/shop/admin/upload-xml.php'></iframe>";
}
 ?>