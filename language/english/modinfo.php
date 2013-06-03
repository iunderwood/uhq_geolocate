<?php

// Module Information

define("_MI_UHQGEO_NAME","UHQ-GeoLocate");
define("_MI_UHQGEO_DESC","Provide geolocation info per IP");

// Module-Wide Configuration Options

define("_MI_UHQGEO_MODCFG_READY","Enable geolocation services?");
define("_MI_UHQGEO_MODCFG_READY_DESC","Allows geolocation functions to be disabled as needed.");

define("_MI_UHQGEO_MODCFG_IPV4","IPv4 Location Provider");
define("_MI_UHQGEO_MODCFG_IPV4_DESC","Provider of IPv4 Location Information");

define("_MI_UHQGEO_MODCFG_IPV6","IPv6 Location Provider");
define("_MI_UHQGEO_MODCFG_IPV6_DESC","Provider of IPv6 Location Information");

define("_MI_UHQGEO_MODCFG_IPV4_DB_IP2L","DB: IP2Location IPv4 File");
define("_MI_UHQGEO_MODCFG_IPV6_DB_IP2L","DB: IP2Location IPv6 File");

define("_MI_UHQGEO_MODCFG_IPV4_API_IPDB_CITY_TZ","API: IPInfoDB (City + Timezone)");
define("_MI_UHQGEO_MODCFG_IPV4_API_IPDB_CITY","API: IPInfoDB (City)");
define("_MI_UHQGEO_MODCFG_IPV4_API_IPDB_COUNTRY","API: IPInfoDB (Country)");

define("_MI_UHQGEO_MODCFG_IPV4_API_MAXMIND_CITY_ISP","API: MaxMind (City + ISP/Org)");
define("_MI_UHQGEO_MODCFG_IPV4_API_MAXMIND_CITY","API: MaxMind (City)");
define("_MI_UHQGEO_MODCFG_IPV4_API_MAXMIND_COUNTRY","API: MaxMind (Country)");

define("_MI_UHQGEO_MODCFG_PRINTR","Show Diagnostic Array?");
define("_MI_UHQGEO_MODCFG_PRINTR_DESC","Shows a print_r of the data on the admin/index page.");

define("_MI_UHQGEO_MODCFG_APIKEY","API Key");
define("_MI_UHQGEO_MODCFG_APIKEY_DESC","Key required to use IPv4 API provider, if used.");

define("_MI_UHQGEO_MODCFG_CACHE","Cache API Results?");
define("_MI_UHQGEO_MODCFG_CACHE_DESC","Cache web API calls, if used.");

// Admin Menu

define("_MI_UHQGEO_ADMENU_INDEX","Index");

// Templates

define("_MI_UHQGEO_TEMPLATE_INDEX","Admin Main Template");

// Blocks

define("_MI_UHQGEO_BLOCK_FROM_NAME","Your Location");
define("_MI_UHQGEO_BLOCK_FROM_DESC","Show the page viewer where we think they're from.");

?>