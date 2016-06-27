<header class="banner" role="banner">
<div class="container header">

  <div class="row">
    <ul class="social-networks">
        <li class="hidden-xs hidden-sm"><small>The Mob Social Networks: </small></li>
        <?php 
        if(have_rows('social_networking','option')) :
          while(have_rows('social_networking','option')) : the_row();
        ?>
          <li><a href="<?php the_sub_field('link','option'); ?>"><img width="26" height="32" src="<?php the_sub_field('icon','option'); ?>"></a></li>
        <?php
          endwhile;
        endif;
        ?>
    </ul>
    <div class="col-sm-6 col-lg-5">
      <div class="col-sm-6 col-lg-6">
        <a class="brand" href="<?= esc_url(home_url('/')); ?>"><img width="223" height="160" src="<?php the_field('logo','option'); ?>" alt="<?php bloginfo('name');?>"></a>
      </div>
      <div class="col-sm-6 col-lg-6 sinceLogo hidden-sm hidden-xs">
        <img width="120" height="120" src="<?php the_field('other_image','option'); ?>" alt="Since 1976">
      </div>
    </div>
    <div class="col-sm-6 col-lg-7 contact-details">
      <h1 class="site-header-title hidden-sm hidden-xs">The Ultimate Tile Source</h1>
      <div class="col-sm-8 col-md-6 col-lg-8 address">
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
      <div class="col-sm-4 col-md-6 col-lg-4 phone">
        <?php
          $phone = get_field('phone_number','option');
          // $phone = str_replace(" ", "", $phone);
          $phone = preg_replace('/[^A-Za-z0-9]/','', $phone);
        ?>
        <p><span>Ph. </span><a href="tel:<?php echo $phone ?>"><?php the_field('phone_number','option'); ?></a></p>
        <div id="headlinks" class="headlinks">
          <ul class="style-to-nav">
            <!-- <li style="border:0;"><a href="my-account.php" title="My account">My account</a></li> -->
            
            <?php 
            if(isset($_COOKIE)){
            $_shop_total_cart = $_COOKIE["_shop_total_cart"];
            if($_shop_total_cart>0) {
              echo '<li><a href="/shop/my-cart.php" title="View My Collection">View My Collection ( <span id="header_cart_items">'.$_shop_total_cart.'</span> items)</a></li>';
            } else { echo '<li><a href="/shop/my-cart.php" title="My cart">View My Collection (<span id="header_cart_items">0</span> items)</a></li>'; }
            }
            ?>    
            <li class="hidden-xs hidden-md"><a href="/shop/checkOut.php" title="Checkout" style="border:0;">Submit My Collection >></a></li>
          </ul>
          <div class="clear"></div>
        </div>
      </div>
    </div>
    
  </div>

</div>
  <div class="container">
    <nav role="navigation" class="navbar">
        <div class="navbar-header hidden-sm hidden-md hidden-lg">
            <div class="row mob-nav">
                <div id="headlinks" class="col-xs-9 headlinks hidden-sm hidden-md hidden-lg">
                    <ul class="style-to-nav">
                      <li class=""><a href="/shop/checkOut.php" title="Checkout" style="border:0;">Submit My Collection >></a></li>
                    </ul>
                </div>
                <div class="col-xs-3">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="true">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1" aria-expanded="true">
            <?php
            if (has_nav_menu('primary_navigation')) :
              wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
            endif;
            ?>
        </div>
    </nav>

  </div>
  
</header>
