<?php
session_start();
require( '../wp-load.php' );
include('includes/prerun.php');
include('includes/connection.php');
include('includes/global_variables.php');
include('includes/requests.php');
$result_webitems = mysql_query("SELECT *, WebPricePce, TradePricePce, (WebPricePce+TradePricePce) as pricesum FROM shop_webitems WHERE WebExport='YES' AND is_active='1' ORDER BY RAND() LIMIT 0,20") or die(mysql_error());
?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
    <head>
        <meta name="google-site-verification" content="aQXedls-hbPpeEDjYSu_ZRZC-Z_5Ty9KYbUeocNoxGE" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <?php
                include('includes/attach_styles.php'); //Cascading Style Sheets
                include('includes/attach_scripts.php'); //Javascripts and scripts
        ?>
        <?php get_template_part('templates/head'); ?>
    </head>
    <body class='grey_bg' ?>>
        <!--[if lt IE 9]>
            <div class="alert alert-warning">
            <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
        </div>
        <![endif]-->
        <?php
            do_action('get_header');
            get_template_part('templates/header');
        ?>
        <div class="wrap container" role="document">
            <div class="content row">
              
                    <main class="main" role="main">
                         <?php include('includes/shop-navigation.php'); ?>
                     <div class="clearfix white_bg">
                     
                     <div class="col-lg-3">
                     	 <?php include('includes/finder.php'); ?>
                        <?php include('includes/store-categories.php'); ?>
                        <?php include('includes/featured-products.php'); ?>
                     </div>
                     <div class="col-lg-9">
                        <?php include('includes/slider.php') ?>
                        <?php include('includes/product-slider.php') ?>
                        </div>
                    </div>
                    </main><!-- /.main -->
                    </div><!-- /.content -->
                    <?php
                        do_action('get_footer');
                        get_template_part('templates/footer');
                        wp_footer();
                    ?>
                    </div><!-- /.wrap -->
                    <?php
                        $flag = htmlspecialchars($_GET["f"]);
                        // echo "the flag is ".$flag." !!";
                        if($flag=='search') {
                            // echo "entered";
                    ?>
                        <script type="text/javascript">
                        moreTileFinderOptions();
                        </script>
                    <?php
                        }
                    ?>
                </body>
            </html>