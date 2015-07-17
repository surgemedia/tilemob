<?php
/**
* Template Name: Two Column Page
*/
?>
<?php while (have_posts()) : the_post(); ?>
<div class="clearfix white_bg">
    <?php get_template_part('templates/page', 'header'); ?>
    <!-- form-control and get gravity form -->
        
</div>
</div>
<?php endwhile; ?>
