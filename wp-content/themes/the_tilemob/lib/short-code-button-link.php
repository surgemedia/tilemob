<?php
	function shop_link() {
		return '<a href="/shop" class="btn btn-danger">View Full Tile Range</a>';
	}
	add_shortcode( 'shop-link', 'shop_link' );

	function store_link() {
		return '<a href="/new-in-store" class="btn btn-danger">New in Store</a>';
	}
	add_shortcode( 'store-link', 'store_link' );
	
?>