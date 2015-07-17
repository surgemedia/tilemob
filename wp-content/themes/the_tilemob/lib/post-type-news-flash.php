<?php 
// Register Custom Post Type
function news_flash_post_type() {

	$labels = array(
		'name'                => _x( 'News Flashes', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'News Flash', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'News Flash', 'text_domain' ),
		'name_admin_bar'      => __( 'News Flash', 'text_domain' ),
		'parent_item_colon'   => __( 'News Flash', 'text_domain' ),
		'all_items'           => __( 'News Flashs', 'text_domain' ),
		'add_new_item'        => __( 'Add News Flash', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New News Flash', 'text_domain' ),
		'edit_item'           => __( 'Edit News Flash', 'text_domain' ),
		'update_item'         => __( 'Update News Flash', 'text_domain' ),
		'view_item'           => __( 'View News Flash', 'text_domain' ),
		'search_items'        => __( 'Search Item', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'news_flash', 'text_domain' ),
		'description'         => __( 'News Flash on the home page', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-megaphone',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,		
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'news_flash', $args );

}

// Hook into the 'init' action
add_action( 'init', 'news_flash_post_type', 0 );