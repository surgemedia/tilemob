<?php
/**
* Template Name: New in Store & Projects
*/
?>
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part('templates/two-col', 'content'); ?>

<div id="pdflisting" class=" clearfix white_bg">
<section class="search-field col-md-4">
        <div class="col-xs-12">
            <label for="">Keywords</label><br>
            <input class="search" type="text" placeholder="Please input the keywords related">
        </div>
       
        <div class="col-xs-12 col-sm-12">
            <label for="">Category</label>
            <ul class="list-inline">
             
             <?php 
            $terms = get_terms( array(
                'taxonomy' => 'filters',
                'hide_empty' => false,
            ) );
                wp_reset_postdata();
             //debug(sizeof($terms)) ?>
             <?php for ($i=0; $i < sizeof($terms); $i++) { ?>
                <li>
                   <div class="checkbox">
                    <label>
                      <input id="" type="checkbox" class="filter" value="<?php echo $terms[$i]->slug ?>"> <?php echo $terms[$i]->name ?>
                    </label>
                  </div>
                </li>
            <?php }; ?>
            </ul>
          
        </div>
        <script>
            
        </script>
    </section>

    <ul class="list col-md-8">
    <?php
        $featured_id = get_field('featured_pdf');
        // WP_Query arguments
        $args = array (
            'post_type'              => array( 'new_in_store' ),
            'pagination'             => false,
            'order'                  => 'DESC',
            'orderby'                => 'modified',
            'p'                      => $featured_id,


        );
        // The Query
        $new_in_store_query = new WP_Query( $args );
        // The Loop
        if ( $new_in_store_query->have_posts() ) {
            while ( $new_in_store_query->have_posts() ) { $new_in_store_query->the_post();
    ?>

                <li class="col-sm-6">
                    <div class="pdf-object featured">
                        <a target="_blank" href="<?php echo get_field('pdf')['url']; ?>">
                            <img src="<?php the_field('thumbnail') ?>" alt="">
                            <span class="title"><?php the_title() ?></span>
                            <span class="category"><?php echo get_the_term_list( get_the_id(), 'filters', '', ', ' ); ?></span>
                        </a>
                    </div>
                </li>

            <?php }
        } else {
                // no posts found
        }
            // Restore original Post Data
        wp_reset_postdata();
    ?>
    <?php
        // WP_Query arguments
        $args = array (
            'post_type'              => array( 'new_in_store' ),
            'pagination'             => false,
            'order'                  => 'DESC',
            'orderby'                => 'modified',
            'post__not_in' => array($featured_id),
            'posts_per_page' => -1,

        );
        // The Query
        $new_in_store_query = new WP_Query( $args );

        // The Loop
        if ( $new_in_store_query->have_posts() ) {
            while ( $new_in_store_query->have_posts() ) { $new_in_store_query->the_post();
    ?>

                <li class="col-sm-3">
                    <?php //debug(wp_get_post_terms( get_the_id(), 'filters', array("fields" => "all") )); ?>
                    <div class="pdf-object">
                        <a target="_blank" href="<?php echo get_field('pdf')['url']; ?>">
                            <img src="<?php the_field('thumbnail') ?>" alt="">
                            <span class="title"><?php the_title() ?></span>
                                <span class="category">
                            <?php 
                            $objTerms = wp_get_post_terms( get_the_id(), 'filters', array("fields" => "all") );
                            for ($j=0; $j < sizeof($objTerms); $j++) { 
                                echo $objTerms[$j]->slug.',';
                            } 
                            ?>

                             <?php //debug($objTerms); ?></span>
                        </a>
                    </div>
                </li>

            <?php }
        } else {
                // no posts found
        }
            // Restore original Post Data
        wp_reset_postdata();
    ?>
    </ul>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.2.0/list.js"></script>
<script>
    
var options = {
    valueNames: [ 'title','category' ]
    };

    var datalist = new List('pdflisting', options);


    var activeFilters = [];

    //filter
    jQuery('.filter').change(function() {
        // console.log(jQuery('.filter'));
        var filters = jQuery('.filter');
        var filters_string = "";
        for (var i =  0; i < filters.length; i++) {
            if(jQuery(filters[i]).is(":checked")){
            filters_string += jQuery(filters[i]).val()+',';
            }
        }
        //console.log(filters_string.length > 0);
        var isChecked = this.checked;
        //var value = jQuery(this).val();
        
        if(filters_string.length > 0){
            //  add to list of active filters (case sensitive)
            activeFilters.push(filters_string);
            //console.log(value);
        }
        else
        {
            // remove from active filters
            activeFilters.splice(activeFilters.indexOf(filters_string), 1);
        }
        
        datalist.filter(function (item) {
            if(activeFilters.length > 0)
            {
                //console.log(item.values().category.trim());
                //console.log(filters_string);
                return(activeFilters.indexOf(item.values().category.trim())) > -1;
            }
            return true;
        });
     });





</script>

<!-- Defiant template -->
<script type="defiant/xsl-template">
    <xsl:template name="books_template">
        <xsl:for-each select="//movie">
            <xsl:value-of select="title"/><br/>
        </xsl:for-each>
    </xsl:template>
</script>

<script type="text/javascript">
var filters_string;
var data = {
        "pdfs": [
        <?php
        // WP_Query arguments
         $featured_id = get_field('featured_pdf');
        $args = array (
            'post_type'              => array( 'new_in_store' ),
            'pagination'             => false,
            'order'                  => 'DESC',
            'orderby'                => 'modified',
            'post__not_in' => array($featured_id),
            'posts_per_page' => -1,

        );
        // The Query
        $new_in_store_query = new WP_Query( $args );

        // The Loop
        if ( $new_in_store_query->have_posts() ) {
            while ( $new_in_store_query->have_posts() ) { $new_in_store_query->the_post();
    ?>
        {"id": "<?php echo get_the_id(); ?>",
         "img": "<?php the_field('thumbnail') ?>",
          "title": "<?php the_title() ?>"
           <?php $objTerms = wp_get_post_terms( get_the_id(), 'filters', array("fields" => "all") );
                            for ($j=0; $j < sizeof($objTerms); $j++) {
                                $ender = ',';
                                if($j == sizeof($objTerms)){ $ender = ""; };
                                echo ',"'.$objTerms[$j]->slug.'": true';
                            } 
                            ?>
    },
    <?php }
        } else {
                // no posts found
        }
            // Restore original Post Data
        wp_reset_postdata();
    ?>
          
        ]
    };
     jQuery('.filter').change(function() {
        // console.log(jQuery('.filter'));
        var filters = jQuery('.filter');
        var filters_string = "";
        for (var i =  0; i < filters.length; i++) {
            if(jQuery(filters[i]).is(":checked")){
            filters_string += '['+jQuery(filters[i]).val()+'=true]';
            }
        }
        console.log(filters_string);
    });


     search = JSON.search(data, '//pdfs'+filters_string);
     htm = Defiant.render('books_template', data);

console.log(data);

</script>


<?php endwhile; ?>
