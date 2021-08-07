<?php

// Adjust icon path depending on the XOOPS version we're using.

use Xmf\Module\Admin;
use XoopsModules\Uhqgeolocate\{
    Helper
};
/** @var Helper $helper */

$moduleDirName      = \basename(\dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

$helper = Helper::getInstance();
$helper->loadLanguage('common');
$helper->loadLanguage('feedback');

$pathIcon32 = Admin::menuIconPath('');
$pathModIcon32 = XOOPS_URL .   '/modules/' . $moduleDirName . '/assets/images/icons/32/';
if (is_object($helper->getModule()) && false !== $helper->getModule()->getInfo('modicons32')) {
    $pathModIcon32 = $helper->url($helper->getModule()->getInfo('modicons32'));
}

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

if (is_object($helper->getModule()) && $helper->getConfig('displayDeveloperTools')) {
    $adminmenu[] = [
        'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_MIGRATE'),
        'link' => 'admin/migrate.php',
        'icon' => $pathIcon32 . '/database_go.png',
    ];
}
$adminmenu[] = [
    'title' => _MI_UHQGEO_ADMENU_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',
];
