<?php

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
        if(Yii::app()->user->isGuest)
            Response::unAuthorized();
        $model = new Notification();
        $model->owner_id = Yii::app()->user->id;
        $model->unread = $unread === true ? Notification::UNREAD : null;
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
        $model->unread = 0;
        if($model->save())
            Response::ok();
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
