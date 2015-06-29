<header class="banner" role="banner">
<div class="container">
  <div class="social-networks"></div>
  <ul>
    <li><a href="http://www.facebook.com"><i class="fa fa-facebook"></i></a></li>
    <li><a href="http://www.facebook.com"><i class="fa fa-twitter"></i></a></li>
    <li><a href="http://www.facebook.com"><i class="fa fa-pinterest"></i></a></li>
    <li><a href="http://www.facebook.com"><i class="fa fa-instagram"></i></a></li>
    <li><a href="http://www.facebook.com"><i class="fa fa-houzz"></i></a></li>
  </ul>
   <a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
  <ul class="address-header">
<li> BRISBANE TILES SHOWROOM</li>
<li>4-6 Blackwood St (Cnr Samford Rd)</li>
<li>Mitchelton Queensland Australia 4053</li>
<li>Go to our Contact/Map page »</li>
  </ul>
  <span class="phone">Ph. (07) 3355 5055</span>
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
