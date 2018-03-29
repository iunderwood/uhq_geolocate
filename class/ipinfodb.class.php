<?php

final class ipinfodb
{
    protected $errors       = [];
    protected $useCity      = false;
    protected $showTimezone = false;
    protected $apiKey       = '';
    public $service      = 'api.ipinfodb.com';
    public $version      = 'v2';

    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    public function setKey($key)
    {
        if (!empty($key)) {
            $this->apiKey = $key;
        }
    }

    public function doCity()
    {
        $this->useCity = true;
    }

    public function showTimezone()
    {
        $this->showTimezone = true;
    }

    public function getError()
    {
        return implode("\n", $this->errors);
    }

    public function getGeoLocation($host)
    {
        $ip = @gethostbyname($host);

        if (preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $ip)) {
            if (!$this->useCity) {
                $xml = @file_get_contents('http://' . $this->service . '/' . $this->version . '/' . 'ip_query_country.php?key=' . $this->apiKey . '&ip=' . $ip);
            } elseif ($this->showTimezone) {
                $xml = @file_get_contents('http://' . $this->service . '/' . $this->version . '/' . 'ip_query.php?key=' . $this->apiKey . '&ip=' . $ip . '&timezone=true');
            } else {
                $xml = @file_get_contents('http://' . $this->service . '/' . $this->version . '/' . 'ip_query.php?key=' . $this->apiKey . '&ip=' . $ip);
            }

            try {
                $response = @new SimpleXMLElement($xml);

                foreach ($response as $field => $value) {
                    $result[(string)$field] = (string)$value;
                }

                return $result;
            } catch (\Exception $e) {
                $this->errors[] = $e->getMessage();

                return;
            }
        }

        $this->errors[] = '"' . $host . '" is not a valid IP address or hostname.';

        return;
    }
}
