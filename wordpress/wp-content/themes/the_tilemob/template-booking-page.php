<?php
/**
* Template Name: Booking Page
*/
?>
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part('templates/booking-page', 'content'); ?>
<?php endwhile; ?> 