<ul>
<?php
$navigation_array_titles = array(
// 'Pages',
// 'Products',
'Upload',
'Menu Manager',
'Submenu Manager',
//'Forms',
// 'Logout'
);
$navigation_array_links = array(
// 'pages.php',
// 'products.php',
'upload-xml.php',
'menuManage.php',
'submenuManage.php',
//'forms.php',
// 'logout.php'
);
$navigation_array_linktitles = array(
// 'Edit pages',
// 'Products',
'Upload product data',
'Manage menu',
'Manage Submenu',
//'View Website forms',
'Logout: '.$_SESSION['cms_username'].''
);
foreach($navigation_array_titles as $key => $value) {
	if($_currentpage == $navigation_array_links[$key]) { 
		$nav_link_style = ' style="background:#959595;"';
	} else { 
		$nav_link_style = '';
	}
	$nav_string .= '<li><a href="'.$navigation_array_links[$key].'" title="'.$navigation_array_linktitles[$key].'"'.$nav_link_style.'>'.$value.'</a></li>';
	
}
echo $nav_string;
?>
</ul>