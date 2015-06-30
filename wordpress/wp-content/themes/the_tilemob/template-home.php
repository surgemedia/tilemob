<?php
/**
* Template Name: Home Page
*/
?>
<?php while (have_posts()) : the_post(); ?>
<div class="clearfix">
    <div class="col-lg-8 white_bg gutter-right">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="http://placehold.it/700x750" alt="">
                    <div class="carousel-caption">
                    </div>
                </div>
                <div class="item">
                    <img src="http://placehold.it/700x750" alt="">
                    <div class="carousel-caption">
                    </div>
                </div>
            </div>
            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="col-lg-4 white_bg gutter-bottom">
        <h1><?php the_title(); ?></h1>
        <span class="subheading">
        <!-- Subheading  acf -->
        <?php the_field('subheading'); ?>
        </span>
        <p><?php the_content(); ?></p>
    </div>
    <div id="news-flash" class="col-lg-4 red_bg">
        <h2>News Flash</h2>
        <?php
            // WP_Query arguments
            $args = array (
                'post_type'              => array( 'news_flash' ),
                'pagination'             => false,
                'order'                  => 'DESC',
                'orderby'                => 'date',
            );
            // The Query
            $query_news_flash = new WP_Query( $args );
            // The Loop
        if ( $query_news_flash->have_posts() ) {
        while ( $query_news_flash->have_posts() ) {
        $query_news_flash->the_post(); ?>
        <!-- Post Type -->
        <span class="subtitle">
        <?php the_title(); ?>
        </span>
        <p>
        <?php the_content(); ?>
        </p>
        <!-- Post Type -->
        <?php
                }
            } else {
                echo "<p>There is currently no news</p>";
            }
            // Restore original Post Data
            wp_reset_postdata();
        ?>
    </div>
    <div id="latest-product" class="col-lg-4 grey_light_bg">
        <!-- Linked to New in Store Post Type -->
        <h2>Latest Product</h2>

        <?php // WP_Query arguments
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
            while ( $new_in_store_query->have_posts() ) {
                $new_in_store_query->the_post();
                ?>
        <!-- Post Type -->
        <a href="#">
            <span class="subtitle"><?php the_title(); ?></span>
            <p><?php the_content(); ?></p>
        </a>
        <!-- Post Type -->
        <?php
                
            }
        } else {
            // no posts found
        }

        // Restore original Post Data
        wp_reset_postdata();
        ?>
        <!-- Post Type -->
    </div>
</div>
<?php endwhile; ?>