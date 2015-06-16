<?php
session_start();
$rand_chars = array('1','2','3','4','5','6','7','8','9',
'a','b','c','d','e','f','g','h','i','j','k','m','n',
'p','q','r','s','t','u','v','w','x','y','z');
$rand = ''; //random string
for($i=0;$i<=5;$i++){
	$rand .= $rand_chars[rand(0,count($rand_chars))];
}
$_SESSION['image_random_value_raw'] = $rand;
// create the image
$image = imagecreate(90, 30);
// use white as the background image
$bgColor = imagecolorallocate ($image, 255, 255, 255);
// the text color is black
$textColor = imagecolorallocate ($image, 0, 0, 0);
// custom font
$font = imageloadfont('../fonts/georgia.gdf');
// write the random number
imagestring ($image, $font, 5, 2, $rand, $textColor);
// send several headers to make sure the image is not cached
// taken directly from the PHP Manual
// Date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// always modified
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
// HTTP/1.0
header("Pragma: no-cache");
// send the content type header so the image is displayed properly
header('Content-type: image/jpeg');
// send the image to the browser
imagejpeg($image);
// destroy the image to free up the memory
imagedestroy($image);
?>