<?php
/**
 * AuthManager class file
 *
 * @author likai<youyuge@gmail.com>
 * @link http://www.youyuge.com/
 */

class AuthManager
{

    public $authFile;

    public $showErrors = false;

    private $_items;

    public function init()
    {
		if($this->authFile === null)
			$this->authFile = Yii::getPathOfAlias('application.data.auth').'.php';
        $this->load();
    }

	public function checkAccess($itemName, $userId, $params=array())
    {
        if(!isset($this->_items[$itemName]))
            return false;

        $item = $this->_items[$itemName];
		if(!isset($params['userId']))
		    $params['userId'] = $userId;
        if($this->executeBizRule($item['bizRule'], $params))
            return true;
        return false;
    }

	public function executeBizRule($bizRule, $params)
	{
		return $bizRule==='' || $bizRule===null || ($this->showErrors ? eval($bizRule)!=0 : @eval($bizRule)!=0);
	}

    public function load()
    {
        $this->_items = include $this->authFile;
    }
}
