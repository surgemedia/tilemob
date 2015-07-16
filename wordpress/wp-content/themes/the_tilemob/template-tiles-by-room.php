<?php
/**
* Template Name: Tiles By Room
*/
?>
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part('templates/tiles-by', 'room'); ?>
<?php endwhile; ?> 