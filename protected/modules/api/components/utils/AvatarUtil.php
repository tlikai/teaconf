<?php
/**
 * AvatarUtil class file
 *
 * @author likai<youyuge@gmail.com>
 * @link http://www.youyuge.com/
 */

class AvatarUtil
{
    const LARGE = 'large';
    const MIDDLE = 'middle';
    const SMALL = 'small';

    const LARGE_SIZE = '100';
    const MIDDLE_SIZE = '48';
    const SMALL_SIZE = '48';

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

}
