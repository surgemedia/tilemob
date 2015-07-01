<header class="banner" role="banner">
<div class="container header">

  <div class="row">
    <div class="col-sm-6 col-lg-6">
      <div class="col-sm-6 col-lg-6">
        <a class="brand" href="<?= esc_url(home_url('/')); ?>"><img src="<?php the_field('logo','option'); ?>" alt="<?php bloginfo('name');?>"></a>
      </div>
      <div class="col-sm-6 col-lg-6 translateY-37">
        <img src="<?php the_field('other_image','option'); ?>" alt="Since 1976">
      </div>
    </div>
    <div class="col-sm-6 col-lg-6 translateY-117">
      <div class="col-sm-6 col-lg-6">
        <p><?php the_field('address','option'); ?></p>
      </div>
      <div class="col-sm-6 col-lg-6 translateY-169">
        <p><?php the_field('phone_number','option'); ?></p>
      </div>
    </div>
    <ul class="social-networks">
        <li>The Mob Social Networks: </li>
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
