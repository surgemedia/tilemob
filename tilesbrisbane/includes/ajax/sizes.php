<?php
include('../connection.php');
$category   = @$_POST['category'];
$size       = @$_POST['size'];
$surface    = @$_POST['surface'];
$colour     = @$_POST['colour'];
$sliprating = @$_POST['sliprating'];
$peirating  = @$_POST['peirating'];
$type       = @$_POST['type'];
$pattern    = @$_POST['pattern'];
$material   = @$_POST['material'];
$thickness  = @$_POST['thickness'];
$edge       = @$_POST['edge'];


/*$options_category = '';
$sqlquery = "SELECT sw.Use,sus.* FROM shop_webitems as sw INNER JOIN  shop_use as sus ON sw.Use = sus.Code WHERE sus.is_active='1' ";
if($size)
{
    $sqlquery .= "AND sw.Size = '$size' ";
}
if($surface)
{
   $sqlquery .= "AND sw.Surface = '$surface' ";
}
if($colour)
{
    $sqlquery .= "AND sw.Colour = '$colour' ";
}
if($sliprating)
{
    $sqlquery.= "AND sw.SlipRating = '$sliprating' ";
}
if($peirating)
{
    $sqlquery.= "AND sw.PeiRating = '$peirating' ";
}
if($type)
{
    $sqlquery.= "AND sw.Type = '$type' ";
}
if($pattern)
{
    $sqlquery.= "AND sw.Pattern = '$pattern' ";
}
if($material)
{
    $sqlquery.= "AND sw.Material = '$material' ";
}
if($thickness)
{
    $sqlquery.= "AND sw.Thickness = '$thickness' ";
}
if($edge)
{
    $sqlquery.= "AND sw.Edge = '$edge' ";
}
$sqlquery .= "GROUP BY sw.Use";
//echo $sqlquery ;
$options_category = '';
$result_use = mysql_query($sqlquery);
$options_category .= '<option value="">No preference</option>';
while($row_use = mysql_fetch_array($result_use)) {
$use_code = $row_use['Code'];
$selected_use = $category;
if($use_code==$selected_use){$option_selected=' SELECTED';}else{$option_selected='';}
$options_category .= '<option value="'.$use_code.'"'.$option_selected.'>'.$row_use['Description'].'</option>';
}
$result['category']= urldecode($options_category);*/

/////////////////////////////////////////////////OPTION CATEGORY ENDS//////////////////////////////////////////////////////////////////////////

$options_size = '';

$query = "SELECT sw.Size,siz.* FROM shop_webitems as sw INNER JOIN  shop_size as siz ON sw.Size = siz.Code WHERE siz.is_active='1' ";
if($category)
{
   $query .= "AND sw.Use ='$category' ";
}
if($surface)
{
   $query .= "AND sw.Surface = '$surface' ";
}
if($colour)
{
    $query .= "AND sw.Colour = '$colour' ";
}
if($sliprating)
{
    $query.= "AND sw.SlipRating = '$sliprating' ";
}
if($peirating)
{
    $query.= "AND sw.PeiRating = '$peirating' ";
}
if($type)
{
    $query.= "AND sw.Type = '$type' ";
}
if($pattern)
{
    $query.= "AND sw.Pattern = '$pattern' ";
}
if($material)
{
    $query.= "AND sw.Material = '$material' ";
}
if($thickness)
{
    $query.= "AND sw.Thickness = '$thickness' ";
}
if($edge)
{
    $query.= "AND sw.Edge = '$edge' ";
}
$query .= "GROUP BY sw.Size";

$result_size = mysql_query($query);

//$result_size = mysql_query("SELECT sw.Size,ss.* FROM shop_webitems as sw INNER JOIN  shop_size as ss ON sw.Size = ss.Code WHERE is_active='1'");
$options_size = '<option value="">No preference</option>';
while($row_size = mysql_fetch_array($result_size)) {
$size_code = $row_size['Code'];
$selected_size = $size;
if($size_code==$selected_size){$option_selected=' SELECTED';}else{$option_selected='';}
//$options_string .= '<option value="'.$size_code.'"'.$option_selected.'>'.$row_size['Description'].'</option>';*/
$options_size .= '<option value="'.$size_code.'"'.$option_selected.'>'.$row_size['Description'].'</option>';
}
$result['size']= urldecode($options_size);
//echo htmlentities($options_size);
/////////////////////////////////////////////////////// END OPTION SIZE ////////////////////////////////////////////////////////////////////


$options_colour = '';
$query1 = "SELECT sw.Colour,sc.* FROM shop_webitems as sw INNER JOIN  shop_colour as sc ON sw.Colour = sc.Code WHERE sc.is_active='1' ";
if($category)
{
   $query1 .= "AND sw.Use ='$category' ";
}
if($size)
{
    $query1 .= "AND sw.Size = '$size' ";
}
if($surface)
{
   $query1 .= "AND sw.Surface = '$surface' ";
}
/*if($colour)
{
    $query1 .= "AND sw.Colour = '$colour' ";
}*/
if($sliprating)
{
    $query1.= "AND sw.SlipRating = '$sliprating' ";
}
if($peirating)
{
    $query1.= "AND sw.PeiRating = '$peirating' ";
}
if($type)
{
    $query1.= "AND sw.Type = '$type' ";
}
if($pattern)
{
    $query1.= "AND sw.Pattern = '$pattern' ";
}
if($material)
{
    $query1.= "AND sw.Material = '$material' ";
}
if($thickness)
{
    $query1.= "AND sw.Thickness = '$thickness' ";
}
if($edge)
{
    $query1.= "AND sw.Edge = '$edge' ";
}
$query1 .= "GROUP BY sw.Colour";
$result_colour = mysql_query($query1);
$options_colour = '<option value="">No preference</option>';
while($row_colour = mysql_fetch_array($result_colour)) {
$colour_code = $row_colour['Code'];
$selected_colour = $colour;
if($colour_code==$selected_colour){$option_selected=' SELECTED';}else{$option_selected='';}
//$options_string .= '<option value="'.$colour_code.'"'.$option_selected.'>'.$row_colour['Description'].'</option>';*/
$options_colour .= '<option value="'.$colour_code.'"'.$option_selected.'>'.$row_colour['Description'].'</option>';
}
 $result['color']= urldecode($options_colour);
 //echo $options_colour;
///////////////////////////////////////////////////////END OPTION COLOR///////////////////////////////////////////////////////////////////
 
 
 $options_surfacefinish = '';
 $query2 = "SELECT sw.Surface,ss.* FROM shop_webitems as sw INNER JOIN  shop_surface as ss ON sw.Surface = ss.Code WHERE ss.is_active='1' ";
 if($category)
{
   $query2 .= "AND sw.Use ='$category' ";
}
if($size)
{
    $query2 .= "AND sw.Size = '$size' ";
}
/*if($surface)
{
   $query2 .= "AND sw.Surface = '$surface' ";
}*/
if($colour)
{
    $query2 .= "AND sw.Colour = '$colour' ";
}
if($sliprating)
{
    $query2.= "AND sw.SlipRating = '$sliprating' ";
}
if($peirating)
{
    $query2.= "AND sw.PeiRating = '$peirating' ";
}
if($type)
{
    $query2.= "AND sw.Type = '$type' ";
}
if($pattern)
{
    $query2.= "AND sw.Pattern = '$pattern' ";
}
if($material)
{
    $query2.= "AND sw.Material = '$material' ";
}
if($thickness)
{
    $query2.= "AND sw.Thickness = '$thickness' ";
}
if($edge)
{
    $query2.= "AND sw.Edge = '$edge' ";
}
$query2 .= "GROUP BY sw.Surface";
$result_surface = mysql_query($query2);
$options_surfacefinish = '<option value="">No preference</option>';
while($row_surface = mysql_fetch_array($result_surface)) {
$surface_code = $row_surface['Code'];
$selected_surface = $surface;
if($surface_code==$selected_surface){$option_selected=' SELECTED';}else{$option_selected='';}
//$options_string .= '<option value="'.$surface_code.'"'.$option_selected.'>'.$row_surface['Description'].'</option>';*/
$options_surfacefinish .= '<option value="'.$surface_code.'"'.$option_selected.'>'.$row_surface['Description'].'</option>';
}
$result['surface']= urldecode($options_surfacefinish);
 
 ////////////////////////////////////////////////////////END OPTION SURFACE ////////////////////////////////////////////////////////////////////////



$options_sliprating = '';
$query3 = "SELECT sw.SlipRating,sslr.* FROM shop_webitems as sw INNER JOIN  shop_sliprating as sslr ON sw.SlipRating = sslr.Code WHERE sslr.is_active='1' ";
if($category)
{
   $query3 .= "AND sw.Use ='$category' ";
}
if($size)
{
    $query3 .= "AND sw.Size = '$size' ";
}
if($surface)
{
   $query3 .= "AND sw.Surface = '$surface' ";
}
if($colour)
{
    $query3 .= "AND sw.Colour = '$colour' ";
}
/*if($sliprating)
{
    $query3.= "AND sw.SlipRating = '$sliprating' ";
}*/
if($peirating)
{
    $query3.= "AND sw.PeiRating = '$peirating' ";
}
if($type)
{
    $query3.= "AND sw.Type = '$type' ";
}
if($pattern)
{
    $query3.= "AND sw.Pattern = '$pattern' ";
}
if($material)
{
    $query3.= "AND sw.Material = '$material' ";
}
if($thickness)
{
    $query3.= "AND sw.Thickness = '$thickness' ";
}
if($edge)
{
    $query3.= "AND sw.Edge = '$edge' ";
}
$query3 .= "GROUP BY sw.SlipRating";
$result_sliprating = mysql_query($query3);
$options_sliprating = '<option value="">No preference</option>';
while($row_sliprating = mysql_fetch_array($result_sliprating)) {
$sliprating_code = $row_sliprating['Code'];
$selected_sliprating = $sliprating;
if($sliprating_code==$selected_sliprating){$option_selected=' SELECTED';}else{$option_selected='';}
//$options_string .= '<option value="'.$sliprating_code.'"'.$option_selected.'>'.$row_sliprating['Description'].'</option>';*/
$options_sliprating .= '<option value="'.$sliprating_code.'"'.$option_selected.'>'.$row_sliprating['Description'].'</option>';
}

$result['sliprating']= urldecode($options_sliprating);

////////////////////////////////////////////////////END sliprating ////////////////////////////////////////////////////////////////////////

$options_peirating = '';
$query4 = "SELECT sw.PEIRating,spr.* FROM shop_webitems as sw INNER JOIN  shop_peirating as spr ON sw.PEIRating = spr.Code WHERE spr.is_active='1' ";
if($category)
{
   $query4 .= "AND sw.Use ='$category' ";
}
if($size)
{
    $query4 .= "AND sw.Size = '$size' ";
}
if($surface)
{
   $query4 .= "AND sw.Surface = '$surface' ";
}
if($colour)
{
    $query4 .= "AND sw.Colour = '$colour' ";
}
if($sliprating)
{
    $query4.= "AND sw.SlipRating = '$sliprating' ";
}
/*if($peirating)
{
    $query3.= "AND sw.PeiRating = '$peirating' ";
}*/
if($type)
{
    $query4.= "AND sw.Type = '$type' ";
}
if($pattern)
{
    $query4.= "AND sw.Pattern = '$pattern' ";
}
if($material)
{
    $query4.= "AND sw.Material = '$material' ";
}
if($thickness)
{
    $query4.= "AND sw.Thickness = '$thickness' ";
}
if($edge)
{
    $query4.= "AND sw.Edge = '$edge' ";
}
$query4 .= "GROUP BY sw.PEIRating";
$result_peirating = mysql_query($query4);
$options_peirating = '<option value="">No preference</option>';
while($row_peirating = mysql_fetch_array($result_peirating)) {
$peirating_code = $row_peirating['Code'];
$selected_peirating = $peirating;
if($peirating_code==$selected_peirating){$option_selected=' SELECTED';}else{$option_selected='';}
//$options_string .= '<option value="'.$peirating_code.'"'.$option_selected.'>'.$row_peirating['Description'].'</option>';*/
$options_peirating .= '<option value="'.$peirating_code.'"'.$option_selected.'>'.$row_peirating['Description'].'</option>';
}
$result['peirating']= urldecode($options_peirating);

/////////////////////////////////////////////////////END options_peirating //////////////////////////////////////////////////////////////


$options_type = '';
$query5 = "SELECT sw.Type,st.* FROM shop_webitems as sw INNER JOIN  shop_type as st ON sw.Type = st.Code WHERE st.is_active='1' ";
if($category)
{
   $query5 .= "AND sw.Use ='$category' ";
}
if($size)
{
    $query5 .= "AND sw.Size = '$size' ";
}
if($surface)
{
   $query5 .= "AND sw.Surface = '$surface' ";
}
if($colour)
{
    $query5 .= "AND sw.Colour = '$colour' ";
}
if($sliprating)
{
    $query5.= "AND sw.SlipRating = '$sliprating' ";
}
if($peirating)
{
    $query5.= "AND sw.PeiRating = '$peirating' ";
}
/*if($type)
{
    $query4.= "AND sw.Type = '$type' ";
}*/
if($pattern)
{
    $query5.= "AND sw.Pattern = '$pattern' ";
}
if($material)
{
    $query5.= "AND sw.Material = '$material' ";
}
if($thickness)
{
    $query5.= "AND sw.Thickness = '$thickness' ";
}
if($edge)
{
    $query5.= "AND sw.Edge = '$edge' ";
}
$query5 .= "GROUP BY sw.Type";
$result_type = mysql_query($query5);
$options_type = '<option value="">No preference</option>';
while($row_type = mysql_fetch_array($result_type)) {
$type_code = $row_type['Code'];
$selected_type = $type;
if($type_code==$selected_type){$option_selected=' SELECTED';}else{$option_selected='';}
//$options_string .= '<option value="'.$type_code.'"'.$option_selected.'>'.$row_type['Description'].'</option>';*/
$options_type .= '<option value="'.$type_code.'"'.$option_selected.'>'.$row_type['Description'].'</option>';
}
$result['type']= urldecode($options_type);

/////////////////////////////////////////////////////////END option type ///////////////////////////////////////////////////////


$options_pattern = '';
$query6 = "SELECT sw.Pattern,sp.* FROM shop_webitems as sw INNER JOIN  shop_pattern as sp ON sw.Pattern = sp.Code WHERE sp.is_active='1' ";
if($category)
{
   $query6 .= "AND sw.Use ='$category' ";
}
if($size)
{
    $query6 .= "AND sw.Size = '$size' ";
}
if($surface)
{
   $query6 .= "AND sw.Surface = '$surface' ";
}
if($colour)
{
    $query6 .= "AND sw.Colour = '$colour' ";
}
if($sliprating)
{
    $query6.= "AND sw.SlipRating = '$sliprating' ";
}
if($peirating)
{
    $query6.= "AND sw.PeiRating = '$peirating' ";
}
if($type)
{
    $query6.= "AND sw.Type = '$type' ";
}
/*if($pattern)
{
    $query6.= "AND sw.Pattern = '$pattern' ";
}*/
if($material)
{
    $query6.= "AND sw.Material = '$material' ";
}
if($thickness)
{
    $query6.= "AND sw.Thickness = '$thickness' ";
}
if($edge)
{
    $query6.= "AND sw.Edge = '$edge' ";
}
$query6 .= "GROUP BY sw.Pattern";
$result_pattern = mysql_query($query6);
$options_pattern = '<option value="">No preference</option>';
while($row_pattern = mysql_fetch_array($result_pattern)) {
$pattern_code = $row_pattern['Code'];
$selected_pattern = $pattern;
if($pattern_code==$selected_pattern){$option_selected=' SELECTED';}else{$option_selected='';}
//$options_string .= '<option value="'.$pattern_code.'"'.$option_selected.'>'.$row_pattern['Description'].'</option>';*/
$options_pattern .= '<option value="'.$pattern_code.'"'.$option_selected.'>'.$row_pattern['Description'].'</option>';
}
$result['pattern']= urldecode($options_pattern);

////////////////////////////////////////////////END OPTION PATTERN ////////////////////////////////////////////////////////////////
 
$options_material = '';
$query7 = "SELECT sw.Material,sm.* FROM shop_webitems as sw INNER JOIN  shop_material as sm ON sw.Material = sm.Code WHERE sm.is_active='1' ";
if($category)
{
   $query7 .= "AND sw.Use ='$category' ";
}
if($size)
{
    $query7 .= "AND sw.Size = '$size' ";
}
if($surface)
{
   $query7 .= "AND sw.Surface = '$surface' ";
}
if($colour)
{
    $query7 .= "AND sw.Colour = '$colour' ";
}
if($sliprating)
{
    $query7.= "AND sw.SlipRating = '$sliprating' ";
}
if($peirating)
{
    $query7.= "AND sw.PeiRating = '$peirating' ";
}
if($type)
{
    $query7.= "AND sw.Type = '$type' ";
}
if($pattern)
{
    $query7.= "AND sw.Pattern = '$pattern' ";
}
/*if($material)
{
    $query7.= "AND sw.Material = '$material' ";
}*/
if($thickness)
{
    $query7.= "AND sw.Thickness = '$thickness' ";
}
if($edge)
{
    $query7.= "AND sw.Edge = '$edge' ";
}
$query7 .= "GROUP BY sw.Material";
$result_material = mysql_query($query7);
$options_material = '<option value="">No preference</option>';
while($row_material = mysql_fetch_array($result_material)) {
$material_code = $row_material['Code'];
$selected_material = $material;
if($material_code==$selected_material){$option_selected=' SELECTED';}else{$option_selected='';}
//$options_string .= '<option value="'.$material_code.'"'.$option_selected.'>'.$row_material['Description'].'</option>';*/
$options_material .= '<option value="'.$material_code.'"'.$option_selected.'>'.$row_material['Description'].'</option>';
}
$result['material']= urldecode($options_material);

//////////////////////////////////////////////END OPTION MATERIAL/////////////////////////////////////////////////////////

$options_thickness = '';
$query8 = "SELECT sw.Thickness,sthk.* FROM shop_webitems as sw INNER JOIN  shop_thickness as sthk ON sw.Thickness = sthk.Code WHERE sthk.is_active='1' ";
if($category)
{
   $query8 .= "AND sw.Use ='$category' ";
}
if($size)
{
    $query8 .= "AND sw.Size = '$size' ";
}
if($surface)
{
   $query8 .= "AND sw.Surface = '$surface' ";
}
if($colour)
{
    $query8 .= "AND sw.Colour = '$colour' ";
}
if($sliprating)
{
    $query8.= "AND sw.SlipRating = '$sliprating' ";
}
if($peirating)
{
    $query8.= "AND sw.PeiRating = '$peirating' ";
}
if($type)
{
    $query8.= "AND sw.Type = '$type' ";
}
if($pattern)
{
    $query8.= "AND sw.Pattern = '$pattern' ";
}
if($material)
{
    $query8.= "AND sw.Material = '$material' ";
}
/*if($thickness)
{
    $query8.= "AND sw.Thickness = '$thickness' ";
}*/
if($edge)
{
    $query8.= "AND sw.Edge = '$edge' ";
}
$query8 .= "GROUP BY sw.Thickness";
$result_thickness = mysql_query($query8);
$options_thickness = '<option value="">No preference</option>';
while($row_thickness = mysql_fetch_array($result_thickness)) {
$thickness_code = $row_thickness['Code'];
$selected_thickness = $thickness;
if($thickness_code==$selected_thickness){$option_selected=' SELECTED';}else{$option_selected='';}
//$options_string .= '<option value="'.$thickness_code.'"'.$option_selected.'>'.$row_thickness['Description'].'</option>';*/
$options_thickness .= '<option value="'.$thickness_code.'"'.$option_selected.'>'.$row_thickness['Description'].'</option>';
}
$result['thickness']= urldecode($options_thickness);

////////////////////////////////////////////////////////////END OPTION THICKNESS/////////////////////////////////////////////////////


$options_edge = '';
$query9 = "SELECT sw.Edge,sed.* FROM shop_webitems as sw INNER JOIN  shop_edge as sed ON sw.Edge = sed.Code WHERE sed.is_active='1' ";
if($category)
{
   $query9 .= "AND sw.Use ='$category' ";
}
if($size)
{
    $query9 .= "AND sw.Size = '$size' ";
}
if($surface)
{
   $query9 .= "AND sw.Surface = '$surface' ";
}
if($colour)
{
    $query9 .= "AND sw.Colour = '$colour' ";
}
if($sliprating)
{
    $query9.= "AND sw.SlipRating = '$sliprating' ";
}
if($peirating)
{
    $query9.= "AND sw.PeiRating = '$peirating' ";
}
if($type)
{
    $query9.= "AND sw.Type = '$type' ";
}
if($pattern)
{
    $query9.= "AND sw.Pattern = '$pattern' ";
}
if($material)
{
    $query9.= "AND sw.Material = '$material' ";
}
if($thickness)
{
    $query9.= "AND sw.Thickness = '$thickness' ";
}
/*if($edge)
{
    $query8.= "AND sw.Edge = '$edge' ";
}*/
$query9 .= "GROUP BY sw.Edge";
$result_edge = mysql_query($query9);
$options_edge = '<option value="">No preference</option>';
while($row_edge = mysql_fetch_array($result_edge)) {
$edge_code = $row_edge['Code'];
$selected_edge = $edge;
if($edge_code==$selected_edge){$option_selected=' SELECTED';}else{$option_selected='';}
//$options_string .= '<option value="'.$edge_code.'"'.$option_selected.'>'.$row_edge['Description'].'</option>';*/
$options_edge .= '<option value="'.$edge_code.'"'.$option_selected.'>'.$row_edge['Description'].'</option>';
}
$result['edge']= urldecode($options_edge);
                                
                                
                                
                                

  echo json_encode($result);
//echo $options_string;

?>
