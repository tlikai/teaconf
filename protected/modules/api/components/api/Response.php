<?php
/**
 * Response
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

class Response extends CComponent
{
    public static $statusLabels = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => '(Unused)',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
    );

    public function __construct($status, $body, $format = Formatter::JSON)
    {
        $label = self::$statusLabels[$status];
        
        $formatter = Formatter::factory($format);
        header("HTTP/1.1 {$status} {$label}");
        header("Content-Type: {$formatter::$mimeType}");

        $body = empty($body) ? null : is_string($body) ? $body : $formatter->encode($body);
        Yii::app()->end($body);
    }

    public static function ok($body = null)
    {
        new self(200, $body);
    }

    public static function created($body = null)
    {
        new self(201, $body);
    }

    public static function updated($body = null)
    {
        self::ok($body);
    }

    public static function deleted($body = null)
    {
        new self(204, $body);
    }

    public static function badRequest($body = null)
    {
        new self(400, $body);
    }

    public static function unAuthorized($body = null)
    {
        new self(401, $body);
    }

    public static function forbidden($body = null)
    {
        new self(403, $body);
    }

    public static function notFound($body = null)
    {
        new self(404, $body);
    }

    public static function serverError($body = null)
    {
        new self(500, $body);
    }
}
