<?php

class NodeController extends Controller
{
    /**
     * 所有节点
     *
     * uri: /nodes
     * method: GET
     */
	public function actionList()
	{
        $section = new Section();
        $dataProvider = $section->createDataProvider();
        $this->response($dataProvider->data);
    }

    /**
     * 创建节点
     *
     * uri: /nodes
     * method: POST
     *
     * @param string $name
     * @param string $alias
     * @param string $describe
     * @param integer $listorder
     */
    public function actionCreate($name, $alias, $describe, $listorder = 0)
    {
        if(!Yii::app()->user->checkAccess('createNode'))
            $this->response('Permission Denied', Response::BAD_REQUEST);

        $node = new Node();
        $timestamp = time();
        $node->setAttributes(array(
            'name' => $name,
            'alias' => $alias,
            'describe' => $describe,
            'listorder' => intval($listorder),
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ));

        if($node->save())
            $this->response($node, Response::CREATED);
        $this->response($node->getErrorMessage(), Response::BAD_REQUEST);
    }

    /**
     * 更新节点
     *
     * uri: /node/{id}
     * method: PUT
     *
     * @param integer $id
     * @param string $name
     * @param string $alias
     * @param string $describe
     * @param integer $listorder
     */
    public function actionUpdate($id, $name, $alias, $describe, $listorder = 0)
    {
        $node = Node::model()->findByPk($id);
        if($node === null)
            $this->response('Invalid Node', Response::BAD_REQUEST);
        if(!Yii::app()->user->checkAccess('updateNode', array('node' => $node)))
            $this->response('Permission Denied', Response::BAD_REQUEST);
        $node->setAttributes(array(
            'name' => $name,
            'alias' => $alias,
            'describe' => $describe,
            'listorder' => intval($listorder),
            'updated_at' => time(),
        ));
        if($node->save())
            $this->response($node, Response::UPDATED);
        $this->response($node->getErrorMessage(), Response::BAD_REQUEST);
    }

    /**
     * 读取一个节点
     *
     * uri: /node/{id}
     * method: GET
     *
     * @param integer $id
     */
    public function actionRead($id)
    {
        $node = Node::model()->findByPk($id);
        if($node === null)
            $this->response('Invalid Node', Response::NOT_FOUND);
        $this->response($node);
    }

    /**
     * 删除一个节点
     *
     * uri: /node/{id}
     * method: DELETE
     *
     * @param integer $id
     */
    public function actionDelete($id)
    {
        if(!Yii::app()->user->checkAccess('deleteNode'))
            $this->response('Permission Denied', Response::BAD_REQUEST);
        if(Node::model()->deleteAllByAttributes(array('id' =>$id, 'creator_id' => Yii::app()->user->id)))
            $this->response('Deleted', Response::DELETED);
        $this->response('Invalid Node', Response::NOT_FOUND);
    }
}
