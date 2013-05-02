<?php
/**
 * ActiveRecord
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

class ActiveRecord extends CActiveRecord
{
    public function getFirstError()
    {
        $errors = $this->getErrors();
        $error = array_shift($errors);
        return $error[0];
    }

    public function getIterator()
    {
        $attributes = $this->getIteratorAttributes();
        return new CMapIterator($attributes);
    }

    public function getIteratorAttributes()
    {
        return $this->getAttributes();
    }
}
