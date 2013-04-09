<?php

/**
 * This is the model class for table "topic".
 *
 * The followings are the available columns in table 'topic':
 * @property string $id
 * @property integer $node_id
 * @property string $title
 * @property string $content
 * @property integer $created_at
 * @property string $created_by
 * @property integer $creator_id
 * @property integer $last_posted_at
 * @property string $last_posted_by
 * @property integer $last_poster_id
 * @property integer $views
 * @property integer $posts_count
 * @property integer $watch_count
 * @property integer $likes_count
 */
class Topic extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'topic';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('node_id, created_at, creator_id, last_posted_at, last_poster_id, views, posts_count, watch_count, likes_count', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('created_by, last_posted_by', 'length', 'max'=>20),
			array('content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, node_id, title, content, created_at, created_by, creator_id, last_posted_at, last_posted_by, last_poster_id, views, posts_count, watch_count, likes_count', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
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
			'node_id' => 'Node',
			'title' => 'Title',
			'content' => 'Content',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'creator_id' => 'Creator',
			'last_posted_at' => 'Last Posted At',
			'last_posted_by' => 'Last Posted By',
			'last_poster_id' => 'Last Poster',
			'views' => 'Views',
			'posts_count' => 'Posts Count',
			'watch_count' => 'Watch Count',
			'likes_count' => 'Likes Count',
		);
	}

    public function behaviors()
    {
        return array(
            'timestamp' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created_at',
                'updateAttribute' => null,
                'timestampExpression' => time(),
            ),
        );
    }


	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('node_id',$this->node_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('creator_id',$this->creator_id);
		$criteria->compare('last_posted_at',$this->last_posted_at);
		$criteria->compare('last_posted_by',$this->last_posted_by,true);
		$criteria->compare('last_poster_id',$this->last_poster_id);
		$criteria->compare('views',$this->views);
		$criteria->compare('posts_count',$this->posts_count);
		$criteria->compare('watch_count',$this->watch_count);
		$criteria->compare('likes_count',$this->likes_count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Topic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function beforeSave()
    {
        $return = parent::beforeSave();
        if($this->getIsNewRecord())
        {
            $this->last_poster_id = $this->creator_id;
            $this->last_posted_at = $this->created_at;
            $this->last_posted_by = $this->created_by;
        }
        return $return;
    }

    protected function afterSave()
    {
        $this->node->updateCounters(array('topics_count' => 1));
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
    
    /**
     * scopes
     */
    public function scopes()
    {
        return array(
            'recent' => array(
                'order' => 'id DESC',
            ),
            'popular' => array(),
            'suggest' => array(),
        );
    }

    /**
     * set node filter
     *
     * @param integer $id Node ID
     * @reurn ActiveRecord
     */
    public function node($id)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition' => 'node_id = ?',
            'params' => array($id),
        ));
        return $this;
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
