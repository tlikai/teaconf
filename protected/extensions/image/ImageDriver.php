<?php
/**
 * A simply image processor extension for yii
 *
 * @author likai<youyuge@gmail.com>
 * @link http://www.youyuge.com/
 */
abstract class ImageDriver extends CComponent
{
    protected $file;
    protected $image;
    public $width;
    public $height;
    public $type;
    public $mimeType;

    public function __construct($file)
    {
        if(!is_readable($file))
            throw new CException('Unable to read file: ' . $file);
        $image = getimagesize($file);
        $this->file = $file;
        $this->width = $image[0];
        $this->height = $image[1];
        $this->type = $image[2];
        $this->mimeType = $image['mime'];
        $this->load();
    }

    abstract protected function load();
    abstract public function saveAs($file, $quality);

    abstract public function resize($width, $height);
    abstract public function crop($width, $height);

    public function __destruct()
    {
        is_resource($this->image) && imagedestroy($this->image);
    }
}
