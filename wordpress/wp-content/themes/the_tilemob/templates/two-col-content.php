<?php get_template_part('templates/banner'); ?>
<div class="clearfix white_bg two-col">
    <div class="col-lg-6 ">
        <?php get_template_part('templates/two-col', 'h1'); ?>
        <?php the_field('first_content') ?>
    </div>
    <div class="col-lg-6">
        <?php get_template_part('templates/two-col', 'h2'); ?>
        <?php the_field('second_content') ?>

		<?php if (get_the_title()=="Careers")
			{
				// WP_Query arguments
				$args = array (
					'post_type'              => array( 'careers' ),
				);
				
				// The Query
				$query = new WP_Query( $args );
				
				// The Loop
				if ( $query->have_posts() ) {
					echo "<ul>";
					while ( $query->have_posts() ) {
						$query->the_post();
						// do something
						
				?>
					<li><a target="_blank" href="#">
                            
                            <?php the_title() ?>
                        </a></li>

				<?php

					}
				echo "</ul>";
				} else {
					echo  "no posts found";
				}
				
				// Restore original Post Data
				wp_reset_postdata();
			}

		 ?>
		
    </div>
</div>