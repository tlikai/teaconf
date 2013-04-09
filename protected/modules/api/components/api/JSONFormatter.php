<?php
/**
 * description
 *
 * @author likai<youyuge@gmail.com>
 * @link http://www.youyuge.com/
 */

/**
 * JSONFormatter
 */
class JSONFormatter extends Formatter
{
    public static $mimeType = 'application/json';

    public function encode($data)
    {
        return CJSON::encode($data);
    }

    public function decode($data)
    {
        return CJSON::decode($data);
    }
}
