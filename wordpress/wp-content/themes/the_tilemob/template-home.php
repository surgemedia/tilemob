<?php
/**
* Template Name: Home Page
*/
?>
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part('templates/page', 'header'); ?>

<div class="clearfix">
    <div class="col-lg-9 white_bg">
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
    <div class="col-lg-3 white_bg">
        <h1><?php the_title(); ?></h1>
        <span class="subheading">
        <!-- Subheading  acf -->
        Lorem ipsum Ea ut nostrud aute.
        </span>
         <p><?php the_content(); ?></p>
    </div>
       
        <div id="news-flash" class="col-lg-3 red_bg">
        <!-- Post Type -->
        	<h2>News Flash</h2>
        	<span class="subtitle">
        	Lorem ipsum Dolor Duis nisi Ut sit.
        	</span>
        		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, numquam, veniam. Dolorum voluptatibus magni culpa maxime, molestias nihil assumenda totam suscipit reiciendis numquam velit rerum iusto qui amet porro alias.</p>

        <!-- Post Type -->
        </div>
         <div id="news-flash" class="col-lg-3 grey_light_bg">
        <!-- Post Type -->
        	<h2>News Flash</h2>
        	<span class="subtitle">
        	Lorem ipsum Dolor Duis nisi Ut sit.
        	</span>
        		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, numquam, veniam. Dolorum voluptatibus magni culpa maxime, molestias nihil assumenda totam suscipit reiciendis numquam velit rerum iusto qui amet porro alias.</p>

        <!-- Post Type -->
        </div>
</div>
<?php endwhile; ?>
<footer class="clearfix">
	<div class="col-lg-3">
		<div class="heading"></div>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi doloribus necessitatibus quibusdam, dignissimos sunt error, vitae officiis nulla velit voluptate, doloremque debitis magnam assumenda dicta natus et aut fugiat! Voluptate. </p>
	</div>
	<div class="col-lg-3">
		<div class="heading"></div>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae est non perferendis minima quae ut atque ex, provident fugit cum? Fugit ab nobis dolor debitis quod deleniti, temporibus earum tenetur.</p>
	</div>
	<div class="col-lg-3">
		<div class="heading"></div>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat voluptatum sequi cumque iste esse, tempore ipsam est assumenda quod eaque, quam dolores veniam aliquam. Velit voluptatem nostrum in ut maiores.</p>
	</div>
	<div class="col-lg-3">
		<div class="heading"></div>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Totam, explicabo. Fugiat adipisci, suscipit minus, laboriosam quae voluptates aspernatur et. Facere ipsam earum esse quas ipsum quod vel, commodi! Soluta, a.</p>
	</div>
</footer>