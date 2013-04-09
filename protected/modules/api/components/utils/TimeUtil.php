<?php
/**
 * TimeUtil class file.
 *
 * @author likai<youyuge@gmail.com>
 * @link http://www.youyuge.com/
 */

/**
 * TimeUtil class
 *
 * @author likai<youyuge@gmail.com>
 * @version $Id$
 */
class TimeUtil
{
    const FORMAT_AGO = 'ago';
    const FORMAT_RFC = 'rfc';

    /**
     * 格式化时间戳
     *
     * @static
     * @access public
     * @param integer $timestamp
     * @return string
     */
    public static function format($timestamp, $format = null)
    {
        static $unit = array(0 => '秒', 60 => '分钟', 3600 => '小时', 86400 => '天', 2592000 => '月', 31104000 => '年');
        $format = $format === null ? $format = Yii::app()->params['time']['format'] : $format;
        if($format == self::FORMAT_AGO)
        {
            $time = time() - $timestamp;
            $divisor = 0;
            if($time >= 60)
                $divisor = 60;
            if($time >= 3600)
                $divisor = 3600;
            if($time >= 86400)
                $divisor = 86400;
            if($time >= 2592000)
                $divisor = 2592000;
            if($time >= 31104000)
                $divisor = 31104000;
            return ($divisor > 0 ? round($time / $divisor) : $time) . $unit[$divisor] . '前';
        }
        elseif($format == self::FORMAT_RFC) {
            return date('D, j M Y H:i:s', $time)
        }
        else
            return date($timestamp, $format);
    }

    /**
     * 中文星期
     * 
     * @param int $week
     * @return string
     */
    public static function chineseWeek($week = null) {
        static $map = array('星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六');
        return $map[$week ? $week : date('w', time())];
    }
}
