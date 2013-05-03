<?php

class SiteController extends CController
{
    public function actionIndex()
    {
        $this->renderPartial('index');
    }
    
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error)
        {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->renderPartial('error', $error);
        }
    }
}
