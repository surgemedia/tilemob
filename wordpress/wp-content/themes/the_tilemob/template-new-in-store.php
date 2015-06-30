<?php
/**
* Template Name: New in Store & Projects
*/
?>
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part('templates/two-col', 'content'); ?>
<div class="clearfix white_bg">
    <?php
        // WP_Query arguments
        $args = array (
            'post_type'              => array( 'new_in_store' ),
            'pagination'             => false,
            'order'                  => 'DESC',
            'orderby'                => 'date',
        );
        // The Query
        $new_in_store_query = new WP_Query( $args );
        // The Loop
        if ( $new_in_store_query->have_posts() ) {
    while ( $new_in_store_query->have_posts() ) { $new_in_store_query->the_post(); ?>
    <div class="pdf-object col-lg-4">
        <a href="<?php get_field('pdf')['url']; ?>">
        <img src="<?php the_field('thumbnail') ?>" alt="">
        <span><?php the_title() ?></span>
        </a>
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