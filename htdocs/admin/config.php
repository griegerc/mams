<?php

require_once(dirname(dirname(__FILE__)) . '/Gpf/init.php');

if (Gpf_Config::get('ENVIRONMENT') != 'development') {
    require_once('auth.php');
}

session_start();

$env = new Gpf_Env();
$db = Gpf_Database::getInstance();
$t = Gpf_Translation::getInstance();

class Admin
{
    /**
     * Fetches the html head
     * @return string
     */
    public static function getHead()
    {
        return '
            <head>
                <title>Admin area</title>
                <meta name="viewport" content="width=device-width, initial-scale=1"/>
                <meta name="apple-mobile-web-app-capable" content="yes"/>
                <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
                <link rel="stylesheet" type="text/css" href="/css/admin.css"/>
            </head>';
    }

    /**
    * Format an interval value with the requested granularity.
    * @param int $seconds The length of the interval in seconds.
    * @param int $granularity How many different units to display in the string.
    * @return string
    */
    public static function getInterval($seconds, $granularity = 2)
    {
      $units = array(
            '1 year|:count years' => 31536000,
            '1 week|:count weeks' => 604800,
            '1 day|:count days' => 86400,
            '1 hour|:count hours' => 3600,
            '1 min|:count min' => 60,
            '1 sec|:count sec' => 1);
      $output = '';
      foreach ($units as $key => $value) {
            $key = explode('|', $key);
            if ($seconds >= $value) {
                 $count = floor($seconds / $value);
                 $output .= ($output ? ' ' : '');
                 if ($count == 1) {
                      $output .= $key[0];
                 } else {
                      $output .= str_replace(':count', $count, $key[1]);
                 }
                 $seconds %= $value;
                 $granularity--;
            }
            if ($granularity == 0) {
                 break;
            }
      }

      return $output ? $output : '0 sec';
    }
}
