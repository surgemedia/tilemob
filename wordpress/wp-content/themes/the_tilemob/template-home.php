<?php
/**
* Template Name: Home Page
*/
?>
<?php while (have_posts()) : the_post(); ?>
<div class="clearfix">
    <div class="row">
        <nav role="navigation">
              <?php
                  if (has_nav_menu('shop_navigation')) :
                    wp_nav_menu(['theme_location' => 'shop_navigation', 'menu_class' => 'nav style-to-nav']);
                  endif;
              ?>
        </nav>
        <div class="set-padding">
            <div class="col-lg-8 white_bg set-gutter-right padding-zero">

                <div id="carousel-example-generic" class="carousel slide carousel-fade" data-ride="carousel">
                    <!-- Indicators -->
                    <!-- <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol> -->
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <?php if(have_rows('slider_icons')): ?>
                            <a href="<?php echo get_field('slider_icons')[2]['url'] ?>" class="view-shop hidden-xs hidden-sm"><img  src="<?php echo get_field('slider_icons')[2]['image'] ?>" ></a>
                            <a href="<?php echo get_field('slider_icons')[1]['url'] ?>" class="view-specifiers hidden-xs hidden-sm"><img  src="<?php echo get_field('slider_icons')[1]['image'] ?>" ></a>
                            <a href="<?php echo get_field('slider_icons')[0]['url'] ?>" class="view-performance hidden-xs hidden-sm"><img  src="<?php echo get_field('slider_icons')[0]['image'] ?>" ></a>
                            <div class="showroom_navbar"><a href="booking" title="Book a consultation in our Brisbane Tile Showroom">Book a <em>showroom consultation</em></a></div>
                        <?php endif; ?>  
                        <?php if(have_rows('slider')): ?>
                            <?php $count = 1; ?>
                            <?php while(have_rows('slider')) : the_row();?>
                                <?php
                                    if($count==1){
                                        $active = 'active';
                                        $count = 0;
                                    }
                                    else {
                                        $active = '';
                                    }
                                ?>
                                <div class="item <?php echo $active?>">
                                    <img  src="<?php the_sub_field('image') ?>">
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        
                    </div>
                    <!-- Controls -->
                    <!-- <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                    </a> -->
                </div>
            </div>
            <div class="col-lg-4 white_bg gutter-bottom">
                <h1 class="mrg-top-zero"><?php the_title(); ?></h1>
                <h2 class="subheading">
                <!-- Subheading  acf -->
                <?php the_field('subheading'); ?> >
                </h2>
                <p><?php the_content(); ?></p>
            </div>
            <div id="news-flash" class="col-lg-4 red_bg side-news">
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
                <a href="enquiry-form">
                    <p class="subtitle">
                    <?php the_title(); ?>
                    </p>
                    <p>
                    <?php the_content(); ?>
                    </p>
                </a>
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
            <div id="latest-product" class="col-lg-4 grey_dark_bg side-news">
                <!-- Linked to New in Store Post Type -->
                <h2>Latest Product > </h2>
                <a href="new-in-store">
                    <p>
                        Introducing ENCAUSTIC Cement Tiles in patterns & solid colours. Read more »
                    </p>
                </a>
                
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>