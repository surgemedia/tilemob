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
