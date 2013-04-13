<?php
/**
 * WebUser class
 *
 * @author likai<youyuge@gmail.com>
 * @link http://www.youyuge.com/
 */

class WebUser extends CWebUser
{
	public function requirePermission($operation, $params=array(), $allowCaching = true)
    {
        if(!$this->checkAccess($operation, $params, $allowCaching))
            Response::unAuthorized();
    }
}
