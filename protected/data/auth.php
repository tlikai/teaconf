<?php
/**
 * define CPhpAuthManager rules 
 *
 * @author likai<youyuge@gmail.com>
 * @link http://www.youyuge.com/
 */

return array(
    // node operation
    'createNode' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'bizRule' => 'return false;',
        'description' => 'create a node',
        'data' => null,
    ),
    'updateNode' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'bizRule' => 'return false;',
        'description' => 'update node',
        'data' => null,
    ),
    'deleteNode' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'bizRule' => 'return false;',
        'description' => 'delete node',
        'data' => null,
    ),

    // topic operation
    'createTopic' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'bizRule' => 'return !Yii::app()->user->getIsGuest();',
        'description' => 'create a topic',
        'data' => null,
    ),
    'updateTopic' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'bizRule' => 'return Yii::app()->user->id == $params[\'topic\']->creator_id;',
        'description' => 'update topic',
        'data' => null,
    ),
    'deleteTopic' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'bizRule' => 'return !Yii::app()->user->getIsGuest();',
        'description' => 'delete topic',
        'data' => null,
    ),
    'watchTopic' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'bizRule' => 'return !Yii::app()->user->getIsGuest();',
        'description' => 'watch topic',
        'data' => null,
    ),
    'unWatchTopic' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'bizRule' => 'return true;',
        'description' => 'unwatch topic',
        'data' => null,
    ),

    // post operation
    'createPost' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'bizRule' => 'return !Yii::app()->user->getIsGuest();',
        'description' => 'create a topic',
        'data' => null,
    ),
    'updatePost' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'bizRule' => 'return Yii::app()->user->id == $post->creator_id;',
        'description' => 'update a topic',
        'data' => null,
    ),
    'deletePost' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'bizRule' => 'return !Yii::app()->user->getIsGuest();',
        'description' => 'delete a topic',
        'data' => null,
    ),
);
