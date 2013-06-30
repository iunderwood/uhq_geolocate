<?php

require_once XOOPS_ROOT_PATH . "/modules/uhq_geolocate/class/geolocate.class.php";

// This is a super simple block demonstrating how we can use this information.
function b_uhqgeo_from_show($options) {
	$geoloc = new geolocate;
	$geoloc->ipin = $_SERVER['REMOTE_ADDR'];

	$result = $geoloc->locate();

	$data['input'] = (array) $geoloc;
	$data['result'] = (array) $result;

	if ($result) {
		// Only process flags and names if we have a country.
		if ($data['result']['country']) {
			include XOOPS_ROOT_PATH . "/modules/uhq_geolocate/includes/countryshort.php";
			$data['result']['flag'] = strtolower($data['result']['country']);
			$data['result']['ccname'] = $_UHQGEO_CC[$data['result']['country']];
		}
	}
	return $data;
}