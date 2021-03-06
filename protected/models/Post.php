<?php
/**
 * Post model
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

/**
 * This is the model class for table "post".
 *
 * @property string $id
 * @property string $topic_id
 * @property string $reply_id
 * @property string $created_at
 * @property string $created_by
 * @property string $creator_id
 * @property string $content
 * @property string $likes_count
 */
class Post extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{post}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
            array('topic_id, content', 'required', 'on' => array('insert', 'update')),
            array('topic_id', 'exist', 'className' => 'Topic', 'attributeName' => 'id', 'on' => array('insert', 'update')),
            array('content', 'filter', 'filter' => 'strip_tags', 'on' => array('insert', 'update')),

			array('topic_id, reply_id, created_at, creator_id, likes_count', 'length', 'max' => 11),
			array('created_by', 'length', 'max' => 20),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'topic' => array(self::BELONGS_TO, 'Topic', 'topic_id'),
            'author' => array(self::BELONGS_TO, 'User', 'creator_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'topic_id' => '所属话题',
			'reply_id' => '所属回复',
			'created_at' => '创建时间',
			'created_by' => '创建人',
			'creator_id' => '创建人ID',
			'content' => '内容',
			'likes_count' => 'Likes Count',
		);
	}

    public function behaviors()
    {
        return array(
            'timestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created_at',
                'updateAttribute' => null,
                'timestampExpression' => time(),
            ),
        );
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Post the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function afterSave()
    {
        if($this->isNewRecord)
        {
            // 更新关联主题数据
            Topic::model()->updateByPk($this->topic_id, array(
                'posts_count' => new CDbExpression('posts_count + 1'),
                'last_posted_at' => $this->created_at,
                'last_posted_by' => $this->created_by,
                'last_poster_id' => $this->creator_id,
            ));

            User::updateLastPostedAt($this->creator_id);

            // 发送提醒
            $watchers = TopicWatch::model()->findAll('topic_id = ?', array($this->topic_id));
            foreach($watchers as $watch)
            {
                if($watch->user_id == $this->creator_id)
                    continue;
                Notification::add(array(
                    'owner_id' => $watch->user_id,
                    'replier_id' => $this->creator_id,
                    'replied_by' => $this->created_by,
                    'replied_at' => $this->created_by,
                    'topic_id' => $this->topic_id,
                    'topic_title' => $this->topic->title,
                    'topic_quote' => $this->content, // TODO remove content format
                ));
            }
        }
    }

    public function getIteratorAttributes()
    {
        $attributes = array(
            'id' => $this->id,
            'topic_id' => $this->topic_id,
            'reply_id' => $this->reply_id,
            'content' => $this->content,
            'likes_count' => $this->likes_count,
            'author' => $this->author,
        );

        // post/list
        if(Yii::app()->controller->id == 'post' && Yii::app()->controller->action->id == 'list')
        {
            $attributes = array_merge($attributes, array(
                'content' => $this->content,
                'can_edit' => Yii::app()->user->id == $this->creator_id,
                'can_like' => !(!Yii::app()->user->isGuest && Postlike::hasLike($this->id, Yii::app()->user->id)),
                'can_reply' => !Yii::app()->user->isGuest,
            ));
        }

        // user/posts
        if(Yii::app()->controller->id == 'user' && Yii::app()->controller->action->id == 'posts')
        {
            $attributes = array_merge($attributes, array(
                'topic' => $this->topic,
            ));
        }


        return $attributes;
    }

	public function createDataProvider()
	{
		$criteria = new CDbCriteria();

		$criteria->compare('topic_id', $this->topic_id);
		$criteria->compare('creator_id', $this->creator_id);

		return new ActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}
