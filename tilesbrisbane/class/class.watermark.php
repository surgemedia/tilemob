<?php
class watermark {
    
private $watermark_overlay_image  = 'images/watermark.png';
private $resizedwatermark = 'images/watermark/watermark.png';
private $watermark_overlay_opacity = 20;
private $watermark_output_quality = 90;

function create_watermark($source_file_path, $output_file_path)
{
   
    list($source_width, $source_height, $source_type) = getimagesize($source_file_path);
    ////////////////////////////////////////////////////////////////
    $url = $this->watermark_overlay_image;
    $height = $source_height;
    $resizedwatermark = $this->resizedwatermark;
    $image = imagecreatefrompng($url);
    list($orig_width, $orig_height) = getimagesize($url);
    $image1 = $url;
    $maxwidth = 49; 
    $maxheight = $source_height ; 

	list($width,$height) = getimagesize($image1);
       
           $newWidth = ($maxheight * $width)/$height;
           $newheight=$maxheight;
      
       $new_image = imagecreatetruecolor($newWidth, $newheight);
       imagecopyresized($new_image, $image,
	0, 0, 0, 0,
	$newWidth, $newheight,
	$orig_width, $orig_height);
         imagepng($new_image, $resizedwatermark);
    ////////////////////////////////////////////////////////////////
    if ($source_type === NULL) {
        return false;
    }
    switch ($source_type) {
        case IMAGETYPE_GIF:
            $source_gd_image = imagecreatefromgif($source_file_path);
            break;
        case IMAGETYPE_JPEG:
            $source_gd_image = imagecreatefromjpeg($source_file_path);
            break;
        case IMAGETYPE_PNG:
            $source_gd_image = imagecreatefrompng($source_file_path);
            break;
        default:
            return false;
    }
    $overlay_gd_image = imagecreatefrompng($resizedwatermark);
    $overlay_width = imagesx($overlay_gd_image);
    $overlay_height = imagesy($overlay_gd_image);
    imagecopymerge(
        $source_gd_image,
        $overlay_gd_image,
        $source_width - $overlay_width,
        $source_height - $overlay_height,
        0,
        0,
        $overlay_width,
        $overlay_height,
        $this->watermark_overlay_opacity
    );
    imagejpeg($source_gd_image, $output_file_path, $this->watermark_output_quality);
    imagedestroy($source_gd_image);
    imagedestroy($overlay_gd_image);
}
}
?>
