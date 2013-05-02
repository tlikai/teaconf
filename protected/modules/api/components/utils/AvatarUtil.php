<?php
/**
 * AvatarUtil
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

class AvatarUtil
{
    const LARGE = 'large';
    const MIDDLE = 'middle';
    const SMALL = 'small';

    const LARGE_SIZE = '100';
    const MIDDLE_SIZE = '48';
    const SMALL_SIZE = '24';

    public static function gavatar($email)
    {
        $default = Yii::app()->params->user['defaultAvatar'];
        $email = md5(strtolower($email));
        $url = "http://www.gravatar.com/avatar/$email?d=$default&s=%d";
        return array(
            sprintf($url, self::SMALL_SIZE),
            sprintf($url, self::MIDDLE_SIZE),
            sprintf($url, self::LARGE_SIZE),
        );
    }

    public static function absoluteUrl($url)
    {
        if(strncmp($url, 'http://', 7) == 0)
            return $url;
        return Yii::app()->createAbsoluteUrl($url);
    }
}
