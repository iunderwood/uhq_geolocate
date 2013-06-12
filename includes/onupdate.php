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

	if ($oldversion < 92) {

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

	if ($oldversion < 93) {

		// New field: dateadd
		$query = 'ALTER TABLE '.$xoopsDB->prefix("uhqgeolocate_v4cache")." ADD dateadd DATE AFTER hits";
		$result = $xoopsDB->QueryF($query);
		if (! $result) {
			$module->setErrors("Error adding DB datadd field.");
			return false;
		}

		// Update v4 API description
		$query = 'UPDATE '.$xoopsDB->prefix("config").' WHERE conf_title = "_MI_UHQGEO_MODCFG_APIKEY" SET ';
		$query .= 'conf_title = "_MI_UHQGEO_MODCFG_APIV4KEY", ';
		$query .= 'conf_desc = "_MI_UHQGEO_MODCFG_APIV4KEY_DESC"';

		$result = $xoopsDB->QueryF($query);

		if (! $result) {
			$module->setErrors("Error modifying API Key Description");
			return false;
		}

		$oldversion = 93;
	}

	// Remove sample files if we've already got them installed.

	$distfile = XOOPS_ROOT_PATH."/modules/uhq_geolocate/IP-COUNTRY-SAMPLE.BIN";
	$trustfile = XOOPS_TRUST_PATH."/IP2LOCATION.BIN";
	if ( file_exists($trustfile) && file_exists($distfile) ) {
		unlink ($distfile);
	}

	$distfile = XOOPS_ROOT_PATH."/modules/uhq_geolocate/IPV6-COUNTRY-SAMPLE.BIN";
	$trustfile = XOOPS_TRUST_PATH."/IP2LOCATION-V6.BIN";
	if ( file_exists($trustfile) && file_exists($distfile) ) {
		unlink ($distfile);
	}

	return true;
}


?>