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
        Response::ok($dataProvider->data);
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
        Yii::app()->user->requirePermission('createNode');

        $model = new Node();
        $timestamp = time();
        $model->setAttributes(array(
            'name' => $name,
            'alias' => $alias,
            'describe' => $describe,
            'listorder' => intval($listorder),
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ));

        if($model->save())
            Response::created($model);
        Response::badRequest($model->getFirstError());
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
        $model = $this->loadModel($id);
        Yii::app()->user->requirePermission('updateNode', array('node' => $model));

        $model->setAttributes(array(
            'name' => $name,
            'alias' => $alias,
            'describe' => $describe,
            'listorder' => $listorder,
            'updated_at' => time(),
        ));
        if($model->save())
            Response::updated($model);
        Response::badRequest($model->getFirstError());
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
        $model = $this->loadModel($id);
        Response::ok($model);
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
        $model = $this->loadModel($id);
        Yii::app()->user->requirePermission('deleteNode', array('node' => $model));

        if($model->delete())
            Response::deleted();
        Response::serverError();
    }

    public function loadModel($id)
    {
        $model = Node::model()->findByPk($id);
        if($model === null)
            Response::notFound('The node does not exist');
        return $model;
    }
}
