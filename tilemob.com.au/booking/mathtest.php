<?php
$val_string = $_GET['v1'].'+'.$_GET['v2'].'= ';
// create the image
$image = imagecreate(50, 30);
// use white as the background image
$bgColor = imagecolorallocate ($image, 255, 255, 255);
// the text color is black
$textColor = imagecolorallocate ($image, 0, 0, 0);
// custom font
$font = imageloadfont('../fonts/georgia.gdf');
// write the random number
imagestring ($image, $font, 1, 2, $val_string, $textColor);
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