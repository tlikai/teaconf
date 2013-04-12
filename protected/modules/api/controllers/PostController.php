<?php

class PostController extends Controller
{
    /**
     * 所有回复
     *
     * uri: /posts
     * method: GET
     *
     * @param integer $id topic_id
     */
	public function actionList($id)
	{
        $post = new Post();
        $dataProvider = $post->createDataProvider(array(
            'criteria' => array(
                'condition' => 'topic_id = :id',
                'params' => array(
                    ':id' => $id,
                ),
            ),
        ));

        $this->response($dataProvider->data);
    }

    /**
     * 创建回复
     *
     * uri: /posts
     * method: POST
     *
     * @param integer $topicId
     * @param string $content
     */
    public function actionCreate($topicId, $content)
    {
        if(!Yii::app()->user->checkAccess('createPost'))
            $this->response('Permission Denied', Response::BAD_REQUEST);
        $topic = Topic::model()->findByPk($topicId);
        if($topic === null)
            $this->response('Invalid Topic', Response::BAD_REQUEST);

        $post = new Post();
        $post->content = $content;
        $post->topic_id = $topic->id;
        $post->created_at = time();
        $post->creator_id = Yii::app()->user->id;
        $post->created_by = Yii::app()->user->name;

        if($post->save())
            $this->response($post, Response::CREATED);
        $this->response($post->getErrorMessage(), Response::BAD_REQUEST);
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
        $post = Post::model()->findByPk($id);
        if($post === null)
            $this->response('Invalid Post', Response::BAD_REQUEST);

        if(!Yii::app()->user->checkAccess('updatePost', array('post' => $post)))
            $this->response('Permission Denied', Response::BAD_REQUEST);

        $post->content = $content;
        if($post->save())
            $this->response($post, Response::UPDATED);
        $this->response($post->getErrorMessage(), Response::BAD_REQUEST);
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
        $post = Post::model()->findByPk($id);
        if($post === null)
            $this->response('Invalid Post', Response::NOT_FOUND);
        $this->response($post);
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
        if(!Yii::app()->user->checkAccess('deletePost'))
            $this->response('Permission Denied', Response::BAD_REQUEST);
        if(Post::model()->deleteAllByAttributes(array('id' => $id, 'creator_id' => Yii::app()->user->id)))
            $this->response('Deleted', Response::DELETED);
        $this->response('Invalid Post', Response::NOT_FOUND);
    }
}
