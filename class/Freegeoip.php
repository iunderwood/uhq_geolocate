<?php

namespace XoopsModules\Uhqgeolocate;


// FreeGeoIP.net PHP Class

final class Freegeoip
{
    protected $errors  = [];
    public    $service = 'freegeoip.net';
    public    $version = 'v1';

    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    public function getError()
    {
        return implode("\n", $this->errors);
    }

    public function getGeoLocation($host)
    {
        $ip = @gethostbyname($host);

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $xml = @file_get_contents('http://' . $this->service . '/xml/' . $ip);

            try {
                $response = @new SimpleXMLElement($xml);

                foreach ($response as $field => $value) {
                    $result[(string)$field] = (string)$value;
                }

                return $result;
            } catch (\Exception $e) {
                $result['error'] = $e->getMessage();

                return $result;
            }
        }

        $this->errors[] = '"' . $host . '" is not a valid IP address or hostname.';
    }
}
