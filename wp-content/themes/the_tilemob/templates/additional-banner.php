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
<?php if(have_rows('additional_banner')): ?>
    <?php while(have_rows('additional_banner')) : the_row();?>
        <img class="banner-icon"  src="<?php the_sub_field('banner_icon') ?>">
    <?php endwhile; ?>
<?php endif; ?>