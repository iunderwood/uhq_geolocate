<?php

/* maxmindweb.class.php
    Copyright 2010-2013 - Ian A. Underwood
*/

class maxmindweblocation {
    var $country;
    var $region;
    var $regioncode;
    var $city;
    var $postal;
    var $latitude;
    var $longitude;
    var $metrocode;
    var $areacode;
    var $isp;
    var $org;
    var $error;
    var $rawdata;
}

class maxmindweb {
    protected $useCity = false;
    protected $useISP = false;
    protected $key = "";
    protected $resolver = "geoip.maxmind.com";

    var $service = "MaxMind Web API Class";
    var $version = "0.94";

    function setCity() {
        $this->useCity = true;
    }

    function setISP() {
        $this->useISP = true;
    }

    function setOmni() {
        $this->useOmni = true;
    }

    function setKey($key) {
        $this->key = $key;
    }

    function setResolver($resolver) {
        $this->resolver = $resolver;
    }

    function getLocation($ip) {
        if ( filter_var($ip,FILTER_VALIDATE_IP) ) {

            // Determine query type.
            if (!$this->useCity) {
                $type = "a";    // MaxMind Country
            } elseif ($this->useISP) {
                $type = "f";    // MaxMind City+ISP
            } else {
                $type = "b";    // MaxMind City
            }

            // Perform Query
            $query = "http://".$this->resolver."/".$type."?l=".$this->key."&i=".$ip;
            $result = @file_get_contents($query);

            if (!$result)
                return NULL;

            $location = new maxmindweblocation;

            // Process result
            $lines = explode("\n",$result);
            $rawdata = $lines[count($lines)-1];

            $geo = explode(",",$rawdata);

            if (!$this->useCity) {
                // If we've got a comma on the first character, we've got an error in the country data.
                if (strpos($rawdata,",")) {
                    $location->error = $geo[1];
                } else {
                    $location->country = $rawdata;
                }
            } else {
                // Include the region code variables.
                include_once "maxmindregionvars.php";

                $location->country = $geo[0];
                $location->region = $GEOIP_REGION_NAME[$geo[0]][$geo[1]];
                $location->regioncode = $geo[1];
                $location->city = $geo[2];
                if ($this->useISP) {
                    $location->postal = $geo[3];
                    $location->latitude = $geo[4];
                    $location->longitude = $geo[5];
                    $location->metrocode = $geo[6];
                    $location->areacode = $geo[7];
                    $location->isp = trim($geo[8],'"');
                    $location->org = trim($geo[9],'"');
                    $location->error = $geo[10];
                } else {
                    $location->latitude = $geo[3];
                    $location->longitude = $geo[4];
                }
            }

            $location->rawdata = $result;

            return $location;

        } else {
            return NULL;
        }
    }
}
