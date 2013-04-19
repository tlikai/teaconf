<?php
/**
 * A simply image processor extension for yii based GD
 *
 * @author likai<youyuge@gmail.com>
 * @link http://www.youyuge.com/
 */
class ImageGd extends ImageDriver
{
    /**
     * Load the image from file
     *
     * @return void
     */
    protected function load()
    {
        switch($this->type)
        {
            case Image::JPG : 
                $this->image = imagecreatefromjpeg($this->file);
                break;
            case Image::GIF :
                $this->image = imagecreatefromgif($this->file);
                break;
            case Image::PNG:
                $this->image = imagecreatefrompng($this->file);
                break;
            default:
                throw new CException('Does not support image type');
        }
    }

    /**
     * Save the image file
     *
     * @param string $file
     * @param integer $quality jpeg only
     *
     * @return boolean
     */
    public function saveAs($file, $quality = 80)
    {
        if(!is_writable(dirname($file)))
            throw new CException('Unable to write file: ' . $file);
        $error = false;
        switch($this->type)
        {
            case Image::JPG :
                $status = imagejpeg($this->image, $file, $quality);
                break;
            case Image::GIF :
                $status = imagegif($this->image, $file);
                break;
            case Image::PNG : 
                $status = imagepng($this->image, $file);
                break;
        }
        
        return $status;
    }

    /**
     * Resize the image
     *
     * @param mixed $width If given null then width auto, default null
     * @param mixed $height If given null then height auto, default null
     *
     * @return ImageDriver
     */
    public function resize($width = null, $height = null)
    {
        if($width == null && $height == null)
            return $this;
        if($height == Image::AUTO)
        {
            $height = null;
            if($this->width > $this->height)
            {
                $height = $width;
                $width = null;
            }
        }
        if($width == null)
            $width = round($this->width * $height / $this->height);
        if($height == null)
            $height = round($this->height * $width / $this->width);
        $width = min($width, $this->width);
        $height = min($height, $this->height);

        $canvas = $this->createCanvas($width, $height);
        imagecopyresampled($canvas, $this->image, 0, 0, 0, 0, $width, $height, $this->width, $this->height);

        imagedestroy($this->image);
        $this->image = $canvas;
        $this->update();

        return $this;
    }


    /**
     * Crop the image
     *
     * @param integer $width
     * @param integer $height
     *
     * @return ImageDriver
     */
    public function crop($width, $height, $offsetX = null, $offsetY = null)
    {
        $width = min($width, $this->width);
        $height = min($height, $this->height);

        // default center
        $offsetX = $offsetX === null ? round($this->width - $width) / 2 : $offsetX;
        $offsetY = $offsetY === null ? round($this->height - $height) / 2 : $offsetY;

        $canvas = $this->createCanvas($width, $height);
        imagecopyresampled($canvas, $this->image, 0, 0, $offsetX, $offsetY, $width, $height, $width, $height);

        imagedestroy($this->image);
        $this->image = $canvas;
        $this->update();

        return $this;
    }


    /**
     * Create a canvas with the given width and height
     *
     * @param integer $width
     * @param integer $height
     *
     * @return resource
     */
    protected function createCanvas($width, $height)
    {
        $canvas = imagecreatetruecolor($width, $height);
        if($this->type == Image::GIF || $this->type == Image::PNG)
        {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $color = imagecolorallocatealpha($canvas, 0, 0, 0);
            imagefill($canvas, 0, 0, $color);
        }

        return $canvas;
    }

    /**
     * Update the image width and height
     *
     * @return void
     */
    protected function update()
    {
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
    }
}
