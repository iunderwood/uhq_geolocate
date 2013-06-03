<?php

// Adjust icon path depending on the XOOPS version we're using.

$versioninfo=array();
preg_match_all('/\d+/',XOOPS_VERSION,$versioninfo);
if ( ($versioninfo[0][0] >= 2) && ($versioninfo[0][1] >= 4) ) {
  $menuiconpath = "";
} else {
  $menuiconpath = "../../../../uhq_geolocate/";
}

// Assign goodies for Admin Menu

global $adminmenu;

$adminmenu = array();

$adminmenu[0]['title'] = _MI_UHQGEO_ADMENU_INDEX;
$adminmenu[0]['link'] = "admin/index.php";
$adminmenu[0]['icon'] = $menuiconpath."images/menu_index.png";

?>