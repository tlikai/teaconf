<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 * @property string $id
 * @property integer $topic_id
 * @property integer $reply_id
 * @property integer $created_at
 * @property string $created_by
 * @property integer $creator_id
 * @property string $content
 * @property integer $likes_count
 */
class Post extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'post';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('topic_id, reply_id, created_at, creator_id, likes_count', 'numerical', 'integerOnly'=>true),
			array('created_by', 'length', 'max'=>20),
			array('content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, topic_id, reply_id, created_at, created_by, creator_id, content, likes_count', 'safe', 'on'=>'search'),
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
			'topic_id' => 'Topic',
			'reply_id' => 'Reply',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'creator_id' => 'Creator',
			'content' => 'Content',
			'likes_count' => 'Likes Count',
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
		$criteria->compare('topic_id',$this->topic_id);
		$criteria->compare('reply_id',$this->reply_id);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('creator_id',$this->creator_id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('likes_count',$this->likes_count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
}
