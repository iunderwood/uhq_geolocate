<?php

function xoops_module_uninstall_uhq_geolocate(&$module) {
    
    $status = false;
    
    // Remove IPv4 Database
    
    $trustfile = XOOPS_TRUST_PATH."/IP2LOCATION.BIN";
    
    if ( file_exists($trustfile) ) {
        $del1 = unlink ($trustfile);
    } else {
        $del1 = true;
    }
    
    // Remove IPv6 Database
    
    $trustfile = XOOPS_TRUST_PATH."/IP2LOCATION-V6.BIN";
    
    if ( file_exists($trustfile) ) {
        $del2 = unlink ($trustfile);
    } else {
        $del2 = true;
    }
    
    if ($del1 && $del2) {
        return true;
    } else {
        return false;
    }
}
