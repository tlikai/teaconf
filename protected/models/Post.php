<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
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
			array('topic_id, reply_id, created_at, creator_id, likes_count', 'length', 'max'=>11),
			array('created_by', 'length', 'max'=>20),
			array('content', 'safe'),
			array('id, topic_id, reply_id, created_at, created_by, creator_id, content, likes_count', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'author' => array(self::HAS_ONE, 'User', 'creator_id'),
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
			'reply_id' => '父级ID',
			'created_at' => '创建时间',
			'created_by' => '创建人',
			'creator_id' => '创建人ID',
			'content' => '内容',
			'likes_count' => 'Likes Count',
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
