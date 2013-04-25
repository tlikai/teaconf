<?php
/**
 * Controller class file.
 *
 * @author likai<youyuge@gmail.com>
 * @link http://www.youyuge.com/
 */

/**
 * Controller based class
 *
 * @author likai<youyuge@gmail.com>
 * @version $Id$
 */
class Controller extends CController
{
	/**
	 * Returns the request parameters that will be used for action parameter binding.
	 * By default, this method will return $_GET. You may override this method if you
	 * want to use other request parameters (e.g. $_GET+$_POST).
	 * @return array the request parameters to be used for action parameter binding
	 * @since 1.1.7
	 */
	public function getActionParams()
	{
        static $params = null;
        if($params === null)
        {
            if(isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'json'))
                $params = (array)CJSON::decode(Yii::app()->request->getRawBody());
            else
            {
                if($_SERVER['REQUEST_METHOD'] == 'GET')
                    $params = $_GET;
                elseif($_SERVER['REQUEST_METHOD'] == 'POST')
                    $params = $_POST;
                else
                    $params = Yii::app()->request->getRestParams();
            }

            if(isset($_GET['id']))
                $params = array_merge(array('id' => $_GET['id']), $params);
            $_REQUEST = $params;
        }
        return $params;
	}

	/**
	 * This method is invoked when the request parameters do not satisfy the requirement of the specified action.
	 * The default implementation will throw a 400 HTTP exception.
	 * @param CAction $action the action being executed
	 * @since 1.1.7
	 */
	public function invalidActionParams($action)
	{
        $methodName = 'action' . $action->id;
        if(method_exists($this, $methodName))
        {
            $params = $this->getActionParams();
            $method = new ReflectionMethod($this, $methodName);
            foreach($method->getParameters() as $i => $param)
            {
                $name = $param->getName();
                if(!isset($params[$name]) && !$param->isDefaultValueAvailable())
                {
                    Response::badRequest(Yii::t('error', 'Invalid parameters {attribute}', array('{attribute}' => $name)));
                }
            }
        }
        Response::badRequest(Yii::t('yii', 'Your request is invalid.'));
	}
}
