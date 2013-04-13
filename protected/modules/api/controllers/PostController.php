<?php

class PostController extends Controller
{
    /**
     * 所有回复
     *
     * uri: /posts
     * method: GET
     *
     * @param integer $topic_id
     */
	public function actionList($topic_id)
	{
        $posts = new Post();
        $posts->topic_id = $topic_id;
        $dataProvider = $posts->createDataProvider();
        Response::ok($dataProvider->data);
    }

    /**
     * 创建回复
     *
     * uri: /posts
     * method: POST
     *
     * @param integer $topic_id
     * @param string $content
     */
    public function actionCreate($topic_id, $content)
    {
        Yii::app()->user->requirePermission('createPost');

        $topic = Topic::model()->findByPk($topic_id);
        if($topic === null)
            Response::notFound('The topic does not exist');

        $model = new Post();
        $model->content = $content;
        $model->topic_id = $topic->id;
        $model->created_at = time();
        $model->creator_id = Yii::app()->user->id;
        $model->created_by = Yii::app()->user->name;

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

    public function loadModel($id)
    {
        $model = Post::model()->findByPk($id);
        if($model === null)
            Response::notFound('The post does not exist');
        return $model;
    }
}
