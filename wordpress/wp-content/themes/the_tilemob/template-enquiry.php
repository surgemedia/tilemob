<?php
/**
* Template Name: Enquiry Page
*/
?>
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part('templates/enquiry', 'content'); ?>
<?php endwhile; ?> 