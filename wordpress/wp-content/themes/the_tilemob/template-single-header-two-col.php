<?php
/**
* Template Name: Single Header Two Column Page
*/
?>
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part('templates/single-header-two-col', 'content'); ?>
<?php endwhile; ?> 