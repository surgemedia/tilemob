<?php
/**
* Template Name: Page with icon headings (E3 Performance)
*/
?>
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part('templates/banner'); ?>    
<div class="clearfix white_bg">
  <?php get_template_part('templates/page', 'header'); ?>
    <ul class="clearfix">
        <li class="col-lg-4">
            <div class="icon">
            <i class="fa fa-images"></i>
            </div>
            <span></span>
        </li>
        <li class="col-lg-4">
            <div class="icon">
            <i class="fa fa-images"></i>
            </div>
            <span></span>
        </li>
        <li class="col-lg-4">
            <div class="icon">
            <i class="fa fa-images"></i>
            </div>
            <span></span>
        </li>
        <li class="col-lg-4">
            <div class="icon">
            <i class="fa fa-images"></i>
            </div>
            <span></span>
        </li>
    </ul>
    <div class="col-lg-6 ">
        <?php get_template_part('templates/two-col', 'h1'); ?>
        <?php the_field('first_content') ?>
    </div>
    <div class="col-lg-6">
    <?php get_template_part('templates/two-col', 'h2'); ?>
    <?php the_field('second_content') ?>
</div>
<div class="clearfix white_bg">
    
</div>
</div>
<?php endwhile; ?>