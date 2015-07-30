<header class="banner" role="banner">
<div class="container header">

  <div class="row">

    <div class="col-sm-6 col-lg-5">
      <div class="col-sm-6 col-lg-6">
        <a class="brand" href="<?= esc_url(home_url('/')); ?>"><img src="<?php the_field('logo','option'); ?>" alt="<?php bloginfo('name');?>"></a>
      </div>
      <div class="col-sm-6 col-lg-6 sinceLogo">
        <img src="<?php the_field('other_image','option'); ?>" alt="Since 1976">
      </div>
    </div>
    <div class="col-sm-6 col-lg-7 contact-details">
      <h1 class="site-header-title">The Ultimate Tile Source</h1>
      <div class="col-sm-8 col-md-7 col-lg-8 address">
        <?php 
          if(have_rows('address','option')):
            while(have_rows('address','option')) : the_row();
              ?>
                <h4><?php the_sub_field('showroom','option');?></h4>
                <p><?php the_sub_field('address_line_1','option');?></p>
                <p><?php the_sub_field('address_line_2','option');?></p>
                <a href="<?php the_sub_field('link_to_contact_page','option');?>">Go to our Contact/Map page >></a>
              <?php
            endwhile;
          endif;
        ?>
      </div>
      <div class="col-sm-4 col-md-5 col-lg-4 phone">
        <p><span>Ph. </span><?php the_field('phone_number','option'); ?></p>
        <div id="headlinks" class="headlinks">
          <ul class="style-to-nav">
            <!--<li style="border:0;"><a href="my-account.php" title="My account">My account</a></li>-->
            <?php 
            // $_shop_total_cart = $_COOKIE["_shop_total_cart"];
            // if($_shop_total_cart>0) {
              // echo '<li><a href="/shop/my-cart.php" title="My cart">My cart ( <span id="header_cart_items">'.$_shop_total_cart.'</span> items)</a></li>';
            // } else { echo '<li><a href="/shop/my-cart.php" title="My cart">My cart (<span id="header_cart_items">0</span> items)</a></li>'; }
            ?>    
            <!-- <li><a href="/shop/checkOut.php" title="Checkout" style="border:0;">My Wishlist >></a></li> -->
          </ul>
          <div class="clear"></div>
        </div>
      </div>
    </div>
    <ul class="social-networks">
        <li><small>The Mob Social Networks: </small></li>
        <?php 
        if(have_rows('social_networking','option')) :
          while(have_rows('social_networking','option')) : the_row();
        ?>
          <li><a href="<?php the_sub_field('link','option'); ?>"><img src="<?php the_sub_field('icon','option'); ?>"></a></li>
        <?php
          endwhile;
        endif;
        ?>
    </ul>
  </div>

</div>
  <div class="container">
    <nav role="navigation">
      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
      endif;
      ?>
    </nav>

  </div>
  
</header>
