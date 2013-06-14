<?php

// Module Information

define("_MI_UHQGEO_NAME","UHQ_GeoLocate");
define("_MI_UHQGEO_DESC","Provide geolocation information based upon an IP address.");

// Module-Wide Configuration Options

define("_MI_UHQGEO_MODCFG_READY","Enable geolocation services?");
define("_MI_UHQGEO_MODCFG_READY_DESC","Allows geolocation functions to be disabled as needed.");

define("_MI_UHQGEO_MODCFG_IPV4","IPv4 Location Provider");
define("_MI_UHQGEO_MODCFG_IPV4_DESC","Provider of IPv4 Location Information");

define("_MI_UHQGEO_MODCFG_IPV6","IPv6 Location Provider");
define("_MI_UHQGEO_MODCFG_IPV6_DESC","Provider of IPv6 Location Information");

define("_MI_UHQGEO_MODCFG_IPV4_DB_IP2L","DB: IP2Location IPv4 File");
define("_MI_UHQGEO_MODCFG_IPV6_DB_IP2L","DB: IP2Location IPv6 File");

define("_MI_UHQGEO_MODCFG_API_IPDB_CITY_TZ","API: IPInfoDB v2 City + Timezone");
define("_MI_UHQGEO_MODCFG_API_IPDB_CITY","API: IPInfoDB v2 City");
define("_MI_UHQGEO_MODCFG_API_IPDB_COUNTRY","API: IPInfoDB v2 Country");

define("_MI_UHQGEO_MODCFG_API_IPDBV3_CITY","API: IPInfoDB v3 City");
define("_MI_UHQGEO_MODCFG_API_IPDBV3_COUNTRY","API: IPInfoDB v3 Country");

define("_MI_UHQGEO_MODCFG_API_MAXMIND_CITY_ISP","API: MaxMind GeoIP City & ISP/Org (F)");
define("_MI_UHQGEO_MODCFG_API_MAXMIND_CITY","API: MaxMind GeoIP City (B)");
define("_MI_UHQGEO_MODCFG_API_MAXMIND_COUNTRY","API: MaxMind GeoIP Country (A)");
define("_MI_UHQGEO_MODCFG_API_MAXMIND_OMNI","API: MaxMind GeoIP Omni (E)");

define("_MI_UHQGEO_MODCFG_API_FREEGEOIPNET","API: FreeGeoIP.net");

define("_MI_UHQGEO_MODCFG_PRINTR","Show Diagnostic Array?");
define("_MI_UHQGEO_MODCFG_PRINTR_DESC","Shows a print_r of the data on the admin/index page.");

define("_MI_UHQGEO_MODCFG_APIV4KEY","IPv4 API Key");
define("_MI_UHQGEO_MODCFG_APIV4KEY_DESC","Key required to use IPv4 API provider, if used.");

define("_MI_UHQGEO_MODCFG_APIV6KEY","IPv6 API Key");
define("_MI_UHQGEO_MODCFG_APIV6KEY_DESC","Key required to use IPv6 API provider, if used.");

define("_MI_UHQGEO_MODCFG_CACHE","Cache API Results?");
define("_MI_UHQGEO_MODCFG_CACHE_DESC","Cache web API calls, if used.");

define("_MI_UHQGEO_MODCFG_CACHEEXP","Cache Expiry (Days)");
define("_MI_UHQGEO_MODCFG_CACHEEXP_DEXC","The number of days which need to pass before a cache entry is invalid.");

// Admin Menu

define("_MI_UHQGEO_ADMENU_INDEX","GeoLocator");

// Templates

define("_MI_UHQGEO_TEMPLATE_INDEX","Admin Main Template");

// Blocks

define("_MI_UHQGEO_BLOCK_FROM_NAME","Your Location");
define("_MI_UHQGEO_BLOCK_FROM_DESC","Show the page viewer where we think they're from.");

?>