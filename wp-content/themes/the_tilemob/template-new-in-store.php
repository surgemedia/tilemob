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
            <input id="searchInput" class="search" type="text" placeholder="Please input the keywords related">
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
             <script>
                 console.log(<?php print_r($terms) ?>);
             </script>
             <?php for ($i=0; $i < sizeof($terms); $i++) { ?>
                <li class="col-sm-12">
                   <div class="checkbox ">
                    <label>
                    <?php 
                   if(!is_array($terms[$i])){
                       $terms[$i] = json_decode(json_encode($terms[$i]), true);
                    };
                    //debug($terms[$i]); ?>
                      <input id="" type="checkbox" class="filter" value="<?php echo $terms[$i]['slug']; ?>"> <?php echo $terms[$i]['name']; ?>
                    </label>
                  </div>
                </li>
            <?php }; ?>
            </ul>
          
        </div>
        <script>
            
        </script>
    </section>

    <ul id="all_pdfs" class="list col-md-8">
    </ul>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/defiant.js/1.4.0/defiant.min.js"></script>

<!-- Defiant template -->
<script type="defiant/xsl-template">
    <xsl:template name="books_template">
        <xsl:for-each select="//pdfs">
        <li class=" {colclass} ">
                    <div class="pdf-object {is_featured}">
                        <a target="_blank" href="{property_image}">
                            <img src="{img}" alt="" />
                            <span class="title"><xsl:value-of select="title"/></span>
                        </a>
                    </div>
                </li>
        </xsl:for-each>
    </xsl:template>
</script>

<script type="text/javascript">
var filters_string;
var data = {

        "pdfs" : [
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
        {
        "is_featured": "featured",
         "colclass": "col-sm-6",
         "img": "<?php the_field('thumbnail') ?>",
          "title": "<?php the_title() ?>"
           <?php $objTerms = wp_get_post_terms( get_the_id(), 'filters', array("fields" => "all") );
                            for ($j=0; $j < sizeof($objTerms); $j++) {
                                $ender = ',';
                                if($j == sizeof($objTerms)){ $ender = ""; };
                                echo ',"'.$objTerms[$j]->slug.'": "true"';
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
        {
        "is_featured": "",
        "colclass": "col-sm-3",
         "img": "<?php the_field('thumbnail') ?>",
          "title": "<?php the_title() ?>"
           <?php $objTerms = wp_get_post_terms( get_the_id(), 'filters', array("fields" => "all") );
                            for ($j=0; $j < sizeof($objTerms); $j++) {
                                $ender = ',';
                                if($j == sizeof($objTerms)){ $ender = ""; };
                                echo ',"'.$objTerms[$j]->slug.'": "true"';
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
    function tagObj(json){
  var arr = [];
     jQuery.each(json, function (i, jsonSingle) {
            arr.push({
                pdfs: jsonSingle
            });
      });           

        return arr; 
    }
    var filters_string = "";
    var htm = Defiant.render('books_template', data);
    document.getElementById('all_pdfs').innerHTML = htm;
     jQuery('.filter').change(function() {
        var filters_string = "";
        var htm = Defiant.render('books_template', data);
        document.getElementById('all_pdfs').innerHTML = htm;
        var filters = jQuery('.filter');
        filters_string = "";
        for (var i =  0; i < filters.length; i++) {
            if(jQuery(filters[i]).is(":checked")){
            filters_string += '['+jQuery(filters[i]).val()+'="true"]';
            }
        }
        var search = JSON.search(data, '//*'+filters_string);
        if(this.checked){
        document.getElementById('all_pdfs').innerHTML = Defiant.render('books_template', tagObj(search));
        }
    });
    jQuery('#searchInput').keydown(function() {
      
        var filters_string = '[contains(title,"'+jQuery('#searchInput').val()+'")]';
        console.log(filters_string);
        var search = JSON.search(data, '//*'+filters_string);
        console.log(search.length);
        if(search.length > 0){
        document.getElementById('all_pdfs').innerHTML = Defiant.render('books_template', tagObj(search));
        }
    });
    jQuery('#searchInput').focusout(function() {
    if(jQuery('#searchInput').val().length <= 0){
    var htm = Defiant.render('books_template', data);
    document.getElementById('all_pdfs').innerHTML = htm;
    }
    });




</script>


<?php endwhile; ?>
