<?php get_template_part('templates/banner'); ?>
<div class="clearfix white_bg ">
	
	<div class="col-lg-12 ">
        <div class="page-header">
		    <h1><?php the_title(); ?></h1>
		</div>
    </div>

	<div class="two-col">
	    <div class="col-lg-12">
	    	<dl class="dl-horizontal career-description">
			  <dt>Employment Type:</dt><dd><?php the_field('employment_type'); ?></dd>
			  <dt>Location:</dt><dd><?php the_field('location'); ?></dd>
			  <dt>Description:</dt><dd><?php the_field('description'); ?></dd>
			  <dt>General Description:</dt><dd><?php the_field('general_description'); ?></dd>
			  <dt>Duties:</dt><dd><?php the_field('duties'); ?></dd>
			  <dt>Qualifications:</dt><dd><?php the_field('qualifications'); ?></dd>
			  <dt>Remuneration:</dt><dd><?php the_field('remuneration'); ?></dd>
			  <dt></dt>
			  <dd> 
			  		<img src="<?php the_field('career_post_image','option') ?>" >
			  </dd>
			  <dt></dt>
			  <dd>
			  		<?php 
						if(the_field('career_post_text','option')) {
					?>
						<img src="<?php the_field('career_post_text','option'); ?>">
					<?php
						}
					?>
			  </dd>
			</dl>
			
			
		</div>
	</div>
</div>