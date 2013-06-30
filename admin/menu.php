<?php

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

$adminmenu = array();

$i=1;
$adminmenu[$i]['title'] = _MI_UHQGEO_ADMENU_HOME;
$adminmenu[$i]['link']  = "admin/index.php";
$adminmenu[$i]['icon']  = '/home.png';

$i++;
$adminmenu[$i]['title'] = _MI_UHQGEO_ADMENU_INDEX;
$adminmenu[$i]['link']  = "admin/main.php";
$adminmenu[$i]['icon']  = '/globe.png';

$i++;
$adminmenu[$i]['title'] = _MI_UHQGEO_ADMENU_ABOUT;
$adminmenu[$i]['link']  = "admin/about.php";
$adminmenu[$i]['icon']  = '/about.png';