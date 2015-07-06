<?php
if($_POST['findtiles']) {
	//normal search
	$find_keywords = urlencode($_POST['keywords']); //ke
	$find_category = urlencode($_POST['category']); //ca
	$find_surface = urlencode($_POST['surface']); //su
	$find_colour = urlencode($_POST['colour']); //co
	$find_size = urlencode($_POST['size']); //si
	if($_POST['pricerange'] > 0)
	{
	$find_priceRange = urlencode($_POST['pricerange']); // pr
	}
	else
	{
		$find_priceRange = ""; // pr
	}
	//advanced search
	$find_peirating = urlencode($_POST['peirating']); //pe
	$find_type = urlencode($_POST['type']); //ty
	$find_pattern = urlencode($_POST['pattern']); //pa
	$find_material = urlencode($_POST['material']); //ma
	$find_thickness = urlencode($_POST['thickness']); //th
	$find_edge = urlencode($_POST['edge']); //ed
	$find_sliprating = urlencode($_POST['sliprating']); //sl
	header('location:tile-finder.php?ke='.$find_keywords.
	'&ca='.$find_category.'&su='.$find_surface.'&co='.$find_colour.'&si='.$find_size.
	'&pe='.$find_peirating.'&ty='.$find_type.'&pa='.$find_pattern.'&ma='.$find_material.
	'&th='.$find_thickness.'&ed='.$find_edge.'&sl='.$find_sliprating.'&pr='.$find_priceRange);
}
?>