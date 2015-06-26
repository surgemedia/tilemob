<header class="banner" role="banner">
<div class="container">
  <div class="social-networks"></div>
  <ul>
    <li><a href=""><i></i></a></li>
    <li><a href=""><i></i></a></li>
    <li><a href=""><i></i></a></li>
    <li><a href=""><i></i></a></li>
    <li><a href=""><i></i></a></li>
  </ul>
   <a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
  <ul class="address-header">
    <li></li>
    <li></li>
    <li></li>
    <li></li>
  </ul>
  <span class="phone"></span>
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
