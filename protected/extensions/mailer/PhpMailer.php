<?php
/**
 * A smtp extension for yii
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

Yii::import('ext.mailer.Mailer');

class PhpMailer extends Mailer
{
    public function send($to, $subject, $message)
    {
        $to = is_array($to) ? implode(';', $to) : $to;
        $headers = implode($this->crlf, $this->headers);
        return mail($to, $subject, $message, $headers);
    }
}
