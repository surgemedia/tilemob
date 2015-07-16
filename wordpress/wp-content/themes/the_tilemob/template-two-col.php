<?php
/**
* Template Name: Two Column Page
*/
?>
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part('templates/two-col', 'content'); ?>
<?php endwhile; ?> 