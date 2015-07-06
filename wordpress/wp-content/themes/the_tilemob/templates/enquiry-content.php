<?php get_template_part('templates/banner'); ?>
<div class="clearfix white_bg two-col">
    <div class="col-lg-12 ">
        <?php get_template_part('templates/two-col', 'h1'); ?>
    </div>
    <div class="col-lg-12 enquiry-form">
        <?php the_field('enquiry_form') ?>
	</div>
</div>