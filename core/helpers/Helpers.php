<?php namespace SSOLeica\Core\Helpers;
use Carbon\Carbon;

/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 2/07/15
 * Time: 9:43 AM
 */

class Helpers {

    public static function to_timezone($utc,$timezone,$format="Y-m-d H:i:s")
    {
        $carbon = new Carbon($utc,'UTC');
        $carbon->timezone = new \DateTimeZone($timezone);

        return $carbon->format($format);
    }

    public static function to_utc($utc,$timezone='UTC',$format="Y-m-d H:i:s")
    {
        $carbon = new Carbon($utc,$timezone);
        $carbon->timezone = new \DateTimeZone('UTC');

        return $carbon->format($format);
    }

    /*public static  function convertFromUTC($timestamp, $timezone, $format = 'Y-m-d H:i:s')
    {
        $date = new DateTime($timestamp, new DateTimeZone('UTC'));
        $date->setTimezone(new DateTimeZone($timezone));
        return $date->format($format);
    }
    public static  function convertToUTC($timestamp, $timezone, $format = 'Y-m-d H:i:s')
    {
        $date = new DateTime($timestamp, new DateTimeZone($timezone));
        $date->setTimezone(new DateTimeZone('UTC'));
        return $date->format($format);
    }**/

} 