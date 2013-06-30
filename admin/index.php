<?php

include_once dirname(__FILE__) . '/admin_header.php';

$xoops = Xoops::getInstance();

$xoops->header();
$adminPage = new XoopsModuleAdmin();
$adminPage->displayNavigation('index.php');
$adminPage->displayIndex();
$xoops->footer();

include_once dirname(__FILE__) . '/admin_footer.php';