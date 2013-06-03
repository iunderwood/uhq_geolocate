<?php

// Modular Definitions

$modversion['name'] = _MI_UHQGEO_NAME;
$modversion['version'] = 0.93;
$modversion['description'] = _MI_UHQGEO_DESC;
$modversion['author'] = "Ian A. Underwood";
$modversion['credits'] = "Underwood Headquarters";
$modversion['license'] = "CC-GNU GPL";
$modversion['help'] = 'geolocate';
$modversion['official'] = 0;
$modversion['image'] = "images/uhq_geolocate_slogo.png";
$modversion['dirname'] = "uhq_geolocate";

// Install/Update Scripts

$modversion['onInstall'] = 'includes/oninstall.php';
$modversion['onUpdate'] = 'includes/onupdate.php';
$modversion['onUninstall'] = 'includes/onuninstall.php';

// Database Information

$modversion['sqlfile']['mysql'] = "sql/uhq_geolocate.sql";

$modversion['tables'][] = "uhqgeolocate_v4cache";

// Module-Wide Configuration Items

$modversion['hasConfig'] = 1;

// Option 1: Ability to turn off geolocation site-wide.  When off, query results will all be null.

$modversion['config'][] = array (
	'name'			=> 'geoloc_ready',
	'title'			=> '_MI_UHQGEO_MODCFG_READY',
	'description'	=> '_MI_UHQGEO_MODCFG_READY_DESC',
	'formtype'		=> 'yesno',
	'valuetype'		=> 'int',
	'default'		=> 1
);

// Option 2: Select IPv4 DB Provider

$modversion['config'][] = array (
	'name'			=> 'ipv4_prov',
	'title'			=> '_MI_UHQGEO_MODCFG_IPV4',
	'description'	=> '_MI_UHQGEO_MODCFG_IPV4_DESC',
	'formtype'		=> 'select',
	'valuetype'		=> 'int',
	'options'		=> array (
		_MI_UHQGEO_MODCFG_IPV4_DB_IP2L	=> 1,
		// IPInfoDB Web API
		_MI_UHQGEO_MODCFG_IPV4_API_IPDB_CITY_TZ		=> 11,
		_MI_UHQGEO_MODCFG_IPV4_API_IPDB_CITY		=> 12,
		_MI_UHQGEO_MODCFG_IPV4_API_IPDB_COUNTRY		=> 13,
		// MaxMind Web API
		_MI_UHQGEO_MODCFG_IPV4_API_MAXMIND_CITY_ISP	=> 21,
		_MI_UHQGEO_MODCFG_IPV4_API_MAXMIND_CITY		=> 22,
		_MI_UHQGEO_MODCFG_IPV4_API_MAXMIND_COUNTRY	=> 23
	),
	'default'		=> 1
);

// Option 3: Select IPv6 DB Provider

$modversion['config'][] = array (
	'name'			=> 'ipv6_prov',
	'title'			=> '_MI_UHQGEO_MODCFG_IPV6',
	'description'	=> '_MI_UHQGEO_MODCFG_IPV6_DESC',
	'formtype'		=> 'select',
	'valuetype'		=> 'int',
	'options'		=> array (
		_MI_UHQGEO_MODCFG_IPV6_DB_IP2L => 1
	),
	'default'		=> 1
);

// Option 4: Print Data Array on Admin Index

$modversion['config'][] = array (
	'name'			=> 'geoloc_printr',
	'title'			=> '_MI_UHQGEO_MODCFG_PRINTR',
	'description'	=> '_MI_UHQGEO_MODCFG_PRINTR_DESC',
	'formtype'		=> 'yesno',
	'valuetype'		=> 'int',
	'default'		=> 0
);

// Option 5: API Key (if Required)

$modversion['config'][] = array (
	'name'			=> 'geoloc_apikey',
	'title'			=> '_MI_UHQGEO_MODCFG_APIKEY',
	'description'	=> '_MI_UHQGEO_MODCFG_APIKEY_DESC',
	'formtype'		=> 'textbox',
	'valuetype'		=> 'text',
	'default'		=> ''
);

// Option 6: Activate API Cache?

$modversion['config'][] = array (
	'name'			=> 'geoloc_cache',
	'title'			=> '_MI_UHQGEO_MODCFG_CACHE',
	'description'	=> '_MI_UHQGEO_MODCFG_CACHE_DESC',
	'formtype'		=> 'yesno',
	'valuetype'		=> 'int',
	'default'		=> 1
);

// Option 7: API Cache Expiry

$modversion['config'][] = array (
	'name'			=> 'geoloc_cacheexpire',
	'title'			=> '_MI_UHQGEO_MODCFG_CACHEEXP',
	'description'	=> '_MI_UHQGEO_MODCFG_CACHEEXP_DEXC',
	'formtype'		=> 'int',
	'valuetype'		=> 'int',
	'default'		=> 0
);

// Administrative Items

$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Menu Items

$modversion['hasMain'] = 0;

// Templates

$modversion['templates'][1]['file']			= "admin/uhqgeolocate_index.html";
$modversion['templates'][1]['description']	= _MI_UHQGEO_TEMPLATE_INDEX;

// Blocks

$modversion['blocks'][1]['file']		= 'uhqgeo_blocks.php';
$modversion['blocks'][1]['name']		= _MI_UHQGEO_BLOCK_FROM_NAME;
$modversion['blocks'][1]['description']	= _MI_UHQGEO_BLOCK_FROM_DESC;
$modversion['blocks'][1]['show_func']	= "b_uhqgeo_from_show";
//$modversion['blocks'][1]['edit_func']	= "b_uhqgeo_from_edit";
$modversion['blocks'][1]['template']	= "uhqgeo_from.html";
$modversion['blocks'][1]['options']		= "";

?>