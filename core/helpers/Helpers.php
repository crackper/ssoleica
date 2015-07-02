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

} 