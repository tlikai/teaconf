<?php
/**
 * A upload extension for yii
 *
 * @author likai<youyuge@gmail.com>
 * @link http://www.youyuge.com/
 */
class Upload extends CComponent
{
    public $savePath;

    const FOLDER_MODE_DATE = 1;
    const FOLDER_MODE_HASH = 2;
    public $folderMode = self::FOLDER_MODE_HASH;

    public $secureName = true;

    public $allowTypes = array();

    public $checkExtension = true;

    public $maxSize;

    private $_target;

    const ERROR_DISALLOW_TYPE = 1000;
    const ERROR_EXCEED_SIZE = 1001;
    private $_error;

    private $_file;

    public static $errorLabels = array(
        UPLOAD_ERR_OK => 'Uploaded',
        UPLOAD_ERR_INI_SIZE => 'Size exceed in ini',
        UPLOAD_ERR_FORM_SIZE => 'Size exceed in form',
        UPLOAD_ERR_PARTIAL => 'File partially was uploaded',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write',
        self::ERROR_DISALLOW_TYPE => 'Disallow file type',
        self::ERROR_EXCEED_SIZE => 'Size exceed',
    );

    public function __construct($name, $options = array())
    {
        foreach($options as $key => $val)
            $this->$key = $val;

        $this->_target = CUploadedFile::getInstanceByName($name);
    }

    public function validate()
    {
        if($this->_target === null)
            $this->_error = UPLOAD_ERR_NO_FILE;
        elseif($this->_target->hasError)
            $this->_error = $this->_target->error;
        else
        {
            $type = CFileHelper::getMimeType($this->_target->tempName, null, $this->checkExtension);
            if(!in_array($type, $this->allowTypes))
                $this->_error = self::ERROR_DISALLOW_TYPE;
            elseif($this->maxSize < $this->_target->size)
                $this->_error = self::ERROR_EXCEED_SIZE;
        }

        return $this->_error === null;
    }

    public function save()
    {
        $savePath = $this->getSavePath();
        $fileName = $this->getSaveName();
        $this->_file = $savePath . DIRECTORY_SEPARATOR . $fileName;
        return $this->_target->saveAs($this->_file);
    }

    public function getSavePath()
    {
        if(!is_writable($this->savePath))
            throw new CException('Save path not writable');

        if($this->folderMode === self::FOLDER_MODE_DATE)
            $path = date('Y/m/d');
        elseif($this->folderMode === self::FOLDER_MODE_HASH)
        {
            $hash = sha1($this->_target->name);
            $path = substr($hash, 0, 4) . DIRECTORY_SEPARATOR;
            $path .= substr($hash, 10, 4) . DIRECTORY_SEPARATOR;
            $path .= substr($hash, 20, 4);
        }

        $savePath = $this->savePath . DIRECTORY_SEPARATOR . $path;

        if(!is_dir($savePath))
            mkdir($savePath, 0777, true);

        return $savePath;
    }

    public function getSaveName()
    {
        if(!$this->secureName)
            return $this->_target->name;
        return sha1(microtime() . mt_rand(1111, 9999)) . '.' . $this->_target->extensionName;
    }

    public function getFile()
    {
        return $this->_file;
    }

    public function getError()
    {
        return $this->_error === null ? false : self::$errorLabels[$this->_error];
    }

    public function __toString()
    {
        return $this->_file;
    }
}
