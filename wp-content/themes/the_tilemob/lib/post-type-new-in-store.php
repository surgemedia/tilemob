<?php 
// Register Custom Post Type
function new_in_store_post_type() {

	$labels = array(
		'name'                => _x( 'PDFs', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'PDF', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'New in Store', 'text_domain' ),
		'name_admin_bar'      => __( 'New in Store', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Items', 'text_domain' ),
		'add_new_item'        => __( 'Add New Item', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New Item', 'text_domain' ),
		'edit_item'           => __( 'Edit Item', 'text_domain' ),
		'update_item'         => __( 'Update Item', 'text_domain' ),
		'view_item'           => __( 'View Item', 'text_domain' ),
		'search_items'        => __( 'Search Item', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'new_in_store', 'text_domain' ),
		'description'         => __( 'A list of new PDF about your products', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-store',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'new_in_store', $args );

}
// Register Custom Taxonomy
function new_in_store_filters() {

	$labels = array(
		'name'                       => _x( 'filters', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Filter', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Filters', 'text_domain' ),
		'all_items'                  => __( 'All Filters', 'text_domain' ),
		'parent_item'                => __( 'Parent Filter', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Filter:', 'text_domain' ),
		'new_item_name'              => __( 'New Filter Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Filter', 'text_domain' ),
		'edit_item'                  => __( 'Edit Filter', 'text_domain' ),
		'update_item'                => __( 'Update Filter', 'text_domain' ),
		'view_item'                  => __( 'View Filter', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Filters', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Filters', 'text_domain' ),
		'search_items'               => __( 'Search Filters', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No Filters', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'filters', array( 'new_in_store' ), $args );

}
// Hook into the 'init' action
add_action( 'init', 'new_in_store_post_type', 0 );
add_action( 'init', 'new_in_store_filters', 0 );