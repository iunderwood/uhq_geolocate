<?php

use XoopsModules\Uhqgeolocate;
/** @var Uhqgeolocate\Helper $helper */
$helper = Uhqgeolocate\Helper::getInstance();

function uhq_onupdate_header($header)
{
    echo '<h2>' . $header . '</h2>';
}

function uhq_onupdate_line($linetext)
{
    echo '<p>' . $linetext . '</p>';
}

function xoops_module_update_uhq_geolocate(\XoopsModule $module, $oldversion = null)
{
    global $xoopsDB;

    // Load Language
    if (file_exists(XOOPS_ROOT_PATH . '/modules/uhq_geolocate/language/' . $xoopsConfig['language'] . '/admin.php')) {
        require_once XOOPS_ROOT_PATH . '/modules/uhq_geolocate/language/' . $xoopsConfig['language'] . '/admin.php';
    } else {
        require_once XOOPS_ROOT_PATH . '/modules/uhq_geolocate/language/english/admin.php';
    }

    uhq_onupdate_header(_AM_UHQGEO_UPDATE_HDR);

    // Remove sample files if we've already got them installed.

    $distfile  = XOOPS_ROOT_PATH . '/modules/uhq_geolocate/IP-COUNTRY-SAMPLE.BIN';
    $trustfile = XOOPS_TRUST_PATH . '/IP2LOCATION.BIN';
    if (file_exists($trustfile) && file_exists($distfile)) {
        unlink($distfile);
    }

    $distfile  = XOOPS_ROOT_PATH . '/modules/uhq_geolocate/IPV6-COUNTRY-SAMPLE.BIN';
    $trustfile = XOOPS_TRUST_PATH . '/IP2LOCATION-V6.BIN';
    if (file_exists($trustfile) && file_exists($distfile)) {
        unlink($distfile);
    }

    // Let's Update!

    if ($oldversion < 91) {

        // Add new DB tables into the database

        $query  = 'CREATE TABLE ' . $xoopsDB->prefix('uhqgeolocate_v4cache') . ' (
            ipaddr          INT UNSIGNED,
            hits            INT UNSIGNED,
            countrycode     CHAR(2),
            region          VARCHAR(128),
            city            VARCHAR(128),
            PRIMARY KEY (ipaddr)
            ) ENGINE=MyISAM;';
        $result = $xoopsDB->queryF($query);
        if (!$result) {
            $module->setErrors('Error adding DB table uhqgeolocate_v4cache');

            return false;
        }

        $oldversion = 91;
    }

    if ($oldversion < 92) {

        // Expand DB to include new fields

        $query  = 'ALTER TABLE ' . $xoopsDB->prefix('uhqgeolocate_v4cache') . ' ADD latitude DOUBLE AFTER city';
        $result = $xoopsDB->queryF($query);
        if (!$result) {
            $module->setErrors('Error adding DB latitude field.');

            return false;
        }

        $query  = 'ALTER TABLE ' . $xoopsDB->prefix('uhqgeolocate_v4cache') . ' ADD longitude DOUBLE AFTER latitude';
        $result = $xoopsDB->queryF($query);
        if (!$result) {
            $module->setErrors('Error adding DB longitude field.');

            return false;
        }

        $query  = 'ALTER TABLE ' . $xoopsDB->prefix('uhqgeolocate_v4cache') . ' ADD isp VARCHAR(128) AFTER longitude';
        $result = $xoopsDB->queryF($query);
        if (!$result) {
            $module->setErrors('Error adding DB isp field.');

            return false;
        }

        $query  = 'ALTER TABLE ' . $xoopsDB->prefix('uhqgeolocate_v4cache') . ' ADD org VARCHAR(128) AFTER isp';
        $result = $xoopsDB->queryF($query);
        if (!$result) {
            $module->setErrors('Error adding DB org field.');

            return false;
        }

        $oldversion = 92;
    }

    if ($oldversion < 93) {

        // New field: dateadd
        $query  = 'ALTER TABLE ' . $xoopsDB->prefix('uhqgeolocate_v4cache') . ' ADD dateadd DATE AFTER hits';
        $result = $xoopsDB->queryF($query);
        if (!$result) {
            $module->setErrors('Error adding DB datadd field.');

            return false;
        }

        // Update v4 API description
        $query = 'UPDATE ' . $xoopsDB->prefix('config') . ' WHERE conf_title = "_MI_UHQGEO_MODCFG_APIKEY" SET ';
        $query .= 'conf_title = "_MI_UHQGEO_MODCFG_APIV4KEY", ';
        $query .= 'conf_desc = "_MI_UHQGEO_MODCFG_APIV4KEY_DESC"';

        $result = $xoopsDB->queryF($query);

        if (!$result) {
            $module->setErrors('Error modifying API Key Description');

            return false;
        }

        $oldversion = 93;
    }

    if ($oldversion < 94) {

        // New DB: IPv6 Cache
        $query = 'CREATE TABLE ' . $xoopsDB->prefix('uhqgeolocate_v6cache') . ' (
            v6subnet        CHAR(16),
            hits            INT UNSIGNED,
            dateadd         DATE,
            countrycode     CHAR(2),
            region          VARCHAR(128),
            city            VARCHAR(128),
            latitude        DOUBLE,
            longitude       DOUBLE,
            isp             VARCHAR(128),
            org             VARCHAR(128),
            PRIMARY KEY (v6subnet)
        ) ENGINE=MyISAM;';

        $result = $xoopsDB->queryF($query);

        if (!$result) {
            $module->setErrors('Error modifying API Key Description');

            return false;
        }
        $oldversion = 94;
    }

    if ($oldversion < 96) {
        uhq_onupdate_line('<b>' . _AM_UHQGEO_UPDATE_TO . '0.96</b>');

        // Load module options
//        $moduleHandler     = xoops_getHandler('module');
//        $xoopsModule       = $moduleHandler->getByDirname('uhq_geolocate');
//        $configHandler     = xoops_getHandler('config');
//        $xoopsModuleConfig = $configHandler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

        /** @var Uhqgeolocate\Helper $helper */
        $helper = Uhqgeolocate\Helper::getInstance();

        if ((11 == $helper->getConfig('ipv4_prov')) || (12 == $helper->getConfig('ipv4_prov'))) {
            // Set to 14

            $query = 'UPDATE ' . $xoopsDB->prefix('config') . ' SET ';
            $query .= " conf_value = 14 WHERE conf_name = 'ipv4_prov' AND conf_modid = " . $xoopsModule->getVar('mid');

            $result = $xoopsDB->queryF($query);
            if (!$result) {
                $module->setErrors(_AM_UHQGEO_UPDATE_ERR_LOCV4);

                return false;
            } else {
                uhq_onupdate_line(_AM_UHQGEO_UPDATE_IPV4CHG . _AM_UHQGEO_PROV_P14);
            }
        } elseif (13 == $helper->getConfig('ipv4_prov')) {
            // Set to 15

            $query = 'UPDATE ' . $xoopsDB->prefix('config') . ' SET ';
            $query .= " conf_value = 15 WHERE conf_name = 'ipv4_prov' AND conf_modid = " . $xoopsModule->getVar('mid');

            $result = $xoopsDB->queryF($query);
            if (!$result) {
                $module->setErrors(_AM_UHQGEO_UPDATE_ERR_LOCV4);

                return false;
            } else {
                uhq_onupdate_line(_AM_UHQGEO_UPDATE_IPV4CHG . _AM_UHQGEO_PROV_P15);
            }
        }
    }

    return true;
}
