<?php
/**
 * TopicController
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

class TopicController extends Controller
{
    /**
     * 所有话题
     *
     * uri: /topics
     * method: GET
     *
     * @param string $node_alias
     * @param string $tab
     */
	public function actionList($node_alias = null, $tab = 'popular')
	{
        $model = new Topic();
        $dataProvider = $model->createDataProvider($node_alias, $tab);
        Response::ok($dataProvider->data);
    }

    /**
     * 创建话题
     *
     * uri: /topics
     * method: POST
     *
     * @param integer $node_id
     * @param string $title
     * @param string $content
     */
    public function actionCreate($node_id, $title, $content)
    {
        Yii::app()->user->requirePermission('createTopic');

        $model = new Topic();
        $model->setAttributes(array(
            'node_id' => $node_id,
            'title' => $title,
            'content' => $content,
            'creator_id' => Yii::app()->user->id,
            'created_by' => Yii::app()->user->name,
        ));

        if($model->save())
            Response::created($model);
        Response::badRequest($model->getFirstError());
    }

    /**
     * 更新话题
     *
     * uri: /topic/{id}
     * method: PUT
     *
     * @param integer $id
     * @param string $title
     * @param string $content
     */
    public function actionUpdate($id, $title, $content)
    {
        $model = $this->loadModel($id);
        Yii::app()->user->requirePermission('updateTopic', array('topic' => $model));
        $model->title = $title;
        $model->content = $content;
        if($model->save())
            Response::updated($model);
        Response::badRequest($model->getFirstError());
    }

    /**
     * 读取一个话题
     *
     * uri: /topic/{id}
     * method: GET
     *
     * @param integer $id
     */
    public function actionRead($id)
    {
        $model = $this->loadModel($id);
        Response::ok($model);
    }

    /**
     * 删除一个话题
     *
     * uri: /topic/{id}
     * method: DELETE
     *
     * @param integer $id
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        Yii::app()->user->requirePermission('deleteTopic', array('topic' => $model));

        if($model->delete())
            Response::deleted();
        Response::serverError();
    }

    /**
     * 关注主题
     *
     * uri: /topic/watch/id
     * method: POST
     *
     * @param integer $id
     */
    public function actionWatch($id)
    {
        Yii::app()->user->requirePermission('watchTopic');

        if(TopicWatch::hasWatched(Yii::app()->user->id, $id))
            Response::badRequest('watched');
        if(TopicWatch::watch(Yii::app()->user->id, $id))
            Response::created();
        Response::serverError();
    }

    /**
     * 取消关注主题
     *
     * uri: /topic/watch/id
     * method: POST
     *
     * @param integer $id
     */
    public function actionUnwatch($id)
    {
        Yii::app()->user->requirePermission('unwatchTopic');

        if(TopicWatch::unwatch(Yii::app()->user->id, $id))
            Response::deleted();
        Response::serverError();
    }

    /**
     * 喜欢主题
     *
     * uri: /topic/watch/id
     * method: POST
     *
     * @param integer $id
     */
    public function actionLike($id)
    {
        Yii::app()->user->requirePermission('likeTopic');

        if(TopicLike::hasWatched(Yii::app()->user->id, $id))
            Response::badRequest('liked');
        if(TopicWatch::watch(Yii::app()->user->id, $id))
            Response::created();
        Response::serverError();
    }

    /**
     * 取消喜欢主题
     *
     * uri: /topic/like/id
     * method: POST
     *
     * @param integer $id
     */
    public function actionUnlike($id)
    {
        Yii::app()->user->requirePermission('unlikeTopic');

        if(TopicLike::unlik(Yii::app()->user->id, $id))
            Response::deleted();
        Response::serverError();
    }

    /**
     * 加载主题模型
     *
     * @param integer $id
     * @return Topic
     */
    public function loadModel($id)
    {
        $model = Topic::model()->findByPk($id);
        if($model === null)
            Response::notFound('The topic does not exist');
        return $model;
    }
}
