<div id="logo" class="logo"><a href="index.php" title="Home"></a></div>
<div id="headlinks" class="headlinks">
	<ul>
		<!--<li style="border:0;"><a href="my-account.php" title="My account">My account</a></li>-->
		<?php 
		if($_shop_total_cart>0) {
			echo '<li><a href="my-cart.php" title="My cart"><b>My cart (<span id="header_cart_items">'.$_shop_total_cart.'</span> items)</b></a></li>';
		} else { echo '<li><a href="my-cart.php" title="My cart">My cart (<span id="header_cart_items">0</span> items)</a></li>'; }
		?>		
		<li><a href="checkout.php" title="Checkout" style="border:0;">Checkout »</a></li>
	</ul>
	<div class="clear"></div>
</div>
<div id="enquiries" class="enquiries">ENQUIRIES <BR/><span>0419 774 758</span><br />
7 DAYS</div>
<?php include('includes/navigation.php'); ?>
<?php include('includes/subnavigation.php'); ?>


<!-- Google Code for Remarketing Tag -->

<!--------------------------------------------------

Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup

--------------------------------------------------->

<script type="text/javascript">

/ <![CDATA[ /

var google_conversion_id = 962078793;

var google_custom_params = window.google_tag_params;

var google_remarketing_only = true;

/ ]]> /

</script>

<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">

</script>

<noscript>

<div style="display:inline;">

<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/962078793/?value=0&amp;guid=ON&amp;script=0"/>

</div>

</noscript>