<?php
/**
 * Formatter
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

abstract class Formatter
{
    const XML = 'xml';
    const JSON = 'json';

    public static $formatters = array(
        self::XML => 'XMLFormatter',
        self::JSON => 'JSONFormatter',
    );

    public static function factory($format)
    {
        if(isset(self::$formatters[$format]))
        {
            $formatter = self::$formatters[$format];
            return new $formatter();
        }
        throw new CException('Not found formatter: ' . $formatter);
    }

    public abstract function encode($data);
    public abstract function decode($data);
}
