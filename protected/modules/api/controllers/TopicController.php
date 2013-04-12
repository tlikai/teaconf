<?php
/**
 * TopicController class file
 *
 * @author likai<youyuge@gmail.com>
 * @link http://www.youyuge.com/
 */

/**
 * Topic controller class
 */
class TopicController extends Controller
{
    /**
     * 所有话题
     *
     * uri: /topics
     * method: GET
     *
     * @param string $filter
     */
	public function actionList($filter = 'popular', $node = 0)
	{
        $topics = new Topic();
        if(in_array($filter, array('popular', 'recent', 'suggest')))
            $topics->$filter();
        elseif($filter == 'watched')
            $topics->watched(Yii::app()->user->id);
        if(!empty($node))
            $topics->node($node);
        $dataProvider = $topics->createDataProvider();

        $this->response($dataProvider->data);
    }

    /**
     * 创建话题
     *
     * uri: /topics
     * method: POST
     *
     * @param integer $nodeId
     * @param string $title
     * @param string $content
     */
    public function actionCreate($nodeId, $title, $content)
    {
        if(!Yii::app()->user->checkAccess('createTopic'))
            $this->response('Permission Denied', Response::BAD_REQUEST);

        $topic = new Topic();
        $topic->setAttributes(array(
            'node_id' => $nodeId,
            'title' => $title,
            'content' => $content,
            'creator_id' => Yii::app()->user->id,
            'created_by' => Yii::app()->user->name,
        ));

        if($topic->save())
            $this->response($topic, Response::CREATED);
        $this->response($topic->getErrorMessage(), Response::BAD_REQUEST);
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
        $topic = Topic::model()->findByPk($id);
        if($topic === null)
            $this->response('Invalid Topic', Response::BAD_REQUEST);
        if(!Yii::app()->user->checkAccess('updateTopic', array('topic' => $topic)))
            $this->response('Permission Denied', Response::BAD_REQUEST);
        $topic->title = $title;
        $topic->content = $content;
        if($topic->save())
            $this->response($topic, Response::UPDATED);
        $this->response($topic->getErrorMessage(), Response::BAD_REQUEST);
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
        $topic = Topic::model()->findByPk($id);
        if($topic === null)
            $this->response('Invalid Topic', Response::NOT_FOUND);
        $this->response($topic);
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
        if(!Yii::app()->user->checkAccess('deleteTopic'))
            $this->response('Permission Denied', Response::BAD_REQUEST);
        if(Topic::model()->deleteAllByAttributes(array('id' =>$id, 'creator_id' => Yii::app()->user->id)))
            $this->response('Deleted', Response::DELETED);
        $this->response('Invalid Topic', Response::NOT_FOUND);
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
        if(!Yii::app()->user->checkAccess('watchTopic'))
            $this->response('Permission Denied', Response::BAD_REQUEST);
        if(TopicWatch::hasWatched(Yii::app()->user->id, $id))
            $this->response('Watched', Response::BAD_REQUEST);
        if(TopicWatch::watch(Yii::app()->user->id, $id))
            $this->response('Created', Response::CREATED);
        $this->response('BAFailed', 500);
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
        if(!Yii::app()->user->checkAccess('unWatchTopic'))
            $this->response('Permission Denied', Response::BAD_REQUEST);
        if(TopicWatch::unwatch(Yii::app()->user->id, $id))
            $this->response('Deleted', Response::DELETED);
        $this->response('Failed', 500);
    }
}
