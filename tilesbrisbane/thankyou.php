<?php 
session_start();
require( '../wordpress/wp-load.php' );
include('includes/prerun.php');
include('includes/connection.php');
include('includes/global_variables.php');
include('includes/requests.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                     <div class="clearfix white_bg">
                     <div class="thankyou">
                        <h2>Thank you</h2> 
                        <p>Your payment has been successfully completed.</p>
                        <a href="index.php" class="btn-red">Go to Home</a>
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

                </body>
            </html>