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
}

class geolocate {
	var $ipin;
	var $ipout;
	var $ipver;
	
	// Return IP type.  4 for IPv4, 6 for IPv6, 0 for bad IP.
	
	function address_type() {
		$this->ipver = 0;
		if (filter_var($this->ipin,FILTER_VALIDATE_IP,FILTER_FLAG_IPV4)) {
			$this->ipver=4;
			$this->ipout=$this->ipin;
		}
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
			} else {
				$this->ipver=6;
				$this->ipout=$this->ipin;
			}
		}
	}
	
	// True if module is enabled.
	
	function geoloc_ready () {
		// Load module options
		$modhandler			=& xoops_gethandler('module');
		$xoopsModule		=& $modhandler->getByDirname('uhq_geolocate');
		$config_handler		=& xoops_gethandler('config');
		$xoopsModuleConfig	=& $config_handler->getConfigsByCat(0,$xoopsModule->getVar('mid'));

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
		$modhandler			=& xoops_gethandler('module');
		$xoopsModule		=& $modhandler->getByDirname('uhq_geolocate');
		$config_handler		=& xoops_gethandler('config');
		$xoopsModuleConfig	=& $config_handler->getConfigsByCat(0,$xoopsModule->getVar('mid'));

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
		$modhandler			=& xoops_gethandler('module');
		$xoopsModule		=& $modhandler->getByDirname('uhq_geolocate');
		$config_handler		=& xoops_gethandler('config');
		$xoopsModuleConfig	=& $config_handler->getConfigsByCat(0,$xoopsModule->getVar('mid'));

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
		$modhandler			=& xoops_gethandler('module');
		$xoopsModule		=& $modhandler->getByDirname('uhq_geolocate');
		$config_handler		=& xoops_gethandler('config');
		$xoopsModuleConfig	=& $config_handler->getConfigsByCat(0,$xoopsModule->getVar('mid'));

		// Return true if geolocation is enabled in the configuration.
		if ($xoopsModuleConfig['geoloc_apikey']) {
			return $xoopsModuleConfig['geoloc_apikey'];
		} else {
			return false;
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
			case 1:	// IP2Location Binary File
				require_once XOOPS_ROOT_PATH."/modules/uhq_geolocate/class/ip2location.class.php";
				$ipdb = new ip2location;
				
				switch ($ipver) {
					case 4:
						$dbfile = XOOPS_TRUST_PATH.'/IP2LOCATION.BIN';
						break;
					case 6:
						$dbfile = XOOPS_TRUST_PATH.'/IP2LOCATION-V6.BIN';
						break;
				}
				
				if (file_exists($dbfile)) {
					$ipdb->open($dbfile);
					$result['querylib'] = $ipdb->version." / ".$ipdb->unpackMethod;
					$result['dbtype'] = "DB".$ipdb->dbType;
					if ($ipdb->dbYear < 10) {
						$result['dbdate'] = "200";
					} else {
						$result['dbdate'] = "20";
					}
					$result['dbdate'] .= $ipdb->dbYear."-".$ipdb->dbMonth."-".$ipdb->dbDay;
					$result['dbsize'] = $ipdb->dbCount;
				} else {
					$result['error'] = $dbfile;
				}
				break;
			case 11: // IPInfoDB Web API
			case 12:
			case 13:
				$result['querylib'] = "ipinfodb.class";
				$result['dbtype'] = "Web API";
				break;
			case 21:
			case 22:
			case 23:
				require_once XOOPS_ROOT_PATH . "/modules/uhq_geolocate/class/maxmindweb.class.php";
				$ipdb = new maxmindweb;
				
				$result['querylib'] = $ipdb->service." / ".$ipdb->version;
				$result['dbtype'] = "Web API";
				break;
		}
				
		return $result;
	}
	
	// Do a cache lookup.  If it's a hit, return a location object.
	
	private function v4cache_lookup () {
		global $xoopsDB;
		
		$location = new geolocate_record;
		
		$query = "SELECT * FROM ".$xoopsDB->prefix("uhqgeolocate_v4cache")." WHERE ";
		$query .= "ipaddr = '".ip2long($this->ipout)."'";
		
		$result = $xoopsDB->queryF($query);
		
		// Return false if the lookup fails.
		if ($result == false) {
			return false;
		}
		
		if ($row = $xoopsDB->fetchArray($result)) {
			
			// Add a hit to the cache.
			$hitquery = "UPDATE ".$xoopsDB->prefix("uhqgeolocate_v4cache")." SET ";
			$hitquery .= "hits = hits + 1 WHERE ipaddr = '".ip2long($this->ipout)."'";
			$hitresult = $xoopsDB->queryF($hitquery);
			
			$location->country = $row['countrycode'];
			$location->region = $row['region'];
			$location->city = $row['city'];
			$location->latitude = $row['latitude'];
			$location->longitude = $row['longitude'];
			$location->isp = $row['isp'];
			$location->org = $row['org'];
			
			$location->cache = $row['hits']+1;
			
			$location->result = $row;

			// Finally, return the result.
			return $location;
		} else {
			return null;
		}
		
	}
	
	// Do a cache insert.
	
	private function v4cache_insert ($location) {
		global $xoopsDB;
		
		$query = "INSERT INTO ".$xoopsDB->prefix("uhqgeolocate_v4cache")." SET ";
		$query .= "ipaddr = '".ip2long($this->ipout)."', ";
		$query .= "hits = 0, ";
		$query .= "countrycode = '".$location->country."'";
		
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
			$location->error = 1;  // Location Disabled
			return $location;
		}

		// Check IP Address Type
				
		$this->address_type();	
		
		// Query for Location
		
		if ($this->ipver == 0) {
			$location->error = 2;
			return $location;
		}
				
		switch ($this->provider($this->ipver)) {
			case 1:	// IP2Location Binary File
				// Set up Filename
				if ($this->ipver == 4)
					$file = XOOPS_TRUST_PATH.'/IP2LOCATION.BIN';
				if ($this->ipver == 6)
					$file = XOOPS_TRUST_PATH.'/IP2LOCATION-V6.BIN';
			
				if (!file_exists($file)) {
					$location->error = 3;
					return $location;
				}
				
				// Load Class and get results.
				
				require_once XOOPS_ROOT_PATH."/modules/uhq_geolocate/class/ip2location.class.php";
				
				$ipdb = new ip2location;
				$ipdb->open($file);
				$ipdb->nullError = 1;
				$result = $ipdb->getAll($this->ipout);
				
				// Process result

				// Require a valid country code.  Sample data returns "??" or "-" depending on the data set.

				if ( ($result->countryShort[0] >= "A") && ($result->countryShort[0] <= "Z") ) {
					$location->country = $result->countryShort;
					$location->region = $result->region;
					$location->city = $result->city;
					$location->isp = $result->isp;
				}

				$location->result = $result;
				break;
			case 11:	// IPInfoDB Web API
				$timezone = true;
			case 12:
				$citylevel = true;
			case 13:
				// Check Cache.  Return result, if we have one.
				$usecache = $this->geoloc_cache();
				
				if ($usecache) {	
					$cache = $this->v4cache_lookup();
					// Only return if we have an object.  All other errors lead to a lookup.
					if ( is_object($cache) ) {
						return $cache;
					}
				}
				
				// Do Lookup
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
				
				// Put the data in a good format.
				if ( ($result['CountryCode'][0] >= "A") && ($result['CountryCode'][0] <= "Z") ) {
					$location->country = $result['CountryCode'];
					if ($result['RegionName'])
						$location->region = $result['RegionName'];
					if ($result['City'])
						$location->city = $result['City'];
					if ($result['Latitude'] != null)
						$location->latitude = $result['Latitude'];
					if ($result['Longitude'] != null)
						$location->longitude = $result['Longitude'];
						
					// Insert into cache if we're using it.				
					if ($usecache) {
						$this->v4cache_insert($location);
					}
				}
								
				// Append raw lookup result;
				$location->result = $result;
				break;
			case 21:
				$isporg = true;
			case 22:
				$usecity = true;
			case 23:
				// Check Cache.  Return result, if we have one.
				$usecache = $this->geoloc_cache();
				
				if ($usecache) {	
					$cache = $this->v4cache_lookup();
					// Only return if we have an object.  All other errors lead to a lookup.
					if ( is_object($cache) ) {
						return $cache;
					}
				}
			
				// Prepare Lookup
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
				
					// Insert into cache if we're using it.				
					if ($usecache) {
						$this->v4cache_insert($location);
					}
				}
				
				// Append lookup result
				$location->result = $result;
				break;
		}
		
		// Return if we have errors.
				
		return $location;	
			
	}
	
}

?>