<?php
session_start();
require( '../wp-load.php' );
include('includes/prerun.php');
include('includes/connection.php');
include('includes/global_variables.php');
include('includes/requests.php');
require('../wp-blog-header.php');
include("class/watermark_image.class.php");
include("class/class.watermark.php");
include("includes/detail-db-call.php");
?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
    <head>
        <meta name="google-site-verification" content="aQXedls-hbPpeEDjYSu_ZRZC-Z_5Ty9KYbUeocNoxGE" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>The Tile Mob | Shop</title>
        <?php
                        include('includes/attach_styles.php'); //Cascading Style Sheets
                        include('includes/attach_scripts.php'); //Javascripts and scripts
        ?>
        <?php get_template_part('templates/head'); ?>
        <script language="javascript">
        function checkFields() {
            //alert("checking fields");
                emptyfields = "";
            if(document.getElementById('name').value == "") {
                emptyfields += "\n   Your name *";
            }
                if(document.getElementById('phone').value == "") {
                emptyfields += "\n   Your phone *";
            }
            if(document.getElementById('email').value == "") {
                emptyfields += "\n   Your e-mail *";
            }
            if(document.getElementById('enquiry').value == "") {
                emptyfields += "\n   Your message *";
            }
            if(document.getElementById('security').value=='') {
                emptyfields += "\n   Spam protection verification code *";
            }
            //alert("checking fields");
            if (emptyfields!="") { //mandatories not completed!
                alertmessage = "You've forgotten these fields:\n";
                alert(alertmessage+emptyfields);
                return false;
            } else { //all mandatories filled in!
                return true;
            }
        }
        function validate() {
            //alert("checking fields");
            emptyfields = "";
                if(document.getElementById('qty').value == '') {
                emptyfields += "\n   Quantity *";
            }
            if(document.getElementById('name1').value == '') {
                emptyfields += "\n   Your name *";
                    }
                if(document.getElementById('phone1').value == '') {
                emptyfields += "\n   Your phone *";
            }
            if(document.getElementById('email1').value == '') {
                emptyfields += "\n   Your e-mail *";
            }
            
            //alert("checking fields");
            if (emptyfields!="") { //mandatories not completed!
                alertmessage = "You've forgotten these fields:\n";
                alert(alertmessage+emptyfields);
                return false;
            } else { //all mandatories filled in!
                return true;
            }
        }
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
        // $(document).ready(function(){
                var arr = ['tab1','tab2','tab3','tab4'];
                $(".tbs").click(function(){
                    var id = $(this).attr('id');
                    $.each(arr , function(index, value){
                    if(value != id){
                    $("#"+value+"").addClass("tab_inactive");
                    $("#page4").hide();
                    
                    }
                    if(id == 'tab4'){
                    $("#page4").show();
                    }
                        });
                    })
            })
        </script>
        <script type="text/javascript">
            function keyuptime(){
            var qty =document.getElementById("item_order_qty").value;
                var productId = $("#productId").val();
                    var unit      = $("#unit").val();
                var item_M2Box = $("#item_M2Box").val();
                var datastring = 'productId='+productId+'&qty='+qty+'&item_M2Box'+item_M2Box+'&unit='+unit;
                ajxCall(datastring);
                
            //       $("#item_order_qty").focusout(function(){
                //        var qty = $(this).val();
                    //        var productId = $("#productId").val();
                //        var datastring = 'productId='+productId+'&qty='+qty+'&item_M2Box'+item_M2Box;
                //        ajxCall(datastring);
            //       })
                $("#item_order_qty").change(function(){
                var qty = $(this).val();
                    var productId = $("#productId").val();
                var datastring = 'productId='+productId+'&qty='+qty+'&item_M2Box'+item_M2Box+'&unit='+unit;
                ajxCall(datastring);
            })
            
            function ajxCall(datastring)
            {
                $.ajax
                ({
                type: "POST",
                url : "ajxPdtDetails.php",
                data: datastring,
                        dataType:"json",
                cache :false,
                success: function(res)
                {
                            // alert(res);
                            //$("#category").html(res.category);
                            $("#vboxes").html(res.valueBoxes);
                            $("#totlprice").html(res.totalprice);
                            $("#totprice").val(res.totalprice);
                            $("#totalm2").html(res.totalm2);
                            $("#totm2").val(res.totalm2);
                            $("#pdtunit").val(res.unit)  ;
                }
                })
            }
            ///////////////////// Add to cart /////////////////////////
            $("#additemtocart").click(function(event){
                    event.preventDefault();
                    var shop_user_id_encoded = $("#shop_user_id_encoded").val();
                        var shop_user_session    = $("#shop_user_session").val();
                            var shop_order_id        = $("#shop_order_id").val();
                                var item_Code            = $("#item_Code").val();
                                var pdtunit              = $("#pdtunit").val();
                        // var item_order_qty       = $("#item_order_qty").val();
                        var item_order_qty       = $("#totm2").val();
                                var item_id              = $("#item_id").val();
                            //  var totprice             = $("#totprice").val();
                    if(pdtunit == "M2")
                        {
                                var totprice             = $("#totprice").val();
                        }
                        if(pdtunit == "pcs")
                        {
                                var totprice             = $("#totprice").val();
                        }
                    var addToCart = addToCartPdtDetails(shop_user_id_encoded,shop_order_id,shop_user_session,item_Code,item_order_qty,item_id,totprice);
                    
                
            })
            ////////////////////////////////Image gallery //////////////////////////////
            $(".imggallery").click(function(){
                var src = $(this).attr("src");
                //alert(src);
                
                $(".galleryImg").attr("src",src);
                $(".lightbox").attr("href",src);
            })
            }
        </script>
        <style type="text/css">
        .price_rrp {
                                        padding-right: 15px;
                        position: relative;
                        display: block;
                        width: auto;
                        float: left;
                        font-size: 11px;
                        font-weight: normal;
                                    line-height: 130%;
                        text-align: left;
                        text-decoration: line-through;
                        color: #888888;
                    }
        </style>
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
                        <div class="col-xs-12 col-lg-3">
                            <?php include('includes/finder.php'); ?>
                            <?php include('includes/store-categories.php'); ?>
                            <?php include('includes/featured-products.php'); ?>
                        </div>
                        <div class="col-xs-12 col-lg-9">
                            <div id="item_detail" class="item_detail">
                                <!-- HEAD -->
                                <div id="goback" class="goback"><a href="javascript:history.go(-1);" title="Back to previous page">« Back to previous page</a></div>
                                <h1><?php echo $item_Desc.' <span>('.$item_Size_name.')</span>'; ?></h1>
                                <div id="details" class="details">
                                    <!-- PRICING, QTY and button -->
                                    <div id="pricing" class="pricing">
                                        <div id="price" class="price hide">$<?php echo number_format($item_buy,2).'<span>per '.$item_Unit.'</span>'; ?>
                                            <input type="hidden" name="defaultprice" id="defaultprice" value="<?=number_format($item_buy,2)?>"></input>
                                            <!--  <div class="price_buy">Buy $<?=number_format($item_buy,2)?><?=$item_unit?></div>
                                            <div class="price_rrp">RRP $<?=number_format($item_rrp,2)?><?=$item_unit?></div>
                                            <div class="price_save">SAVE $<?=number_format($item_save,2)?></div>
                                            <div class="clear"></div>--><br />
                                        <span class="lrg-qty-deal">Ask for LRG QTY deal!</span></div>
                                        <div id="calculation" class="calculation">
                                            <div id="item_qty" class="item_qty">
                                                <div id="label" class="label">Your order quantity:</div>
                                                <div id="field" class="field"><input type="text" id="item_order_qty" name="item_order_qty" value="0" class="textfield" onkeyup="keyuptime()">
                                                <input type="hidden" id="shop_user_id_encoded" name="shop_user_id_encoded" value=" <?=$_shop_user_id_encoded?>"></input>
                                                <input type="hidden" id="shop_order_id" name="shop_order_id" value=" <?=$_shop_order_id?>"></input>
                                                <input type="hidden" id="shop_user_session" name="shop_user_session" value="<?=$_shop_user_session?>"></input>
                                                <input type="hidden" id="item_Code" name="item_Code" value="<?=$item_Code?>"></input>
                                                <input type="hidden" id="item_id" name="item_id" value="<?=$item_id?>"></input>
                                                <input type="hidden" id="pdtunit" name="pdtunit"></input>
                                            </div>
                                            <div id="label" class="label"><?php echo $item_Unit; ?></div>
                                            <input type="hidden" id="productId" name="productId" value="<?=$id?>"></input>
                                            <input type="hidden" id="item_M2Box" name="item_M2Box" value="<?=$item_M2Box?>"></input>

                                            <div class="clear"></div>

                                        </div>
                                        <?php
                                                                                            if($unit == "pcs") {
                                        ?>
                                        <!--                                                    <div id="item_calculation" class="item_calculation">
                                            <?php if($item_PcsBox > 0){?>This order comes in <br/><b><span id="vboxes"></span> boxes</b> (<?=$item_PcsBox?> pcs per box) <br/>Total price = <b>$<span id="totlprice"></span></b><?php }?>
                                            <div class="clear"></div>
                                        </div>-->
                                        <div id="item_calculation" class="item_calculation hide">
                                            Total price = <b>$<span id="totlprice"></span></b>
                                            <div class="clear"></div>
                                        </div>
                                        <?php
                                                                                            }
                                                                                            else {
                                        ?>
                                        <div id="item_calculation" class="item_calculation hide">
                                            <?php if($item_M2Box!=0){?> This order comes in <br/><b><span id="vboxes"></span> boxes</b> (<?=$item_M2Box?> m2 per box)<br/><?php if($item_Unit_m2=="M2"){?>Total m2=<span id="totalm2"> </span><?php }?><br/>Total price = <b>$<span id="totlprice"></span></b><?php } ?><?php if($item_M2Box==0){?>Total price = <b>$<span id="totlprice"><?=number_format($item_buy,2)?></span></b><?php }?>
                                            <div class="clear"></div>
                                        </div>
                                        <?php
                                                                                            }
                                        ?>
                                        <div class="clear"></div>
                                    </div>
                                    <input type="hidden" name="totprice" id="totprice"></input>
                                    <input type="hidden" name="totm2" id="totm2"></input>
                                    <input type="submit" id="additemtocart" name="additemtocart" value="Add to cart" class="big_addtocart">
                                    <?php
                                                            //flag images
                                                            
                                                            if($item_Country == 'SPAIN')
                                                                            {
                                                                            $img_s='<img src="images/Spain.png" title="Spain"/>';
                                                                            }
                                                                            else if($item_Country == 'ITALY')
                                                                            {
                                                                                $img_s='<img src="images/Italy.png" title="Italy"/>';
                                                                            }
                                                            
                                                                
                                    ?>
                                    <div id="flag"><a href="#" ><?php echo $img_s ?></a></div>
                                    <div class="clear"></div>
                                </div>
                                <?php
                                                                        if($show_error_code){
                                                                            echo '<div id="msg">'.$show_error_code.'</div>';
                                                                        }else{
                                                                                                                        if($msg){
                                ?>
                                <div id="msg"><?=$msg?></div>

                                <?php
                                                                            }
                                                                        }
                                ?>
                                <?

                                ?>
                                <div class="clear"></div>
                                <div class="price_info hide">
                                    <div class="price_rrp">RRP $<?=number_format($item_rrp,2)?><?=$item_Unit?></div>
                                    <div class="price_save">SAVE $<?=number_format($item_save,2)?> per <?=$item_Unit?></div>
                                </div>
                                <div class="clear"></div>
                                <a href="javascript:void(0);" onclick="goToProductTab(4);" class="btnBQD"> <input type="button" value="BIG QUANTITY DEALS" id="lrgqtydeals" class="btn-red"><span class="tooltip hide">Need a large quantity of this item? Click this button and ask us for a deal!  We’ll tailor a price just for you and respond ASAP.<span class="arrow"></span></span></a>
                                <?php if($item_Notepad2<>""){
                                                                        
                                                                                $display   =   "style='display:block'";
                                                                                $ContentDisplay =  "style='display:none'";
                                                                                    $activeTab     = 'tab_inactive';
                                                                        }else{
                                                                                $display   =   "style='display:none'";
                                                                                $ContentDisplay = "style='display:block'";
                                                                                $activeTab = 'tab';
                                } ?>
                                <div class="col-xs-12 padding-zero">
                                <!-- TABS -->
                                    <div id="tabs" class="tabs">
                                        <div id="tab1" class="tab tbs" <?php echo $display; ?> ><a href="javascript:void(0);" onclick="goToProductTab(1);" title="OVERVIEW">OVERVIEW</a></div>
                                        <div id="tab2" class="<?php echo $activeTab; ?> tbs"><a href="javascript:void(0);" onclick="goToProductTab(2);" title="SPECS">SPECS</a></div>
                                        <div id="tab3" class="tab_inactive tbs"><a href="javascript:void(0);" onclick="goToProductTab(3);" title="ASK A QUESTION">ASK A QUESTION</a></div>
                                        <!-- <div id="tab4" class="tab_inactive tbs"><a href="javascript:void(0);" onclick="goToProductTab(4);" title="BIG QUANTITY DEALS">BIG QTY DEALS</a></div> -->

                                        <div class="clear"></div>
                                    </div>
                                    <!-- OVERVIEW -->
                                    <div id="page1" class="page">
                                        <div id="description" class="description">
                                            <?php echo nl2br($item_Notepad2); ?>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <!-- SPECS -->
                                    <div id="page2" class="page"  <?php echo $ContentDisplay; ?> style="display:none;">
                                        <table id="details_table" width="100%" class="details_table">
                                            <tr>
                                                <td colspan="4"><h3><?php echo $item_Heading_name; ?></h3></td>
                                            </tr>
                                            <?php if($item_Code){?>
                                            <tr>
                                                <td width="100"><span>Code</span></td>
                                                <td colspan="3"><?php echo $item_Code; ?></td>
                                            </tr>
                                            <?php }?>
                                            <?php if($item_Size_name){?>
                                            <tr>
                                                <td><span>Size</span></td>
                                                <td colspan="3"><?php echo $item_Size_name; ?></td>
                                            </tr>
                                            <?php } ?>
                                            <?php if($item_Thickness_name){?>
                                            <tr>
                                                <td><span>Thickness</span></td>
                                                <td colspan="3"><?php echo $item_Thickness_name; ?></td>
                                            </tr>
                                            <?php } ?>
                                            <?php if($item_Colour_name){?>
                                            <tr>
                                                <td><span>Colour</span></td>
                                                <td colspan="3"><?php echo $item_Colour_name; ?></td>
                                            </tr>
                                            <?php }?>
                                            <!--<tr>
                                                                                <td style="padding-top:15px;"><span>Price</span></td>
                                                                                                            <td colspan="3" style="padding-top:15px;">
                                                    <div class="price_buy">$<?php echo number_format($item_buy,2).'/'.$item_Unit; ?></div>
                                                    <div class="item_qty">
                                                        Your Order Quantity:
                                                        <input type="text" id="add_qty" name="add_qty" value="1" class="textfield1" onchange="checkAddQtyValue('<?php echo $item_buy; ?>','<?php echo $item_M2Box; ?>',this.value);"> <?php echo $item_Unit; ?>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div id="addtocart_button_<?php echo $item_id; ?>" class="button"><a href="javascript:void(0);" title="add to cart" onclick="addToCart('<?php echo $_shop_user_id_encoded ?>','<?php echo $_shop_user_session; ?>','<?php echo $item_Code; ?>', document.getElementById('add_qty').value,'<?php echo $item_id; ?>');">add to cart</a></div>
                                                    <div id="addtocart_feedback_<?php echo $item_id; ?>" class="feedback">Item added to cart</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span>Normally</span></td>
                                                <td colspan="3">
                                                    <div class="price_rrp">$<?php echo number_format($item_rrp,2).'/'.$item_Unit; ?></div>
                                                    <div class="price_save">SAVE $<?php echo number_format($item_save,2); ?></div>
                                                </td>
                                            </tr>-->
                                            <?php if($item_Surface_name){?>
                                            <tr>
                                                <td><span>Finish</span></td>
                                                <td colspan="3"><?php echo $item_Surface_name; ?></td>
                                            </tr>
                                            <?php }?>
                                            <?php if($item_Material_name){?>
                                            <tr>
                                                <td><span>Material</span></td>
                                                <td colspan="3"><?php echo $item_Material_name; ?></td>
                                            </tr>
                                            <?php }?>
                                            <?php if($item_SlipRating_name != ""){?>
                                            <tr>
                                                <td><span>Slip-Rating</span></td>
                                                <td colspan="3"><?php echo $item_SlipRating_name; ?></td>
                                            </tr>
                                            <?php }?>
                                            <?php if($item_Use_name){?>
                                            <tr>
                                                <td><span>Category/Use</span></td>
                                                <td colspan="3"><?php echo $item_Use_name; ?></td>
                                            </tr>
                                            <?php }?>
                                            <?php if($item_RelatedTo_name){?>
                                            <tr>
                                                <td><span>Collection</span></td>
                                                <td colspan="3"><?php echo $item_RelatedTo_name; ?></td>
                                            </tr>
                                            <?php }?>
                                            <?php if($item_Pattern_name){?>
                                            <tr>
                                                <td><span>Pattern</span></td>
                                                <td colspan="3"><?php echo $item_Pattern_name; ?></td>
                                            </tr>
                                            <?php }?>
                                            <?php
                                                                        if(!empty($item_Pantone_name)) {
                                                                            echo '
                                                                            <tr>
                                                                                    <td><span>Pantone</span></td>
                                                                                    <td colspan="3">'.$item_Pantone_name.'</td>
                                                                            </tr>';
                                                                        }
                                            ?>
                                            <?php if($item_Edge_name){?>
                                            <tr>
                                                <td><span>Edge Finish</span></td>
                                                <td colspan="3"><?php echo $item_Edge_name; ?></td>
                                            </tr>
                                            <?php }?>
                                            <?php if($item_Weight_name){?>
                                            <!--                            <tr>
                                                                                <td><span>Weight</span></td>
                                                <td colspan="3"><?php echo $item_Weight_name; ?></td>
                                            </tr>-->
                                            <?php }?>
                                            <?php // if($item_PcsBox!="" && $item_PcsBox!=0){
                                                                                                if($item_PcsM2!="" && $item_PcsM2!=0){
                                                                                                
                                            ?>
                                            <tr>
                                                <td><span>Box Size</span></td>
                                                <td><?php echo $item_PcsBox; ?>
                                                    <?php
                                                                                    
                                                                                        echo '
                                                                                        pcs / '.$item_M2Box.' '.$item_Unit_m2.' ('.$item_PcsBox.' pcs per '.$item_Unit_m2.')';
                                                                                        
                                                                                    
                                                ?></td>
                                            </tr>
                                            <?php }?>
                                            <?php if($item_M2Pallet){?>
                                            <tr>
                                                <td><span>Pallet Size</span></td>
                                                <td colspan="3"><?php echo $item_M2Pallet.'m&sup2; ('.$item_BoxesPallet.' Boxes)'; ?></td>
                                            </tr>
                                            <?php }?>
                                            <?php { ?>
                                            <tr>
                                                <td><span>Ships From</span></td>
                                                <td colspan="3"><?php echo $item_Location_name; ?></td>
                                            </tr>
                                            <?php }?>
                                            <tr>
                                                <td ><span>Lead Time to Despatch Order:</span> </td>
                                                <td colspan="3"><?php echo $item_lead; ?> Days (approx.)</td>
                                            </tr>
                                        </table>
                                        <div class="clear"></div>
                                    </div>
                                    <!-- ASK A QUESTION -->
                                    <div id="page3" class="page" style="display:none;">
                                        <form action ="" method ="post" enctype="multipart/form-data" onsubmit="return checkFields();">
                                            <table class="form-listing">
                                                <tr><td width="30%" >Name:</td><td width="70%"><input type="text" name="name" id="name" class="textfield1"></input></td></tr>
                                                <tr><td>Phone:</td><td><input type="text" name="phone" id="phone" class="textfield1"></input></td></tr>
                                                <tr><td>Email:</td><td><input type="text" name="email" id="email" class="textfield1"></input></td></tr>
                                                <tr><td>Enquiry:</td><td><textarea name="enquiry" id="enquiry" class="textfield1"></textarea></td></tr>
                                                <tr><td>Spam protection:</td><td>Please verify that you are human by entering this code into the field before submitting: <span class="asterisk">*</span>
                                                <img src="randomImage.php" border="0" align="absmiddle"/><br /><input type="text" name="security" id="security" class="textfield1" style="width:100px;margin-top:3px;"/>
                                            </td></tr>
                                            <input type ="hidden" name="pdtId" id="pdtId" value="<?=$id?>"></input>
                                            <tr><td>&nbsp;</td><td><input type="submit" name="submit" id="submit" value="Send"></input></td></tr>
                                        </table>
                                    </form>
                                    <div class="clear"></div>
                                    </div>
                                    <!--- DEAL QTY -->
                                    <div id="page4" class="page" style="display:none;">
                                        <form action ="" method ="post" enctype="multipart/form-data" onsubmit="return validate();">
                                            <table class="form-listing">
                                                <tr ><td width="30%">ProductDetails:</td><td width="70%"><textarea class="textfield1" disabled><?=$productDesc?></textarea>
                                                <input type="hidden" id="desc" name="desc" value="<?=$productDesc?>">
                                                </td></tr>
                                                <tr><td>Quantity:</td><td><input type="text" name="qty" id="qty" class="textfield1"></input></td></tr>
                                                <tr><td>Name:</td><td><input type="text" name="name" id="name1" class="textfield1"></input></td></tr>
                                                <tr><td>Phone:</td><td><input type="text" name="phone" id="phone1" class="textfield1"></input></td></tr>
                                                <tr><td>Email:</td><td><input type="text" name="email" id="email1" class="textfield1"></input></td></tr>
                                                <tr><td>Spam protection:</td><td>Please verify that you are human by entering this code into the field before submitting: <span class="asterisk">*</span>
                                                <img src="randomImage.php" border="0" align="absmiddle"/><br /><input type="text" name="security" id="security" class="textfield1" style="width:100px;margin-top:3px;"/>
                                                </td></tr>
                                                <input type ="hidden" name="pdtId" id="pdtId" value="<?=$id?>"></input>
                                                <tr><td>&nbsp;</td><td><input type="submit" name="submit" id="submit" value="Submit"></input></td></tr>
                                            </table>
                                        </form>
                                        <h4>Need a large quantity of this item? Fill out this enquiry form and ask us for a deal! We’ll tailor a price just for you and respond ASAP.  You can also call us on 0419 774 758.</h4>
                                        <div class="clear"></div>
                                    </div>
                                </div>        
                </div>
                <div id="image" class="image">
                    <!-- image -->   
                        <?php if($image1){?><a href="<?php echo $image1; ?>" title="<?php echo $item_Desc; ?>" class="lightbox"><?php }?><?php echo $image1_imgsrc; ?><?php if($image1){?></a><?php }?>
                        <div id="enlarge_image" class="enlarge_image"><?php if($image1){?><a href="<?php echo $image1; ?>" title="<?php echo $item_Desc; ?>" class="lightbox">Enlarge image</a><?php }?></div>
                        <div class="clear"></div>
                        <ul class="thumb-list">
                            <?php if(count($item_images)>=2){
                                                    foreach($item_images as $secImages) {
                            ?>

                            <li><a href="javascript:void(0);" class="lightbox"><img src="images/items/watermarked/<?=$secImages?>" class="imggallery"/></a></li>
                            <?php }}?>
                            <!--<li><a href="#"><img src="images/items/TMW1524.JPG"/></a></li>
                                                    <li><a href="#"><img src="images/items/TMW1524.JPG"/></a></li>
                                                    <li><a href="#"><img src="images/items/TMW1524.JPG"/></a></li>
                            <li><a href="#"><img src="images/items/TMW1524.JPG"/></a></li>-->
                        </ul>
                    </div>

                    <!-- Product variations -->
                <div id="product_variations" class="product_variations">
                    <h1>Product Variations</h1>
                    <div id="related_products" class="related_products" style="display:block;">
                    <h2>Related products to <?php echo $item_Desc; ?></h2>
                    <div class="list">
                    <?php 
                    $related_string = '';
//                                        $sql = "SELECT sw.*,MATCH(sw.Desc) AGAINST ('\"$item_Desc\"' IN BOOLEAN MODE) AS relevance FROM shop_webitems as sw WHERE sw.RelatedTo='$item_RelatedTo' AND sw.Colour='$item_Colour' AND sw.Surface='$item_Surface' AND sw.item_id!='$item_id' AND sw.WebExport='YES' AND sw.is_active='1' GROUP BY sw.Size ORDER BY relevance DESC LIMIT 0, 24";
                                         $sql = "SELECT sw.*,MATCH(sw.Desc) AGAINST ('\"$item_Desc\"' IN BOOLEAN MODE) AS relevance FROM shop_webitems as sw WHERE sw.RelatedTo='$item_RelatedTo' AND sw.Colour='$item_Colour' AND sw.Surface='$item_Surface' AND sw.item_id!='$item_id' AND sw.WebExport='YES' AND sw.is_active='1' ORDER BY relevance DESC LIMIT 0, 24";
                                        $result_related = mysql_query($sql);
//                                        while($row_related=mysql_fetch_array($result_related)) {
//                                         echo "Here <pre/>";   print_r($row_related);
//                                        }
                                       
                                        //echo $result_related;
                    $total_related=mysql_num_rows($result_related);
                                        //echo $total_related;
                                      
                    
                    if($total_related>0) {
                        while($row_related=mysql_fetch_array($result_related)) {
//                                                  echo "<pre/>";  print_r($row_related);
                                                $item_size = $row_related['Size'];
                        $result_size_check = mysql_query("SELECT * FROM shop_size WHERE Code='$item_size' AND is_active='1'");
                        if($row_size_check = mysql_fetch_array($result_size_check)) {
                            $item_display_size = $row_size_check['Description'];
                        } else { $item_display_size=''; }
                            $this_id = $row_related['item_id'];
                                                        $relatedProducts[] = $row_related['item_id'];
                            $item_name = $row_related['Desc'];
                                                        /////////////////// Newly added //////////////////////////
                            $item_pcsm2 = floatval($row_related['PcsM2']);
                        $item_unit = $row_related['Unit'];
                        if($item_pcsm2>0 && $item_pcsm2!=''){ //sell in m2
                            $item_webpricem2 = $row_related['WebPriceM2'];
                            $item_retailpricem2 = $row_related['RetailPriceM2'];
                            if(!empty($item_webpricem2)) {
                                $item_buy = floatval($item_webpricem2);
                            } else { //if web price value does not exist, use 20% off from retail price
                                $item_web_discount_amount = floatval($item_retailpricem2)*0.2; //20% of retail price
                                $item_buy = floatval($item_retailpricem2)-$item_web_discount_amount;
                            }
                                                    
                            $item_rrp = floatval($item_retailpricem2);
                            $item_unit='m&sup2;';
                        } 
                                                /////////////////////////////////////////////Newly added for pcs price caluculation///////////////////////////////////
                
//                if($item_pcsm2==0&&$item_unit=='PCS'){ 
//                        if(!empty($item_webpricem2)) {
//                                $item_buy = floatval($item_webpricem2);
//          } else { //if web price value does not exist, use 20% off from retail price
//                                  $item_web_discount_amount = floatval($item_RetailPricePce)*0.2; //20% of retail price
//              $item_buy = floatval($item_RetailPricePce)-$item_web_discount_amount;
//          }
//                        $item_retailpricem2 = $row_related['RetailPriceM2'];
//          $item_rrp = floatval($item_retailpricem2);
//          $item_unit='pcs';
//      }
                                                if($item_pcsm2==0 ||  $item_pcsm2 =='')
                                                { 
                                                    $item_WebPricePce = $row_related['WebPricePce'];
                                                    $item_RetailPricePce = $row_related['RetailPricePce'];
                                                    if(!empty($item_WebPricePce)) 
                                                    {
                                                       $item_buy = floatval($item_WebPricePce);
                                                    } 
                                                    else 
                                                    { //if web price value does not exist, use 20% off from retail price
                                                        $item_web_discount_amount = floatval($item_RetailPricePce)*0.2; //20% of retail price
                                                        $item_buy = floatval($item_RetailPricePce)-$item_web_discount_amount;
                                                    }
//                                                    $item_retailpricem2 = $row_related['RetailPriceM2'];
                                                    $item_rrp = floatval($item_RetailPricePce);
                                                    $item_unit='pcs';
                                                }
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        $item_save = $item_rrp-$item_buy;
                        if($item_save<0){$item_buy=0.00;}
                        $item_images = unserialize($row_related['images']);
                        $images_dir = 'images/items/';
                        $image1 = $image1_imgsrc = '';
                        $image1 = $images_dir.$item_images[0];
                            if(is_file($image1)) {
                                $image1_imgsrc = '<img src="'.$image1.'" alt="'.$item_name.'" border="0" />';
                            } else {
                                $image1_imgsrc = '<img src="images/blank.gif" alt="'.$item_name.'" border="0" />';
                            }
                            
                                                //*****Flag Images****
                                      
                                        if($row_related['Country']=='SPAIN')
                                        {
                                            $img_s='<img src="images/Spain.png" title="Spain"/>';
                                        }
                                        else if($row_related['Country']=='ITALY')
                                        {
                                            $img_s='<img src="images/Italy.png" title="Italy"/>';
                                        }
                                        
                                        //*****Flag Images****         
                                                      $related_string .= '<div class="thumb">
    <div class="thumbnail"><a href="detail.php?id='.$this_id.'" title="'.$item_name.'">'.$image1_imgsrc.'</a></div>
    <div class="thumb-details">
    <div class="size">'.$item_display_size.'</div>
    <div class="code">'.$row_related['Code'].'</div>
    <div class="name"><a href="detail.php?id='.$this_id.'" title="More info">'.$row_related['Desc'].'</a></div>
    <div class="price_info hide">
    <div class="price_buy">Buy $'.number_format($item_buy,2).''.$item_unit.'</div>
    <div class="price_rrp">RRP $'.number_format($item_rrp,2).''.$item_unit.'</div>
    <div class="price_save">SAVE $'.number_format($item_save,2).''.$item_unit.'</div>
             <div><a href="#" >'.$img_s.'</a></div>
    <div class="clear"></div>
    </div>                          
<div class="clear"></div>
</div>  
</div>';



                        }
                    }
                    echo $related_string;
                    ?>
                    </div>
                    <div class="clear"></div>
                </div>
                                        
                    <div id="related_products" class="related_products" style="display:block;">
                    <h2>Other products you might like</h2>
                    <div class="list">
                    <?php 
                    //related by use
                    $related_string = '';
                                        // echo "SELECT DISTINCT * FROM shop_webitems WHERE `RelatedTo`='$item_RelatedTo' AND item_id!='$item_id' AND WebExport='YES' AND is_active='1' GROUP BY Colour,Surface,size ORDER BY Size DESC LIMIT 0, 24";
                                        // $sql = "SELECT * FROM shop_webitems WHERE `RelatedTo`='$item_RelatedTo' AND Colour='$item_Colour' AND Surface='$item_Surface' AND item_id!='$item_id' AND WebExport='YES' AND is_active='1' GROUP BY Size ORDER BY Size DESC LIMIT 0, 24";
                                        // $sql = "SELECT DISTINCT * FROM shop_webitems WHERE `RelatedTo`='$item_RelatedTo' AND item_id!='$item_id' AND WebExport='YES' AND is_active='1' GROUP BY Colour,Surface,size ORDER BY Size DESC LIMIT 0, 24"
                    //$result_related = mysql_query($sql);
                                        //echo $item_RelatedTo;
                                        //$sql = "SELECT sw.* FROM shop_webitems as sw WHERE sw.RelatedTo='$item_RelatedTo' AND sw.Colour!='$item_Colour' OR sw.Surface!='$item_Surface' AND sw.item_id!='$item_id' AND sw.WebExport='YES' AND sw.is_active='1' GROUP BY sw.Size LIMIT 0, 24";
                                        //print_r($relatedProducts);
                                        if(count($relatedProducts))
                                        {
                                            $relatedProducts = implode(',',$relatedProducts);
                                        }
                                        //$sql = "SELECT * FROM shop_webitems WHERE RelatedTo='$item_RelatedTo' AND  item_id NOT IN($relatedProducts) ORDER BY Size DESC LIMIT 0, 24";
                                        $sql = "SELECT * FROM shop_webitems WHERE RelatedTo='$item_RelatedTo' AND item_id !='$item_id' ";
                                        if($relatedProducts!="")
                                        {
                                            $sql .= "AND  item_id NOT IN($relatedProducts) ORDER BY Size DESC LIMIT 0, 24";
                                        }
                                        //echo $sql;
                                        $result_related = mysql_query($sql);
                    $total_related=mysql_num_rows($result_related);
                                       
                    /*if($total_related==0) {
                        $result_related = mysql_query("SELECT * FROM shop_webitems WHERE `Use`='$item_Use' AND item_id!='$item_id' AND WebExport='YES' AND is_active='1' ORDER BY RAND() LIMIT 0, 24");
                        $total_related=mysql_num_rows($result_related);
                    }*/
                    if($total_related>0) 
                                        {
                                            while($row_related=mysql_fetch_array($result_related)) 
                                            {
//                                               echo "<pre/>"; print_r($row_related);
                                                $this_id = $row_related['item_id'];
                        $item_name = $row_related['Desc'];
                        $item_pcsm2 = floatval($row_related['PcsM2']);
                        $item_unit = $row_related['Unit'];
                                                 //****by*****
                                                $item_size=$row_related['Size'];
                                                //**********added By********
                                                $result_size_check1 = mysql_query("SELECT * FROM shop_size WHERE Code='$item_size' AND is_active='1'");
                        if($row_size_check1 = mysql_fetch_array($result_size_check1)) 
                                                {
                                                    $item_display_size1 = $row_size_check1['Description'];
                        } 
                                                else 
                                                { 
                                                    $item_display_size1=''; 
                                                    
                                                }
                                                  //*****Flag Images****
                                      
                                        if($row_related['Country']=='SPAIN')
                                        {
                                            $img_s='<img src="images/Spain.png" title="Spain"/>';
                                        }
                                        else if($row_related['Country']=='ITALY')
                                        {
                                            $img_s='<img src="images/Italy.png" title="Italy"/>';
                                        }
                                        //*****Flag Images****       
                                                //**********by*******
                        if($item_pcsm2>0&&$item_unit=='M2')
                                                { //sell in m2
                                                    $item_webpricem2 = $row_related['WebPriceM2'];
                                                    $item_retailpricem2 = $row_related['RetailPriceM2'];
                                                    if(!empty($item_webpricem2)) 
                                                    {
                                                        $item_buy = floatval($item_webpricem2);
                                                    } 
                                                    else 
                                                    { //if web price value does not exist, use 20% off from retail price
                                                        $item_web_discount_amount = floatval($item_retailpricem2)*0.2; //20% of retail price
                            $item_buy = floatval($item_retailpricem2)-$item_web_discount_amount;
                                                    }
                                                    
                                                    $item_rrp = floatval($item_retailpricem2);
                                                    $item_unit='m&sup2;';
                        } 
                                                /////////////////////////////////////////////Newly added for pcs price caluculation///////////////////////////////////
                
                                                if($item_pcsm2==0&&$item_unit!='M2')
                                                { 
                                                    $item_WebPricePce = $row_related['WebPricePce'];
                                                    $item_RetailPricePce = $row_related['RetailPricePce'];
                                                    if(!empty($item_webpricem2)) 
                                                    {
                                                       $item_buy = floatval($item_WebPricePce);
                                                    } 
                                                    else 
                                                    { //if web price value does not exist, use 20% off from retail price
                                                        $item_web_discount_amount = floatval($item_RetailPricePce)*0.2; //20% of retail price
                                                        $item_buy = floatval($item_RetailPricePce)-$item_web_discount_amount;
                                                    }
                                                    $item_retailpricem2 = $row_related['RetailPriceM2'];
                                                    $item_rrp = floatval($item_RetailPricePce);
                                                    $item_unit='pcs';
                                                }
                                                
                                                
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        $item_save = $item_rrp-$item_buy;
                        if($item_save<0)
                                                {
                                                    $item_buy=0.00;
                                                
                                                }
                        $item_images = unserialize($row_related['images']);
                        $images_dir = 'images/items/';
                        $image1 = $image1_imgsrc = '';
                        $image1 = $images_dir.$item_images[0];
                        if(is_file($image1)) 
                                                {
                                                    $image1_imgsrc = '<img src="'.$image1.'" alt="'.$item_name.'" border="0" />';
                        } 
                                                else 
                                                {
                                                    $image1_imgsrc = '<img src="images/blank.gif" alt="'.$item_name.'" border="0" />';
                        }
                            /*$related_string .= '
                            <div id="thumb'.$this_id.'" class="thumb">
                                <div class="thumbnail"><a href="detail.php?id='.$this_id.'" title="'.$item_name.'">'.$image1_imgsrc.'</a></div>
                                <div class="clear"></div>
                            </div>';*/
                                                $related_string .= 
                                                         '<div class="thumb">
                                                                <div class="thumbnail"><a href="detail.php?id='.$this_id.'" title="'.$item_name.'">'.$image1_imgsrc.'</a></div>
                                                                <div class="thumb-details">
                                                                    <div class="size">'.$item_display_size1.'</div>
                                                                    <div class="code">'.$row_related['Code'].'</div>
                                                                    <div class="name"><a href="detail.php?id='.$this_id.'" title="More info">'.$row_related['Desc'].'</a></div>
                                                                        <div class="price_info hide">
                                                                            <div class="price_buy">Buy $'.number_format($item_buy,2).''.$item_unit.'</div>
                                                                            <div class="price_rrp">RRP $'.number_format($item_rrp,2).''.$item_unit.'</div>
                                                                            <div class="price_save">SAVE $'.number_format($item_save,2).''.$item_unit.'</div>
                                                                                <div><a href="#" >'.$img_s.'</a></div>
                                                                            <div class="clear"></div>
                                                                        </div>                          
                                                                        <div class="clear"></div>
                                                                </div>
                                                        </div>';
                        }
                    }
                    echo $related_string;
                    ?>
                    </div>
                    <div class="clear"></div>
                </div>
                    <div class="clear"></div>
                </div>

                
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