<?php
	function display_address() {
		get_template_part('templates/booking-page-address');
	}
	add_shortcode('contact-address','display_address');
?>