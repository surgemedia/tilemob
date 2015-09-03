<?php
/**
* Template Name: Projects
*/
?>
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part('templates/two-col', 'content'); ?>

<div class="clearfix white_bg">
    <?php
        $featured_id = get_field('featured_pdf');
        // WP_Query arguments
        $args = array (
            'post_type'              => array( 'project' ),
            'pagination'             => false,
            'order'                  => 'DESC',
            'orderby'                => 'modified',
            'p'                      => $featured_id,
            
        );
        // The Query
        $new_in_store_query = new WP_Query( $args );
        
        // The Loop
        if ( $new_in_store_query->have_posts() ) {
            while ( $new_in_store_query->have_posts() ) { $new_in_store_query->the_post(); 
    ?>
    
                <div class="col-sm-6">
                    <div class="pdf-object">
                        <a target="_blank" href="<?php echo get_field('pdf')['url']; ?>">
                            <img src="<?php the_field('thumbnail') ?>" alt="">
                            <span><?php the_title() ?></span>
                        </a>
                    </div>
                </div>

            <?php }
        } else {
                // no posts found
        }
            // Restore original Post Data
        wp_reset_postdata();
    ?>
    <?php
        // WP_Query arguments
        $args = array (
            'post_type'              => array( 'project' ),
            'pagination'             => false,
            'order'                  => 'DESC',
            'orderby'                => 'modified',
            'post__not_in' => array($featured_id),
            
        );
        // The Query
        $new_in_store_query = new WP_Query( $args );
        
        // The Loop
        if ( $new_in_store_query->have_posts() ) {
            while ( $new_in_store_query->have_posts() ) { $new_in_store_query->the_post(); 
    ?>
    
                <div class="col-sm-3">
                    <div class="pdf-object">
                        <a target="_blank" href="<?php echo get_field('pdf')['url']; ?>">
                            <img src="<?php the_field('thumbnail') ?>" alt="">
                            <span><?php the_title() ?></span>
                        </a>
                    </div>
                </div>

            <?php }
        } else {
                // no posts found
        }
            // Restore original Post Data
        wp_reset_postdata();
    ?>

</div>
<?php endwhile; ?>