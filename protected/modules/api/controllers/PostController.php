<?php
/**
 * PostController
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

class PostController extends Controller
{
    /**
     * 所有回复
     *
     * uri: /topic/$topic_id/posts
     * method: GET
     *
     * @param integer $topic_id
     */
	public function actionList($topic_id)
	{
        $model = new Post();
        $model->topic_id = $topic_id;
        $dataProvider = $model->createDataProvider();
        Response::ok($dataProvider->data);
    }

    /**
     * 创建回复
     *
     * uri: /posts
     * method: POST
     *
     * @param integer $topic_id
     * @param integer $reply_id
     * @param string $content
     */
    public function actionCreate($topic_id, $content, $reply_id = null)
    {
        Yii::app()->user->requirePermission('createPost');

        $model = new Post();
        $model->topic_id = $topic_id;
        $model->content = $content;
        $model->creator_id = Yii::app()->user->id;
        $model->created_by = Yii::app()->user->name;

        if(!empty($reply_id))
        {
            $this->loadModel($reply_id);
            $model->reply_id = $reply_id;
        }

        if($model->save())
            Response::created($model);
        Response::badRequest($model->getFirstError());
    }

    /**
     * 更新回复
     *
     * uri: /post/{id}
     * method: PUT
     *
     * @param integer $id
     * @param string $content
     */
    public function actionUpdate($id, $content)
    {
        $model = $this->loadModel($id);
        Yii::app()->user->requirePermission('updatePost', array('post' => $model));

        $model->content = $content;
        if($model->save())
            Response::updated($model);
        Response::badRequest($model->getFirstError());
    }

    /**
     * 读取一个回复
     *
     * uri: /post/{id}
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
     * 删除一个回复
     *
     * uri: /post/{id}
     * method: DELETE
     *
     * @param integer $id
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        Yii::app()->user->requirePermission('deletePost', array('post' => $model));

        if($model->delete())
            Response::deleted();
        Response::serverError();
    }

    /**
     * 喜欢回复
     *
     * uri: /post/{id}/like
     * method: POST
     *
     * @param integer $id
     */
    public function actionLike($id)
    {
        Yii::app()->user->requirePermission('likePost');

        if(PostLike::hasLike(Yii::app()->user->id, $id))
            Response::badRequest('liked');
        if(PostLike::like(Yii::app()->user->id, $id))
            Response::created();
        Response::serverError();
    }

    /**
     * 取消喜欢回复
     *
     * uri: /topic/{id}/like
     * method: DELETE
     *
     * @param integer $id
     */
    public function actionUnlike($id)
    {
        Yii::app()->user->requirePermission('unlikePost');

        if(PostLike::unlike(Yii::app()->user->id, $id))
            Response::deleted();
        Response::serverError();
    }

    /**
     * 加载回复模型
     *
     * @param integer $id
     * @return Node
     */
    public function loadModel($id)
    {
        $model = Post::model()->findByPk($id);
        if($model === null)
            Response::notFound('The post does not exist');
        return $model;
    }
}
