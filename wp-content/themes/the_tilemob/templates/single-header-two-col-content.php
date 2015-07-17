<?php get_template_part('templates/banner'); ?>
<div class="clearfix white_bg ">
	
	<div class="col-lg-12 ">
        <?php get_template_part('templates/two-col', 'h1'); ?>
        <?php get_template_part('templates/additional-banner'); ?>
    </div>

	<div class="two-col">
	    <div class="col-lg-6">
	    	<?php the_field('first_content') ?>
	    </div>
	    <div class="col-lg-6">
	        <?php the_field('second_content') ?>
	    </div>
	</div>
</div>