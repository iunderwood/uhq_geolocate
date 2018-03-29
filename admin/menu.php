<?php

// Adjust icon path depending on the XOOPS version we're using.

use XoopsModules\Uhqgeolocate;

// require_once __DIR__ . '/../class/Helper.php';
//require_once __DIR__ . '/../include/common.php';
$helper = Uhqgeolocate\Helper::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');


// Assign goodies for Admin Menu

$adminmenu[] = [
    'title' => _MI_UHQGEO_ADMENU_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png',
];

$adminmenu[] = [
    'title' => _MI_UHQGEO_ADMENU_INDEX,
    'link'  => 'admin/main.php',
    'icon'  => $pathIcon32 . '/globe.png',
];

$adminmenu[] = [
    'title' => _MI_UHQGEO_ADMENU_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',
];
