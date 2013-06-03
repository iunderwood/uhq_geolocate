<?php

include "../../../mainfile.php";
require_once XOOPS_ROOT_PATH . "/modules/uhq_geolocate/class/geolocate.class.php";
require_once XOOPS_ROOT_PATH . "/modules/uhq_geolocate/includes/countryshort.php";
require_once XOOPS_ROOT_PATH . "/include/cp_header.php";
require_once XOOPS_ROOT_PATH . '/class/template.php';

include_once XOOPS_ROOT_PATH."/Frameworks/art/functions.php";
include_once XOOPS_ROOT_PATH."/Frameworks/art/functions.admin.php";

if (!isset($xoopsTpl)) {
	$xoopsTpl = new XoopsTpl();
}
$xoopsTpl->xoops_setCaching(0);

// Functions

function uhqgeo_providername ($prov) {
	switch ($prov) {
		case 1:	return(_AM_UHQGEO_PROV_P1); break;
		
		case 11: return(_AM_UHQGEO_PROV_P11); break;
		case 12: return(_AM_UHQGEO_PROV_P12); break;
		case 13: return(_AM_UHQGEO_PROV_P13); break;
		
		case 21: return(_AM_UHQGEO_PROV_P11); break;
		case 22: return(_AM_UHQGEO_PROV_P12); break;
		case 23: return(_AM_UHQGEO_PROV_P13); break;
		
		default: return;
	}
}

// Header

xoops_cp_header();

// Now the fun begins!

if ( isset($_REQUEST['op']) ) {
	$op = $_REQUEST['op'];
} else {
	$op = "none";
}

function diagarray () {
	// Load module options
	$modhandler			=& xoops_gethandler('module');
	$xoopsModule		=& $modhandler->getByDirname('uhq_geolocate');
	$config_handler		=& xoops_gethandler('config');
	$xoopsModuleConfig	=& $config_handler->getConfigsByCat(0,$xoopsModule->getVar('mid'));

	// Return true if geolocation is enabled in the configuration.
	if ($xoopsModuleConfig['geoloc_printr'] == 1) {
		return true;
	} else {
		return false;
	}
}

echo function_exists("loadModuleAdminMenu") ? loadModuleAdminMenu(0) : "";

$geoloc = new geolocate;

switch ($op) {
	case 'c' : // Clear IPv4 Cache
		$dbquery = "DELETE FROM ".$xoopsDB->prefix("uhqgeolocate_v4cache")." WHERE ipaddr > 0";
		$dbresult = $xoopsDB->queryF($dbquery);
		if ($dbresult) {
			$data['cachedel'] = 1;
		}
		break;
	case "q" :	// Answer query form.
		$geoloc->ipin = $_REQUEST['ipaddr'];
		$query = $geoloc->locate();
		$data['q2'] = (array) $geoloc;
		$data['query'] = (array) $query;
		$data['query']['flag'] = strtolower($data['query']['country']);
		$data['query']['ccname'] = $_UHQGEO_CC[$data['query']['country']];
		break;
	default :
		break;
}

$geoloc->ipin = $_SERVER['REMOTE_ADDR'];
$result = $geoloc->locate();
$data['input'] = (array) $geoloc;
$data['result'] = (array) $result;
$data['result']['flag'] = strtolower($data['result']['country']);
$data['result']['ccname'] = $_UHQGEO_CC[$data['result']['country']];

if ($geoloc->geoloc_cache()) {
	$dbquery = "SELECT count(ipaddr) as cachemiss, sum(hits) as cachehits from ".$xoopsDB->prefix("uhqgeolocate_v4cache");
	$dbresult = $xoopsDB->queryF($dbquery);
	
	$data['cacheactive'] = 1;
	
	if ($dbresult) {
		$row = $xoopsDB->fetchArray($dbresult);
		$data['cachemiss'] = $row['cachemiss'];
		$data['cachehits'] = $row['cachehits'];
	}
}

$data['v4db'] = (array) $geoloc->dbinfo(4);
$data['v4db']['name'] = uhqgeo_providername($data['v4db']['provider']);

$data['v6db'] = (array) $geoloc->dbinfo(6);
$data['v6db']['name'] = uhqgeo_providername($data['v6db']['provider']);

$xoopsTpl->assign('data',$data);
$xoopsTpl->display("db:admin/uhqgeolocate_index.html");

if (diagarray()) {
	echo "<hr><h3>Diagnostic Array</h3><pre>";
	print_r($data);
	echo "</pre>";
}

xoops_cp_footer();

?>