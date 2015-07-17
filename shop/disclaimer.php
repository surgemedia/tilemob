<?php 
session_start();
require( '../wp-load.php' );
include('includes/prerun.php');
include('includes/connection.php');
include('includes/global_variables.php');
include('includes/requests.php');

$result_content = mysql_query("SELECT * FROM shop_content WHERE pageurl='$_pageurl' AND is_active='1'");
if($row_content = mysql_fetch_array($result_content)) {
	$content_id = $row_content['content_id'];
	$heading1 = $row_content['heading1'];
	$is_multicolumn = $row_content['is_multicolumn'];
	$indent_body2 = $row_content['indent_body2'];
	$body1 = str_replace("\'", "'", $row_content['body1']);
	$body1 = str_replace('\"', '"', $body1);
	$body2 = str_replace("\'", "'", $row_content['body2']);
	$body2 = str_replace('\"', '"', $body2);
	$metatitle = $row_content['metatitle'];
	$menulinkname = $row_content['menulinkname'];
	$pageurl = $row_content['pageurl'];
} else {
	header('location:index.php');
}
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
                     <div class="col-lg-4">
            <?php include('includes/finder.php'); ?>
            <?php include('includes/store-categories.php'); ?>
                        <?php include('includes/featured-products.php'); ?>
                     </div>
                    <div class="col-lg-8">
                <?php 
                $string = '<h1>'.$heading1.'</h1>';
                if($is_multicolumn==1) {
                    if($indent_body2==1){$require_indent_style='<div class="indent_body2"></div>';}else{$require_indent_style='';}
                    $string .= '
                    <div id="col1" class="col1">
                        '.$body1.'
                    </div>
                    <div id="col2" class="col2">
                        '.$require_indent_style.'
                        '.$body2.'
                    </div>';
                } else {
                    $string .= $body1;
                }
                echo $string;
                ?>
            
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