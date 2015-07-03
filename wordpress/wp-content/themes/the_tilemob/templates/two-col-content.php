<?php get_template_part('templates/banner'); ?>
<div class="clearfix white_bg two-col">
    <div class="col-lg-6 ">
        <?php get_template_part('templates/two-col', 'h1'); ?>
        <?php the_field('first_content') ?>
    </div>
    <div class="col-lg-6">
        <?php get_template_part('templates/two-col', 'h2'); ?>
        <?php the_field('second_content') ?>
        
    </div>
</div>