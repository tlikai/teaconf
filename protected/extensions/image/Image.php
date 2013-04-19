<?php
/**
 * A simply image processor extension for yii
 *
 * @author likai<youyuge@gmail.com>
 * @link http://www.youyuge.com/
 */

Yii::import('ext.image.*');

class Image extends CComponent
{
    const GD = 'ImageGd';
    const IMAGICK = 'ImageImagick';

    const GIF = IMAGETYPE_GIF;
    const JPG = IMAGETYPE_JPEG;
    const PNG = IMAGETYPE_PNG;

    const AUTO = 'auto';

    public static function factory($file, $driver)
    {
        if(!class_exists($driver))
            throw new CException('Does not exist image driver');
        $instance = new $driver($file);
        if(!$instance instanceof ImageDriver)
            throw new CException('Unknow image driver');
        return $instance;
    }
}
