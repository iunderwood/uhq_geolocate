<?php

use Xmf\Module\Admin;
use Xmf\Request;
use XoopsModules\Uhqgeolocate\{
    Helper,
    Geolocate
};
/** @var Helper $helper */

$path = \dirname(__DIR__, 3);
require_once $path . '/mainfile.php';
require_once $path . '/include/cp_functions.php';
require_once $path . '/include/cp_header.php';

$helper = Helper::getInstance();

require_once $helper->path('includes/countryshort.php');
require_once XOOPS_ROOT_PATH . '/class/template.php';

// If we're using a template, disable the cache.

if (!isset($xoopsTpl)) {
    $xoopsTpl = new \XoopsTpl();
}
$xoopsTpl->caching = 0;

// Functions

function uhqgeo_providername($prov)
{
    switch ($prov) {
        case 1:
            return _AM_UHQGEO_PROV_P1;
            break;
        case 11:
            return _AM_UHQGEO_PROV_P11;
            break;
        case 12:
            return _AM_UHQGEO_PROV_P12;
            break;
        case 13:
            return _AM_UHQGEO_PROV_P13;
            break;
        case 14:
            return _AM_UHQGEO_PROV_P14;
            break;
        case 15:
            return _AM_UHQGEO_PROV_P15;
            break;
        case 21:
            return _AM_UHQGEO_PROV_P21;
            break;
        case 22:
            return _AM_UHQGEO_PROV_P22;
            break;
        case 23:
            return _AM_UHQGEO_PROV_P23;
            break;
        case 31:
            return _AM_UHQGEO_PROV_P31;
            break;
        default:
            return;
    }
}

// Header

require_once __DIR__ . '/admin_header.php';

xoops_cp_header();
$adminObject = Admin::getInstance();

$adminObject->displayNavigation(basename(__FILE__));

// Now the fun begins!

if (Request::hasVar('op', 'REQUEST')) {
    $op = $_REQUEST['op'];
} else {
    $op = 'none';
}

function diagarray()
{
    // Load module options
    //    /** @var \XoopsModuleHandler $moduleHandler */
    $moduleHandler = xoops_getHandler('module');
    //    $xoopsModule       = $moduleHandler->getByDirname('uhqgeolocate');
    //    /** @var \XoopsConfigHandler $configHandler */
    $configHandler = xoops_getHandler('config');
    //    $xoopsModuleConfig = $configHandler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

    /** @var Helper $helper */
    $helper = Helper::getInstance();

    // Return true if geolocation is enabled in the configuration.
    if (1 == $helper->getConfig('geoloc_printr')) {
        return true;
    }

    return false;
}

$geoloc = new Geolocate();

switch ($op) {
    case 'c': // Clear IPv4 Cache
        $dbquery  = 'DELETE FROM ' . $xoopsDB->prefix('uhqgeolocate_v4cache') . ' WHERE ipaddr > 0';
        $dbresult = $xoopsDB->queryF($dbquery);
        if ($dbresult) {
            $data['cachedel'] = 1;
        }
        break;
    case 'd':  // Clear IPv6 Cache
        $dbquery  = 'DELETE FROM ' . $xoopsDB->prefix('uhqgeolocate_v6cache') . '';
        $dbresult = $xoopsDB->queryF($dbquery);
        if ($dbresult) {
            $data['v6cachedel'] = 1;
        }
        break;
    case 'q':    // Answer query form.
        $geoloc->ipin            = $_REQUEST['ipaddr'];
        $query                   = $geoloc->locate();
        $data['q2']              = (array)$geoloc;
        $data['query']           = (array)$query;
        $data['query']['flag']   = mb_strtolower($data['query']['country']);
        $data['query']['ccname'] = $_UHQGEO_CC[$data['query']['country']];
        break;
    default:
        break;
}

$geoloc->ipin = $_SERVER['REMOTE_ADDR'];
$result       = $geoloc->locate();

$data['input'] = (array)$geoloc;

$data['result']           = (array)$result;
$data['result']['flag']   = mb_strtolower($data['result']['country']);
$data['result']['ccname'] = isset($_UHQGEO_CC[$data['result']['country']]) ? $_UHQGEO_CC[$data['result']['country']] : '';

if ($geoloc->geoloc_cache()) {
    $data['cacheactive'] = 1;

    // IPv4 Cache Info
    $dbquery  = 'SELECT count(ipaddr) AS cachemiss, sum(hits) AS cachehits FROM ' . $xoopsDB->prefix('uhqgeolocate_v4cache');
    $dbresult = $xoopsDB->queryF($dbquery);
    if ($dbresult) {
        $row               = $xoopsDB->fetchArray($dbresult);
        $data['cachemiss'] = $row['cachemiss'];
        $data['cachehits'] = $row['cachehits'];
    }

    // IPv6 Cache Info
    $dbquery  = 'SELECT count(v6subnet) AS cachemiss, sum(hits) AS cachehits FROM ' . $xoopsDB->prefix('uhqgeolocate_v6cache');
    $dbresult = $xoopsDB->queryF($dbquery);
    if ($dbresult) {
        $row                 = $xoopsDB->fetchArray($dbresult);
        $data['v6cachemiss'] = $row['cachemiss'];
        $data['v6cachehits'] = $row['cachehits'];
    }
}

$data['v4db']         = (array)$geoloc->dbinfo(4);
$data['v4db']['name'] = uhqgeo_providername($data['v4db']['provider']);

$data['v6db']         = (array)$geoloc->dbinfo(6);
$data['v6db']['name'] = uhqgeo_providername($data['v6db']['provider']);

$xoopsTpl->assign('data', $data);
$xoopsTpl->display('db:admin/uhqgeolocate_index.tpl');

if (diagarray()) {
    echo '<hr><h3>Diagnostic Array</h3><pre>';
    print_r($data);
    echo '</pre>';
}

require_once __DIR__ . '/admin_footer.php';
