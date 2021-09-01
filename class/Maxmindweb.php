<?php

namespace XoopsModules\Uhqgeolocate;


/* maxmindweb.class.php
    Copyright 2010-2013 - Ian A. Underwood
*/

class Maxmindweb
{
    protected $useCity  = false;
    protected $useISP   = false;
    protected $key      = '';
    protected $resolver = 'geoip.maxmind.com';
    public $service = 'MaxMind Web API Class';
    public $version = '0.94';

    public function setCity()
    {
        $this->useCity = true;
    }

    public function setISP()
    {
        $this->useISP = true;
    }

    public function setOmni()
    {
        $this->useOmni = true;
    }

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function setResolver($resolver)
    {
        $this->resolver = $resolver;
    }

    public function getLocation($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            // Determine query type.
            if (!$this->useCity) {
                $type = 'a';    // MaxMind Country
            } elseif ($this->useISP) {
                $type = 'f';    // MaxMind City+ISP
            } else {
                $type = 'b';    // MaxMind City
            }

            // Perform Query
            $query  = 'http://' . $this->resolver . '/' . $type . '?l=' . $this->key . '&i=' . $ip;
            $result = @file_get_contents($query);

            if (!$result) {
                return null;
            }

            $location = new MaxmindwebLocation();

            // Process result
            $lines   = explode("\n", $result);
            $rawdata = $lines[count($lines) - 1];

            $geo = explode(',', $rawdata);

            if (!$this->useCity) {
                // If we've got a comma on the first character, we've got an error in the country data.
                if (mb_strpos($rawdata, ',')) {
                    $location->error = $geo[1];
                } else {
                    $location->country = $rawdata;
                }
            } else {
                // Include the region code variables.
                require_once __DIR__ . '/maxmindregionvars.php';

                $location->country    = $geo[0];
                $location->region     = $GEOIP_REGION_NAME[$geo[0]][$geo[1]];
                $location->regioncode = $geo[1];
                $location->city       = $geo[2];
                if ($this->useISP) {
                    $location->postal    = $geo[3];
                    $location->latitude  = $geo[4];
                    $location->longitude = $geo[5];
                    $location->metrocode = $geo[6];
                    $location->areacode  = $geo[7];
                    $location->isp       = trim($geo[8], '"');
                    $location->org       = trim($geo[9], '"');
                    $location->error     = $geo[10];
                } else {
                    $location->latitude  = $geo[3];
                    $location->longitude = $geo[4];
                }
            }

            $location->rawdata = $result;

            return $location;
        }

        return null;
    }
}
