<?php

 
// function register_my_custom_menu_page() {
// $page_title = "Manage Products";
// $menu_title = "Manage Products";
// $capability = "";
// $menu_slug = "/manage_products.php";
// $function = "Manage Products";
// $icon_url = "dashicons-schedule";
// $position = 6;
//     add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
// }
// add_action('admin_menu', 'register_my_custom_menu_page');

?>

<?php 
add_action( 'admin_menu', 'register_my_custom_menu_page' );

function register_my_custom_menu_page(){
	add_menu_page( 'Manage Products', 'Manage Products', 'manage_options', 'custompage', 'my_custom_menu_page', 'dashicons-schedule', 6 ); 
}

function my_custom_menu_page(){
	echo "<iframe height='1000px' width='100%' src='http://localhost:8888/tilemob/tilesbrisbane/admin/upload-xml.php'></iframe>";
}
 ?>