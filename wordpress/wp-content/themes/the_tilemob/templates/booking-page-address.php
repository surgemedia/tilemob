
		<div class="row">
			<div class="page-header text-center col-lg-6">
			  <img src="<?php the_field("heading_image")?>">
			  <h4 class="text-left"><?php the_field('form_heading'); ?></h4>
			</div>
			<div class="col-lg-6">
				<div class="col-lg-4">
	        		<a class="brand" href="<?= esc_url(home_url('/')); ?>"><img src="<?php the_field('logo2','option'); ?>" alt="<?php bloginfo('name');?>"></a>
				</div>
				<div class="col-lg-8 address">
					<span class="black-span">Showroom</span>
					<?php 
			          if(have_rows('address','option')):
			            while(have_rows('address','option')) : the_row();
			              ?>
			                <p><?php the_sub_field('address_line_1','option');?></p>
			                <p><?php the_sub_field('address_line_2','option');?></p>
	        				<p><span>Ph. </span><?php the_field('phone_number','option'); ?></p>
			              <?php
			            endwhile;
			          endif;
			        ?>
				</div>
			</div>
		</div>
		