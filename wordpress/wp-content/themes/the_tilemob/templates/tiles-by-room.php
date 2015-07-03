<?php get_template_part('templates/banner'); ?>
<div class="clearfix white_bg ">
	<div class="col-lg-12 ">
        <?php get_template_part('templates/two-col', 'h1'); ?>
		<div class="two-col">
			<div>
        		<?php the_field('content') ?>
        	</div>
        </div>
    </div>
</div>


