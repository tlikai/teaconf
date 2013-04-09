<?php
/**
 * description
 *
 * @author likai<youyuge@gmail.com>
 * @link http://www.youyuge.com/
 */

/**
 * Formatter class
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
