<div class="banner row">
                        <nav role="navigation">
                          <?php
                              if (has_nav_menu('shop_navigation')) :
                                wp_nav_menu(['theme_location' => 'shop_navigation', 'menu_class' => 'nav style-to-nav']);
                              endif;
                          ?>
                        </nav>
                        <img class="col-lg-12"  src="images/02.jpg">
</div>