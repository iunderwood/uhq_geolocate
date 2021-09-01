<?php

function xoops_module_uninstall_uhqgeolocate(\XoopsModule $module)
{
    $status = false;

    // Remove IPv4 Database

    $trustfile = XOOPS_TRUST_PATH . '/IP2LOCATION.BIN';

    if (is_file($trustfile)) {
        $del1 = unlink($trustfile);
    } else {
        $del1 = true;
    }

    // Remove IPv6 Database

    $trustfile = XOOPS_TRUST_PATH . '/IP2LOCATION-V6.BIN';

    if (is_file($trustfile)) {
        $del2 = unlink($trustfile);
    } else {
        $del2 = true;
    }

    if ($del1 && $del2) {
        return true;
    }

    return false;
}
