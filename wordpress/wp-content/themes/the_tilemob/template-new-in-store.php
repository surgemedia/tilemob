<?php
/**
* Template Name: New in Store & Projects
*/
?>
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part('templates/two-col', 'content'); ?>
<div class="clearfix white_bg">
    <ul>
        <li class="col-lg-2">
            <!-- PDF ITEM -->
        </li>
        <li class="col-lg-2">
            <!-- PDF ITEM -->
        </li>
        <li class="col-lg-2">
            <!-- PDF ITEM -->
        </li>
        <li class="col-lg-2">
            <!-- PDF ITEM -->
        </li>
        <li class="col-lg-2">
            <!-- PDF ITEM -->
        </li>
    </ul>
</div>
<?php endwhile; ?>