<?php

function xoops_module_install_uhq_geolocate(&$module) {
	
	$status = false;
	
	// Move IPv4 Database from module to trusted path
	
	$distfile = XOOPS_ROOT_PATH."/modules/uhq_geolocate/IP-COUNTRY-SAMPLE.BIN";
	$trustfile = XOOPS_TRUST_PATH."/IP2LOCATION.BIN";
	
	if ( file_exists($distfile) && (!file_exists($trustfile)) ) {
		$mv1 = rename ($distfile, $trustfile);
	}
	
	// Move IPv6 Database from module to trusted path
	
	$distfile = XOOPS_ROOT_PATH."/modules/uhq_geolocate/IPV6-COUNTRY-SAMPLE.BIN";
	$trustfile = XOOPS_TRUST_PATH."/IP2LOCATION-V6.BIN";
	
	if ( file_exists($distfile) && (!file_exists($trustfile)) ) {
		$mv2 = rename ($distfile, $trustfile);
	}
		
	if ($mv1 && $mv2) {
		return true;
	} else {
		return false;
	}
	
}

?>