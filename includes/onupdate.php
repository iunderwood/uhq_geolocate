<?php

function xoops_module_update_uhq_geolocate(&$module, $oldversion = null) {
	
	global $xoopsDB;
	
	// Firstly, remove sample files on an update if we can.
	
	$distfile = XOOPS_ROOT_PATH."/modules/uhq_geolocate/IP-COUNTRY-SAMPLE.BIN";
	
	if ( file_exists($distfile) ) {
		unlink ($distfile);
	}
	
	// Remove IPv6 Database
	
	$distfile = XOOPS_ROOT_PATH."/modules/uhq_geolocate/IPV6-COUNTRY-SAMPLE.BIN";
	
	if ( file_exists($distfile) ) {
		unlink ($distfile);
	}
	
	// Let's Update!
	
	if ($oldversion < 91) {
		
		// Add new DB tables into the database
		
		$query = 'CREATE TABLE '.$xoopsDB->prefix("uhqgeolocate_v4cache").' (
			ipaddr			INT UNSIGNED,
			hits			INT UNSIGNED,
			countrycode		CHAR(2),
			region			VARCHAR(128),
			city			VARCHAR(128),
			PRIMARY KEY (ipaddr)
			) ENGINE=MyISAM;';
		$result = $xoopsDB->queryF($query);
		if (! $result) {
			$module->setErrors("Error adding DB table uhqgeolocate_v4cache");
			return false;
		}
		
		$oldversion = 91;
	}
	
	if ($olversion < 92) {
		
		// Expand DB to include new fields
		
		$query = 'ALTER TABLE '.$xoopsDB->prefix("uhqgeolocate_v4cache")." ADD latitude DOUBLE AFTER city";
		$result = $xoopsDB->queryF($query);
		if (! $result) {
			$module->setErrors("Error adding DB latitude field.");
			return false;
		}
		
		$query = 'ALTER TABLE '.$xoopsDB->prefix("uhqgeolocate_v4cache")." ADD longitude DOUBLE AFTER latitude";
		$result = $xoopsDB->queryF($query);
		if (! $result) {
			$module->setErrors("Error adding DB longitude field.");
			return false;
		}
		
		$query = 'ALTER TABLE '.$xoopsDB->prefix("uhqgeolocate_v4cache")." ADD isp VARCHAR(128) AFTER longitude";
		$result = $xoopsDB->queryF($query);
		if (! $result) {
			$module->setErrors("Error adding DB isp field.");
			return false;
		}
		
		$query = 'ALTER TABLE '.$xoopsDB->prefix("uhqgeolocate_v4cache")." ADD org VARCHAR(128) AFTER isp";
		$result = $xoopsDB->queryF($query);
		if (! $result) {
			$module->setErrors("Error adding DB org field.");
			return false;
		}
		
		$oldversion = 92;
	}
	
	return true;
}


?>