<?php

use XoopsModules\Uhqgeolocate\{
    Helper,
    Geolocate
};
/** @var Helper $helper */

function b_uhqgeo_from_show($options)
{
    // One of the simplest things we can do to use this.

    $helper = Helper::getInstance();
    $geoloc = new Geolocate();

    $geoloc->ipin = $_SERVER['REMOTE_ADDR'];
    $result       = $geoloc->locate();

    $data['input']  = (array)$geoloc;
    $data['result'] = (array)$result;

    if ($result) {
        require_once $helper->path('includes/countryshort.php');

        $data['result']['flag']   = mb_strtolower($data['result']['country']);
        $data['result']['ccname'] = $_UHQGEO_CC[$data['result']['country']];
    }

    return $data;
}
