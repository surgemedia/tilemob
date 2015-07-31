<?php 
// Register Custom Post Type
function our_careers() {

	$labels = array(
		'name'                => _x( 'Our Careers', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Our Career', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Our Careers', 'text_domain' ),
		'name_admin_bar'      => __( 'Our Career', 'text_domain' ),
		'parent_item_colon'   => __( 'Our Career', 'text_domain' ),
		'all_items'           => __( 'All Careers', 'text_domain' ),
		'add_new_item'        => __( 'Add New Career', 'text_domain' ),
		'add_new'             => __( 'Add New Career', 'text_domain' ),
		'new_item'            => __( 'New Career', 'text_domain' ),
		'edit_item'           => __( 'Edit Career', 'text_domain' ),
		'update_item'         => __( 'Update Career', 'text_domain' ),
		'view_item'           => __( 'View Career', 'text_domain' ),
		'search_items'        => __( 'Search Career', 'text_domain' ),
		'not_found'           => __( 'Career Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Career Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'our_careers', 'text_domain' ),
		'description'         => __( 'Post Type Description', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-businessman',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'our_careers', $args );

}

// Hook into the 'init' action
add_action( 'init', 'our_careers', 0 );