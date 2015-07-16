<!-- <footer class="content-info" role="contentinfo">
  <div class="container">
    <?php // dynamic_sidebar('sidebar-footer'); ?>
  </div>
</footer> -->
<footer class="clearfix">
    <div class="row footer-nav">
        <div class="col-sm-3 col-lg-3">
            <p><?php the_field('copyrights','option');?></p>
        </div>
        <div class="col-sm-6 col-lg-6">
            <ul class="style-to-nav">
                <?php 
                    if(have_rows('footer_navigation','option')):
                        while(have_rows('footer_navigation','option')): the_row();
                        ?>
                            <li><a href="<?php the_sub_field('nav_link','option');?>" target="_blank"><?php the_sub_field('nav_link_text','option');?></a></li>
                        <?php
                        endwhile;
                    endif;
                ?>
            </ul>
        </div>
        <div class="col-sm-3 col-lg-3">
            <?php 
                    if(have_rows('web_designer_link','option')):
                        while(have_rows('web_designer_link','option')): the_row();
                        ?>
                            <a href="<?php the_sub_field('wd_link','option');?>" target="_blank"><?php the_sub_field('wd_link_text','option');?></a>
                        <?php
                        endwhile;
                    endif;
            ?>
        </div>
    </div>
    <div class="row quick-links">
        <h4>Quick Links</h4>
        <div class="col-sm-4 col-lg-4">
            <ul>
                <?php 
                    if(have_rows('quick_links_1','option')):
                        while(have_rows('quick_links_1','option')): the_row();
                        ?>
                            <li><a href="<?php the_sub_field('ql1_link','option');?>" target="_blank"><?php the_sub_field('ql1_link_text','option');?></a></li>
                        <?php
                        endwhile;
                    endif;
                ?>
            </ul>
        </div>
        <div class="col-sm-4 col-lg-4">
            <ul>
                <?php 
                    if(have_rows('quick_links_2','option')):
                        while(have_rows('quick_links_2','option')): the_row();
                        ?>
                            <li><a href="<?php the_sub_field('ql2_link','option');?>" target="_blank"><?php the_sub_field('ql2_link_text','option');?></a></li>
                        <?php
                        endwhile;
                    endif;
                ?>
            </ul>
        </div>
        <div class="col-sm-4 col-lg-4">
            <ul>
                <?php 
                    if(have_rows('quick_links_3','option')):
                        while(have_rows('quick_links_3','option')): the_row();
                        ?>
                            <li><a href="<?php the_sub_field('ql3_link','option');?>" target="_blank"><?php the_sub_field('ql3_link_text','option');?></a></li>
                        <?php
                        endwhile;
                    endif;
                ?>
            </ul>
        </div>
    </div>
    <div class="row footer-notes">
        <div class="col-sm-6 col-lg-6">
            <p><?php the_field('footer_notes_1','option');?></p>
        </div>
        <div class="col-sm-6 col-lg-6">
            <p><?php the_field('footer_notes_2','option');?></p>
        </div>
    </div>
</footer>