<?php

class geolocate_record {
    var $country;
    var $region;
    var $city;
    var $latitude;
    var $longitude;
    var $isp;
    var $org;
    var $cache;
    var $error;
    var $error_text;
}

class geolocate {
    var $ipin;
    var $ipout;
    var $ipver;

    // Return IP type.  4 for IPv4, 6 for IPv6, 0 for bad IP.
    function address_type() {
        $this->ipver = 0;

        // IPv4 addresses are easy-peasy
        if (filter_var($this->ipin,FILTER_VALIDATE_IP,FILTER_FLAG_IPV4)) {
            $this->ipver=4;
            $this->ipout=$this->ipin;
        }

        // IPv6 is at least a little more complex.
        if (filter_var($this->ipin,FILTER_VALIDATE_IP,FILTER_FLAG_IPV6)) {

            // Look for embedded IPv4 in an embedded IPv6 address, where FFFF is appended.
            if (strpos($this->ipin,"::FFFF:") === 0) {
                $ipv4addr = substr($this->ipin,7);
                if (filter_var($ipv4addr,FILTER_VALIDATE_IP,FILTER_FLAG_IPV4)) {
                    $this->ipver=4;
                    $this->ipout=$ipv4addr;
                }

            // Look for an IPv4 address embedded as ::x.x.x.x
            } else if (strpos($this->ipin,"::") === 0) {
                $ipv4addr = substr($this->ipin,2);
                if (filter_var($ipv4addr,FILTER_VALIDATE_IP,FILTER_FLAG_IPV4)) {
                    $this->ipver=4;
                    $this->ipout=$ipv4addr;
                }

            // Otherwise, assume this an IPv6 address.
            } else {
                $this->ipver=6;
                $this->ipout=$this->ipin;
            }
        }
    }

    // Returns the first 16 hex characters of an IPv6 address.
    function v6subnet() {
        $v6packed = null;

        foreach(str_split(inet_pton($this->ipout)) as $char)
            $v6packed .= str_pad(dechex(ord($char)), 2, '0', STR_PAD_LEFT);

        return substr($v6packed,0,16);
    }

    // True if module is enabled.
    function geoloc_ready () {
        // Load module options
        $modhandler            =& xoops_gethandler('module');
        $xoopsModule        =& $modhandler->getByDirname('uhq_geolocate');
        $config_handler        =& xoops_gethandler('config');
        $xoopsModuleConfig    =& $config_handler->getConfigsByCat(0,$xoopsModule->getVar('mid'));

        // Return true if geolocation is enabled in the configuration.
        if ($xoopsModuleConfig['geoloc_ready'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    // True if caching is enabled
    function geoloc_cache () {
        // Load module options
        $modhandler            =& xoops_gethandler('module');
        $xoopsModule        =& $modhandler->getByDirname('uhq_geolocate');
        $config_handler        =& xoops_gethandler('config');
        $xoopsModuleConfig    =& $config_handler->getConfigsByCat(0,$xoopsModule->getVar('mid'));

        // Return true if geolocation is enabled in the configuration.
        if ($xoopsModuleConfig['geoloc_cache'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    // Return the provider ID configured in the module for a given IP version.
    function provider ($ipver) {
        // Load module options
        $modhandler            =& xoops_gethandler('module');
        $xoopsModule        =& $modhandler->getByDirname('uhq_geolocate');
        $config_handler        =& xoops_gethandler('config');
        $xoopsModuleConfig    =& $config_handler->getConfigsByCat(0,$xoopsModule->getVar('mid'));

        // Return true if geolocation is enabled in the configuration.
        if ($ipver == 4) {
            return $xoopsModuleConfig['ipv4_prov'];
        }
        if ($ipver == 6) {
            return $xoopsModuleConfig['ipv6_prov'];
        }

        return false;
    }

    // Get the API Key if we need it for the provider being used.
    function apikey () {
        // Load module options
        $modhandler            =& xoops_gethandler('module');
        $xoopsModule        =& $modhandler->getByDirname('uhq_geolocate');
        $config_handler        =& xoops_gethandler('config');
        $xoopsModuleConfig    =& $config_handler->getConfigsByCat(0,$xoopsModule->getVar('mid'));

        // Return a key, if we have one.
        if ($this->ipver == 4) {
            return $xoopsModuleConfig['geoloc_apikey'];
        } else {
            return $xoopsModuleConfig['geoloc_apikey_v6'];

            return false;
        }
    }

    // Get the cache expire time in days
    function geoloc_cacheexpire () {
        // Load module options
        $modhandler            =& xoops_gethandler('module');
        $xoopsModule        =& $modhandler->getByDirname('uhq_geolocate');
        $config_handler        =& xoops_gethandler('config');
        $xoopsModuleConfig    =& $config_handler->getConfigsByCat(0,$xoopsModule->getVar('mid'));

        // Return value of days for cache expiration.
        if ($xoopsModuleConfig['geoloc_cacheexpire']) {
            return $xoopsModuleConfig['geoloc_cacheexpire'];
        } else {
            return 0;
        }
    }

    // Return any DB information we may have for a given IP version
    function dbinfo ($ipver) {
        $result = array();

        // Get Provider
        $provider = $this->provider($ipver);

        if ($provider === false) return NULL;

        $result['provider'] = $provider;

        // Get info
        switch ($provider) {

            // IP2Location Binary File
            case 1:
                require_once XOOPS_ROOT_PATH."/modules/uhq_geolocate/class/ip2location.class.php";
                switch ($ipver) {
                    case 4:
                        $dbfile = XOOPS_TRUST_PATH.'/IP2LOCATION.BIN';
                        break;
                    case 6:
                        $dbfile = XOOPS_TRUST_PATH.'/IP2LOCATION-V6.BIN';
                        break;
                }
                if (file_exists($dbfile)) {
                    $ipdb = new IP2Location ($dbfile);
                    $result['querylib'] = "7.0.0";
                    $result['dbtype'] = "DB".$ipdb->database['type'];
                    if ($ipdb->database['year'] < 10) {
                        $result['dbdate'] = "200";
                    } else {
                        $result['dbdate'] = "20";
                    }
                    $result['dbdate'] .= $ipdb->database['year']."-".$ipdb->database['month']."-".$ipdb->database['day'];
                    $result['dbsize'] = "v4: ".$ipdb->database['ipv4_count']." / v6: ".$ipdb->database['ipv6_count'];
                } else {
                    $result['error'] = $dbfile;
                }
                break;

            // IPInfoDB Web API v2
            case 11:
            case 12:
            case 13:
                require_once XOOPS_ROOT_PATH . "/modules/uhq_geolocate/class/ipinfodb.class.php";
                $ipdb = new ipinfodb;
                $result['querylib'] = $ipdb->service." / ".$ipdb->version;
                $result['dbtype'] = "Web API";
                break;

            // IPInfoDB Web API v3
            case 14:
            case 15:
                require_once XOOPS_ROOT_PATH . "/modules/uhq_geolocate/class/ip2locationlite.class.php";
                $ipdb = new ip2location_lite;
                $result['querylib'] = $ipdb->service." / ".$ipdb->version;
                $result['dbtype'] = "Web API";
                break;

            // MaxMind Web API
            case 21:
            case 22:
            case 23:
                require_once XOOPS_ROOT_PATH . "/modules/uhq_geolocate/class/maxmindweb.class.php";
                $ipdb = new maxmindweb;
                $result['querylib'] = $ipdb->service." / ".$ipdb->version;
                $result['dbtype'] = "Web API";
                break;

            // PreeGeoIP.net API
            case 31:
                require_once XOOPS_ROOT_PATH . "/modules/uhq_geolocate/class/freegeoipnet.class.php";
                $ipdb = new freegeoip;
                $result['querylib'] = $ipdb->service." / ".$ipdb->version;
                $result ['dbtype'] = "Web API";
                break;
        }

        $ipdb = null;

        return $result;
    }

    // Do a cache lookup.  If it's a hit, increment the hit counter and return a location object.
    private function cache_lookup () {
        global $xoopsDB;

        $location = new geolocate_record;

        // Set our query for IPv4 lookups
        if ($this->ipver == 4) {
            $query = "SELECT * FROM ".$xoopsDB->prefix("uhqgeolocate_v4cache")." WHERE ";
            $query .= "ipaddr = '".ip2long($this->ipout)."'";
        }

        // Set our query for IPv6 lookups
        if ($this->ipver == 6) {
            $query = "SELECT * FROM ".$xoopsDB->prefix("uhqgeolocate_v6cache")." WHERE ";
            $query .= "v6subnet = '".$this->v6subnet()."'";
         }

        // Limit Result to cache expiration
        $cacheexpire = $this->geoloc_cacheexpire();
        if ($cacheexpire) {
            $query .= " AND DATEDIFF (NOW(), dateadd) < ".$cacheexpire;
        }

        $result = $xoopsDB->queryF($query);

        // Return false if the lookup fails.
        if ($result == false) {
            return false;
        }

        if ($row = $xoopsDB->fetchArray($result)) {

            // Set up the cache query.
            if ($this->ipver == 4) {
                $hitquery = "UPDATE ".$xoopsDB->prefix("uhqgeolocate_v4cache")." SET ";
                $hitquery .= "hits = hits + 1 WHERE ipaddr = '".ip2long($this->ipout)."'";
            }
            if ($this->ipver == 6) {
                $hitquery = "UPDATE ".$xoopsDB->prefix("uhqgeolocate_v6cache")." SET ";
                $hitquery .= "hits = hits +1 WHERE v6subnet = '".$this->v6subnet()."'";
            }

            // Add a hit to the cache.
            $hitresult = $xoopsDB->queryF($hitquery);

            // Put result into the location object.
            $location->country = $row['countrycode'];
            $location->region = $row['region'];
            $location->city = $row['city'];
            $location->latitude = $row['latitude'];
            $location->longitude = $row['longitude'];
            $location->isp = $row['isp'];
            $location->org = $row['org'];

            $location->cache = $row['hits']+1;

            $location->cacheresult = $row;

            // Finally, return the result.
            return $location;
        } else {
            return null;
        }

    }

    // Do a cache insert.

    private function cache_insert ($location) {
        global $xoopsDB;

        // Do not save if there is an error code set.
        if ($location->error) {
            return false;
        }

        // Set up insert query for IPv4 DB.
        if ($this->ipver == 4) {
            // Remove any expired entries
            $query = "DELETE FROM ".$xoopsDB->prefix("uhqgeolocate_v4cache")." WHERE ipaddr ='".ip2long($this->ipout)."'";
            $result = $xoopsDB->queryF($query);
            // Insert new entry
            $query = "INSERT INTO ".$xoopsDB->prefix("uhqgeolocate_v4cache")." SET ";
            $query .= "ipaddr = '".ip2long($this->ipout)."', ";
        }
        if ($this->ipver == 6) {
            // Remove any expire entries
            $query = "DELETE FROM ".$xoopsDB->prefix("uhqgeolocate_v6cache")." WHERE v6subnet ='".$this->v6subnet()."'";
            $result = $xoopsDB->queryF($query);
            // Insert new entry
            $query = "INSERT INTO ".$xoopsDB->prefix("uhqgeolocate_v6cache")." SET ";
            $query .= "v6subnet = '".$this->v6subnet()."', ";
        }

        $query .= "hits = 0, dateadd = DATE(NOW())";
        $query .= ", countrycode = '".$location->country."'";

        // Only add to the query if the variable is not empty.
        if ($location->region)
            $query .= ", region = '".$location->region."'";
        if ($location->city)
            $query .= ", city = '".$location->city."'";
        if ($location->latitude)
            $query .= ", latitude = '".$location->latitude."'";
        if ($location->longitude)
            $query .= ", longitude = '".$location->longitude."'";
        if ($location->isp)
            $query .= ", isp = '".$location->isp."'";
        if ($location->org)
            $query .= ", org = '".$location->org."'";

        $result = $xoopsDB->queryF($query);

        // Return false on query error.
        if ($result == false) {
            return false;
        }

        return true;
    }

    // The Actual Lookup

    public function locate () {
        $location = new geolocate_record;

        // Make sure the module is enabled.

        if ($this->geoloc_ready() === false) {
            $location->error = 1;    // Location Disabled
            return $location;
        }

        // Check IP Address Type
        $this->address_type();

        // Query for Location
        if ($this->ipver == 0) {
            $location->error = 2;    // Invalid IP
            return $location;
        }

        // Use the cache if we have it and the provider can use it.
        if ($this->geoloc_cache()) {
            switch ($this->provider($this->ipver)) {
                case 1:
                    break;
                default:
                    $cache = $this->cache_lookup();
                    // Only return if we have an object.  All other errors lead to a lookup.
                    if ( is_object($cache) ) {
                        return $cache;
                    }
            }
        }

        // Process a lookup.
        switch ($this->provider($this->ipver)) {

            // IP2Location Binary File
            case 1:
                require_once XOOPS_ROOT_PATH."/modules/uhq_geolocate/class/ip2location.class.php";
                // Set up Filename
                if ($this->ipver == 4)
                    $file = XOOPS_TRUST_PATH.'/IP2LOCATION.BIN';
                if ($this->ipver == 6)
                    $file = XOOPS_TRUST_PATH.'/IP2LOCATION-V6.BIN';
                if (!file_exists($file)) {
                    $location->error = 3;

                    return $location;
                }
                $ipdb = new IP2Location ($file);

                $result = $ipdb->lookup($this->ipout);

                // Require a valid country code.  Sample data returns "??" or "-" depending on the data set.
                if ( ($result->countryCode[0] >= "A") && ($result->countryCode[0] <= "Z") ) {
                    $location->country = $result->countryCode;

                    $location->region = $result->regionName;
                    $location->city = $result->cityName;
                    $location->isp = $result->isp;
                    $location->org = $result->domainName;
                    $location->latitude = $result->latitude;
                    $location->longitude = $result->longitude;
                } else {
                    $location->error = 4;
                }

                $location->rawresult = $result;
                break;

            // IPInfoDB Web API - Depreciated
            case 11:
                $timezone = true;
            case 12:
                $citylevel = true;
            case 13:
                require_once XOOPS_ROOT_PATH."/modules/uhq_geolocate/class/ipinfodb.class.php";
                $ipdb = new ipinfodb;
                $ipdb->setKey($this->apikey());
                // If we're using city-level queries, we need to check that
                if (isset($citylevel)) {
                    $ipdb->doCity();
                    // We can set timezone lookip in the API, but it's not really used.
                    if (isset($timezone)) $ipdb->showTimezone();
                }
                $result = $ipdb->getGeoLocation($this->ipout);

                // Result is valid if we have a country code.
                if ( ($result['CountryCode'][0] >= "A") && ($result['CountryCode'][0] <= "Z") ) {
                    $location->country = $result['CountryCode'];

                    // Add other variables if we have them.
                    if ($result['RegionName'])
                        $location->region = $result['RegionName'];
                    if ($result['City'])
                        $location->city = $result['City'];
                    if ($result['Latitude'] != null)
                        $location->latitude = $result['Latitude'];
                    if ($result['Longitude'] != null)
                        $location->longitude = $result['Longitude'];
                } else {
                    $location->error = 4;
                }
                break;

            // IPInfoDB v3
            case 14:
                $citylevel = true;
            case 15:
                require_once XOOPS_ROOT_PATH."/modules/uhq_geolocate/class/ip2locationlite.class.php";
                $ipdb = new ip2location_lite;
                $ipdb->setKey($this->apikey());
                if (isset($citylevel)) {
                    $result = $ipdb->getCity($this->ipout);
                } else {
                    $result = $ipdb->getCountry($this->ipout);
                }
                // Result is valid if we have a country code.
                if ( ($result['countryCode'][0] >= "A") && ($result['countryCode'][0] <= "Z") ) {
                    $location->country = $result['countryCode'];
                    // Add other variables if we have them.
                    if ($result['regionName'])
                        $location->region = ucwords(strtolower($result['regionName']));
                    if ($result['cityName'])
                        $location->city = ucwords(strtolower($result['cityName']));
                    if ($result['latitude'] != null)
                        $location->latitude = $result['latitude'];
                    if ($result['longitude'] != null)
                        $location->longitude = $result['longitude'];
                } else {
                    $location->error=4;
                    $location->error_text = $result['statusMessage'];
                }
                break;

            // MaxMind Web API
            case 21:
                $isporg = true;
            case 22:
                $usecity = true;
            case 23:
                require_once XOOPS_ROOT_PATH . "/modules/uhq_geolocate/class/maxmindweb.class.php";
                $ipdb = new maxmindweb;
                $ipdb->setKey($this->apikey());
                // Set options.
                if (isset($usecity)) {
                    $ipdb->setCity();
                    if (isset($isporg)) {
                        $ipdb->setISP();
                    }
                }
                $result = $ipdb->getLocation($this->ipout);

                // Interpret data.
                if ( ($result->country[0] >= "A") && ($result->country[0] <= "Z") ) {
                    $location->country = $result->country;
                    $location->region = $result->region;
                    $location->city = $result->city;
                    $location->latitude = $result->latitude;
                    $location->longitude = $result->longitude;
                    $location->isp = $result->isp;
                    $location->org = $result->org;
                } else {
                    $location->error=4;
                    $location->error_text = $result->error;
                }
                break;

            // FreeGeoIP.net - No API Key Required
            case 31:
                require_once XOOPS_ROOT_PATH."/modules/uhq_geolocate/class/freegeoipnet.class.php";
                $ipdb = new freegeoip;

                $result = $ipdb->getGeoLocation($this->ipout);

                // Result is valid if we have a country code.
                if ( ($result['CountryCode'][0] >= "A") && ($result['CountryCode'][0] <= "Z") ) {
                    $location->country = $result['CountryCode'];
                    // Add other variables if we have them.
                    if ($result['RegionName'])
                        $location->region = ucwords(strtolower($result['RegionName']));
                    if ($result['City'])
                        $location->city = ucwords(strtolower($result['City']));
                    if ($result['Latitude'] != null)
                        $location->latitude = $result['Latitude'];
                    if ($result['Longitude'] != null)
                        $location->longitude = $result['Longitude'];
                } else {
                    $location->error=4;
                    $location->error_text = $result['error'];
                }
                break;
        }

        // Insert into the cache if we use it.
        if ($this->geoloc_cache()) {
            switch ($this->provider($this->ipver)) {
                case 1:
                    break;
                default:
                    $this->cache_insert($location);
                    // Append raw lookup result
                    $location->lookupresult = $result;
            }
        }

        // Return with the location object!
        return $location;
    }
}
