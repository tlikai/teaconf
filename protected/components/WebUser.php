<?php
/**
 * UserIdentity
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

class WebUser extends CWebUser
{
	public function requirePermission($operation, $params = array(), $allowCaching = true)
    {
        if(!$this->checkAccess($operation, $params, $allowCaching))
            Response::unAuthorized();
    }
}
