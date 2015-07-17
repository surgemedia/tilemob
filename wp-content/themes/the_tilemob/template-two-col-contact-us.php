<?php
/**
* Template Name: Two Column Page with Map
*/
?>
<?php while (have_posts()) : the_post(); ?>
<div class="clearfix white_bg">
    <div class="col-lg-6 ">
   <?php get_template_part('templates/page', 'header'); ?>
        
    </div>
    <div class="col-lg-6">
   <?php get_template_part('templates/page', 'h2'); ?>
	
        
</div>
</div>
<?php endwhile; ?>
