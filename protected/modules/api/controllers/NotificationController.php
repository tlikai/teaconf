<?php
/**
 * NotificationController
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

class NotificationController extends Controller
{
    /**
     * 读取所有提醒
     *
     * uri: /notifications
     * method: GET
     *
     * @param integer $unread
     */
	public function actionList($unread = true)
	{
        $unread = intval($unread);
        if(Yii::app()->user->isGuest)
            Response::unAuthorized();
        $model = new Notification();
        $model->owner_id = Yii::app()->user->id;
        $model->unread = $unread ? Notification::UNREAD : null;
        $dataProvider = $model->createDataProvider();
        Response::ok($dataProvider->data);
    }

    /**
     * 标记已读
     *
     * @param integer $id
     */
    public function actionRead($id)
    {
        $model = $this->loadModel($id);
        if(Yii::app()->user->id != $model->owner_id)
            Response::forbidden();
        $model->unread = Notification::READ;
        if($model->save())
        {
            User::model()->updateCounters(array('notifications' => -1), 'id = ?', $model->owner_id);
            Response::ok();
        }
        Response::serverError();
    }

    /**
     * 加载提醒模型
     *
     * @param integer $id
     * @return Notification
     */
    public function loadModel($id)
    {
        $model = Notification::model()->findByPk($id);
        if($model === null)
            Response::notFound('The Notification does not exist');
        return $model;
    }
}
