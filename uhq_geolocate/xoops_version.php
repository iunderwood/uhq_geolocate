<?php

// Modular Definitions

if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

$modversion['name']         = _MI_UHQGEO_NAME;
$modversion['version']      = 0.96;
$modversion['description']  = _MI_UHQGEO_DESC;
$modversion['author']       = "Ian A. Underwood";
$modversion['credits']      = "Underwood Headquarters";
$modversion['help']         = 'page=help';
$modversion['license']      = 'GNU GPL 2.0 or later';
$modversion['license_url']  = "www.gnu.org/licenses/gpl-2.0.html";
$modversion['official']     = 0;
$modversion['image']        = "images/uhq_geolocate_slogo.png";
$modversion['dirname']      = "uhq_geolocate";

// Administrative Defines

$modversion['dirmoduleadmin'] = '/Frameworks/moduleclasses/moduleadmin';
$modversion['icons16']        = '../../Frameworks/moduleclasses/icons/16';
$modversion['icons32']        = '../../Frameworks/moduleclasses/icons/32';

// About Section

$modversion['release_date']        = '2015/06/15';
$modversion["module_website_url"]  = "xoops.underwood-hq.org";
$modversion["module_website_name"] = "XOOPS@UHQ";
$modversion["module_status"]       = "RC";

// Minimums

$modversion['min_php']      = '5.2';
$modversion['min_xoops']    = "2.5.7";
$modversion['min_admin']    = '1.1';
$modversion['min_db']       = array(
    'mysql'  => '5.0.7',
    'mysqli' => '5.0.7'
);

// Install/Update Scripts

$modversion['onInstall']    = 'includes/oninstall.php';
$modversion['onUpdate']     = 'includes/onupdate.php';
$modversion['onUninstall']  = 'includes/onuninstall.php';

// Database Information

$modversion['sqlfile']['mysql'] = "sql/uhq_geolocate.sql";

$modversion['tables'][] = "uhqgeolocate_v4cache";
$modversion['tables'][] = "uhqgeolocate_v6cache";

// Help Section

$i=0;
$modversion['helpsection'][$i]['name'] = "Overview";
$modversion['helpsection'][$i]['link'] = "page=help";
$i++;
$modversion['helpsection'][$i]['name'] = "Module Preferences";
$modversion['helpsection'][$i]['link'] = "page=module_prefs";

// Module-Wide Configuration Items

$modversion['hasConfig']    = 1;
$modversion['system_menu']  = 1;

// Option 1: Ability to turn off geolocation site-wide.  When off, query results will all be null.

$modversion['config'][] = array (
    'name'          => 'geoloc_ready',
    'title'         => '_MI_UHQGEO_MODCFG_READY',
    'description'   => '_MI_UHQGEO_MODCFG_READY_DESC',
    'formtype'      => 'yesno',
    'valuetype'     => 'int',
    'default'       => 1
);

// Option 2: Select IPv4 DB Provider

$modversion['config'][] = array (
    'name'          => 'ipv4_prov',
    'title'         => '_MI_UHQGEO_MODCFG_IPV4',
    'description'   => '_MI_UHQGEO_MODCFG_IPV4_DESC',
    'formtype'      => 'select',
    'valuetype'     => 'int',
    'options'       => array (
        _MI_UHQGEO_MODCFG_IPV4_DB_IP2L    => 1,
        // IPInfoDB Web API v2 - Depreciated in v0.96
        //_MI_UHQGEO_MODCFG_API_IPDB_CITY_TZ      => 11,
        //_MI_UHQGEO_MODCFG_API_IPDB_CITY         => 12,
        //_MI_UHQGEO_MODCFG_API_IPDB_COUNTRY      => 13,
        // IPInfoDB Web API v3
        _MI_UHQGEO_MODCFG_API_IPDBV3_CITY       => 14,
        _MI_UHQGEO_MODCFG_API_IPDBV3_COUNTRY    => 15,
        // MaxMind Web API
        _MI_UHQGEO_MODCFG_API_MAXMIND_CITY_ISP  => 21,
        _MI_UHQGEO_MODCFG_API_MAXMIND_CITY      => 22,
        _MI_UHQGEO_MODCFG_API_MAXMIND_COUNTRY   => 23,
        // FreeGeoIP.net Web API
        _MI_UHQGEO_MODCFG_API_FREEGEOIPNET      => 31
    ),
    'default'        => 1
);

// Option 3: Select IPv6 DB Provider

$modversion['config'][] = array (
    'name'          => 'ipv6_prov',
    'title'         => '_MI_UHQGEO_MODCFG_IPV6',
    'description'   => '_MI_UHQGEO_MODCFG_IPV6_DESC',
    'formtype'      => 'select',
    'valuetype'     => 'int',
    'options'       => array (
        _MI_UHQGEO_MODCFG_IPV6_DB_IP2L          => 1,
        // IPInfoDB Web API
        _MI_UHQGEO_MODCFG_API_IPDBV3_COUNTRY    => 15,
        // MaxMind Web API
        _MI_UHQGEO_MODCFG_API_MAXMIND_CITY_ISP  => 21,
        _MI_UHQGEO_MODCFG_API_MAXMIND_CITY      => 22,
        _MI_UHQGEO_MODCFG_API_MAXMIND_COUNTRY   => 23
    ),
    'default'       => 1
);

// Option 4: Print Data Array on Admin Index

$modversion['config'][] = array (
    'name'          => 'geoloc_printr',
    'title'         => '_MI_UHQGEO_MODCFG_PRINTR',
    'description'   => '_MI_UHQGEO_MODCFG_PRINTR_DESC',
    'formtype'      => 'yesno',
    'valuetype'     => 'int',
    'default'       => 0
);

// Option 5: v4 API Key (if Required)

$modversion['config'][] = array (
    'name'          => 'geoloc_apikey',
    'title'         => '_MI_UHQGEO_MODCFG_APIV4KEY',
    'description'   => '_MI_UHQGEO_MODCFG_APIV4KEY_DESC',
    'formtype'      => 'textbox',
    'valuetype'     => 'text',
    'default'       => ''
);

// Option 6: v6 API Key (if Required)

$modversion['config'][] = array (
    'name'          => 'geoloc_apikey_v6',
    'title'         => '_MI_UHQGEO_MODCFG_APIV6KEY',
    'description'   => '_MI_UHQGEO_MODCFG_APIV6KEY_DESC',
    'formtype'      => 'textbox',
    'valuetype'     => 'text',
    'default'       => ''
);

// Option 7: Activate API Cache?

$modversion['config'][] = array (
    'name'          => 'geoloc_cache',
    'title'         => '_MI_UHQGEO_MODCFG_CACHE',
    'description'   => '_MI_UHQGEO_MODCFG_CACHE_DESC',
    'formtype'      => 'yesno',
    'valuetype'     => 'int',
    'default'       => 1
);

// Option 8: API Cache Expiry

$modversion['config'][] = array (
    'name'          => 'geoloc_cacheexpire',
    'title'         => '_MI_UHQGEO_MODCFG_CACHEEXP',
    'description'   => '_MI_UHQGEO_MODCFG_CACHEEXP_DEXC',
    'formtype'      => 'int',
    'valuetype'     => 'int',
    'default'       => 0
);

// Administrative Items

$modversion['hasAdmin']     = 1;
$modversion['adminindex']   = "admin/index.php";
$modversion['adminmenu']    = "admin/menu.php";

// Menu Items

$modversion['hasMain']  = 0;

// Templates

$modversion['templates'][1]['file']         = "admin/uhqgeolocate_index.html";
$modversion['templates'][1]['description']  = _MI_UHQGEO_TEMPLATE_INDEX;

// Blocks

$i=0;
$modversion['blocks'][$i]['file']           = 'uhqgeo_blocks.php';
$modversion['blocks'][$i]['name']           = _MI_UHQGEO_BLOCK_FROM_NAME;
$modversion['blocks'][$i]['description']    = _MI_UHQGEO_BLOCK_FROM_DESC;
$modversion['blocks'][$i]['show_func']      = "b_uhqgeo_from_show";
//$modversion['blocks'][$i]['edit_func']    = "b_uhqgeo_from_edit";
$modversion['blocks'][$i]['template']       = "uhqgeo_from.html";
$modversion['blocks'][$i]['options']        = "";
