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

    public static function fetch($email)
    {
        /**
         * TODO 同步QQ头像
        if(preg_match('/^([1-9][0-9]+@(vip)*qq\.com)|([1-9][0-9]@foxmail.com)$/', $email))
        {
            $qq = substr($email, 0, strpos($email, '@'));
            $avatar = 'http://face7.qun.qq.com/cgi/svr/face/getface?type=1&uin=' . $qq;
            return $avatar;
        }
         */

        $default = urlencode('');
        $email = md5(strtolower($email));
        $url = "http://www.gravatar.com/avatar/$email?d=$default&s=%d";
        $headers = get_headers(sprintf($url, 10), true);
        $type = $headers['Content-Type'];
        if(in_array($type, array('image/jpeg', 'image/png')))
            return array(
                sprintf($url, self::LARGE_SIZE),
                sprintf($url, self::MIDDLE_SIZE),
                sprintf($url, self::SMALL_SIZE),
            );
        return array('', '', '');
    }

}
