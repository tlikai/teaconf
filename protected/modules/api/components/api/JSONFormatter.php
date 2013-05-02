<?php
/**
 * JSONFormatter
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
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
