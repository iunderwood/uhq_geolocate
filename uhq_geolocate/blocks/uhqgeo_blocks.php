<?php

require_once XOOPS_ROOT_PATH . "/modules/uhq_geolocate/class/geolocate.class.php";

function b_uhqgeo_from_show($options) {
    
    // One of the simplest things we can do to use this.
    
    $geoloc = new geolocate;

    $geoloc->ipin = $_SERVER['REMOTE_ADDR'];
    $result = $geoloc->locate();
    
    $data['input'] = (array) $geoloc;
    $data['result'] = (array) $result;
    
    if ($result) {
        
        include XOOPS_ROOT_PATH . "/modules/uhq_geolocate/includes/countryshort.php";
        
        $data['result']['flag'] = strtolower($data['result']['country']);
        $data['result']['ccname'] = $_UHQGEO_CC[$data['result']['country']];
    }
    
    return $data;
        
}
