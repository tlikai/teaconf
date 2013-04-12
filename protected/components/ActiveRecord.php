<?php
/**
 * ActiveRecord class file.
 *
 * @author likai<youyuge@gmail.com>
 * @link http://www.youyuge.com/
 */

/**
 * ActiveRecord based class
 *
 * @author likai<youyuge@gmail.com>
 * @version $Id$
 */
class ActiveRecord extends CActiveRecord
{
    public function getErrorMessage()
    {
        $errors = $this->getErrors();
        $error = array_shift($errors);
        return $error[0];
    }

    public function createDataProvider($config = array())
    {
        if(!empty($config['criteria']))
        {
            $this->getDbCriteria()->mergeWith($config['criteria']);
            $config['criteria'] = $this->getDbCriteria();
        }
        return new ActiveDataProvider($this, $config);
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
