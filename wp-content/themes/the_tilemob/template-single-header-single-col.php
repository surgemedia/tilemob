<?php
/**
* Template Name: Single Header Single Column Page
*/
?>
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part('templates/single-header-one-col', 'content'); ?>
<?php endwhile; ?> 