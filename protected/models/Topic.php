<?php

/**
 * This is the model class for table "topic".
 *
 * The followings are the available columns in table 'topic':
 * @property string $id
 * @property string $node_id
 * @property string $title
 * @property string $content
 * @property string $created_at
 * @property string $created_by
 * @property string $creator_id
 * @property string $last_posted_at
 * @property string $last_posted_by
 * @property string $last_poster_id
 * @property string $views
 * @property string $posts_count
 * @property string $watch_count
 * @property string $likes_count
 */
class Topic extends ActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{topic}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
            array('node_id', 'exist', 'className' => 'Node', 'attributeName' => 'id', 'on' => array('insert', 'update')),
            array('node_id, title, content', 'required', 'on' => array('insert', 'update')),
            array('content', 'filter', 'filter' => 'strip_tags', 'on' => array('insert', 'update')),

            array('content', 'length', 'min' => 10),
			array('node_id, created_at, creator_id, last_posted_at, last_poster_id, views, posts_count, watch_count, likes_count', 'length', 'max'=>11),
			array('title', 'length', 'max'=>255),
			array('created_by, last_posted_by', 'length', 'max' => 20),
		);
	}

    public function behaviors()
    {
        return array(
            'timestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created_at',
                'updateAttribute' => null,
                'timestampExpression' => 'time()',
            ),
        );
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'node' => array(self::BELONGS_TO, 'Node', 'node_id'),
            'posts' => array(self::HAS_MANY, 'Post', 'topic_id'),
            'author' => array(self::BELONGS_TO, 'User', 'creator_id'),
            'lastPoster' => array(self::BELONGS_TO, 'User', 'last_poster_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'node_id' => '所属节点',
			'title' => '标题',
			'content' => '内容',
			'created_at' => '创建时间',
			'created_by' => '创建人',
			'creator_id' => '创建人ID',
			'last_posted_at' => '最后回复时间',
			'last_posted_by' => '最后回复人',
			'last_poster_id' => '最后回复人ID',
			'views' => '查看数',
			'posts_count' => '回复数',
			'watch_count' => '关注数',
			'likes_count' => 'Likes Count',
		);
	}

    protected function beforeSave()
    {
        $return = parent::beforeSave();
        if($this->isNewRecord)
        {
            empty($this->last_poster_id) && $this->last_poster_id = $this->creator_id;
            empty($this->last_posted_at) && $this->last_posted_at = $this->created_at;
            empty($this->last_posted_by) && $this->last_posted_by = $this->created_by;
        }
        return $return;
    }

    protected function afterSave()
    {
        $this->node->updateCounters(array('topics_count' => 1), 'id = ?', array($this->node_id));
        return parent::afterSave();
    }

    public function getIteratorAttributes()
    {
        $attributes = parent::getIteratorAttributes();
        return array_merge($attributes, array(
            'node' => $this->node,
            'author' => $this->author,
            'lastPoster' => $this->lastPoster,
        ));
    }

	public function createDataProvider($nodeAlias = null, $tab = null)
	{
		$criteria = new CDbCriteria();

        // filter by node
        if($nodeAlias !== null)
        {
            $node = Node::findByAlias($nodeAlias);
            $node && $criteria->compare('node_id', $node->id);
        }

        // order
        if($tab == 'popular')
            ; // TODO implement me
        elseif($tab == 'suggest')
            ; // TODO implement me
        elseif($tab == 'latest')
            $criteria->order = 'id DESC';
        elseif($tab == 'watched')
            $this->watched(Yii::app()->user->id);

		return new ActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

    /**
     * set watched filter
     *
     * @param integer $userId
     * @reurn ActiveRecord
     */
    public function watched($userId)
    {
        $watched = TopicWatch::model()->findAll(array(
            'index' => 'topic_id',
            'condition' => 'user_id = ?',
            'params' => array($userId),
        ));
        $this->getDbCriteria()->addInCondition('id', array_keys($watched));
        return $this;
    }
}
