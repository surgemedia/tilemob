<!-- <div class="banner row">
    <div class="col-lg-1">
        <img src="http://fakeimg.pl/97x145/?text=Hello">
    </div>
    <div class="col-lg-6">
        <img src="http://fakeimg.pl/700x145/?text=Hello">
    </div>
    <div class="col-lg-5">
        <img src="http://fakeimg.pl/458x145/?text=Hello">
    </div>
</div> -->
<div class="banner row">
    <nav role="navigation">
      <?php
          if (has_nav_menu('shop_navigation')) :
            wp_nav_menu(['theme_location' => 'shop_navigation', 'menu_class' => 'nav style-to-nav']);
          endif;
      ?>
    </nav>
    <img class="col-xs-12"  src="<?php the_field('banner') ?>">
</div>