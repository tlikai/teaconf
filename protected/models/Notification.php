<?php

/**
 * This is the model class for table "notification".
 *
 * The followings are the available columns in table 'notification':
 * @property string $id
 * @property integer $unread
 * @property string $owner_id
 * @property string $replier_id
 * @property string $replied_by
 * @property string $replied_at
 * @property string $topic_id
 * @property string $topic_title
 * @property string $topic_quote
 */
class Notification extends ActiveRecord
{
    const UNREAD = 1;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('unread', 'numerical', 'integerOnly'=>true),
			array('owner_id, replier_id, replied_at, topic_id', 'length', 'max'=>11),
			array('replied_by', 'length', 'max'=>20),
			array('topic_title, topic_quote', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, unread, owner_id, replier_id, replied_by, replied_at, topic_id, topic_title, topic_quote', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'unread' => 'Unread',
			'owner_id' => 'Owner',
			'replier_id' => 'Replier',
			'replied_by' => 'Replied By',
			'replied_at' => 'Replied At',
			'topic_id' => 'Topic',
			'topic_title' => 'Topic Title',
			'topic_quote' => 'Topic Content',
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
		$criteria->compare('unread',$this->unread);
		$criteria->compare('owner_id',$this->owner_id,true);
		$criteria->compare('replier_id',$this->replier_id,true);
		$criteria->compare('replied_by',$this->replied_by,true);
		$criteria->compare('replied_at',$this->replied_at,true);
		$criteria->compare('topic_id',$this->topic_id,true);
		$criteria->compare('topic_title',$this->topic_title,true);
		$criteria->compare('topic_quote',$this->topic_quote,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notification the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function behaviors()
    {
        return array(
            'timestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'replied_at',
                'updateAttribute' => null,
                'timestampExpression' => time(),
            ),
        );
    }

    protected function beforeSave()
    {
        if($this->isNewRecord)
            empty($this->unread) && $this->unread = self::UNREAD;
        return parent::beforeSave();
    }

    protected function afterSave()
    {
        if($this->isNewRecord)
            User::model()->updateCounters(array('notifications' => 1), 'id = ?', $this->owner_id);
        return parent::afterSave();
    }

    public static function add($attributes)
    {
        $notification = new self();
        $notification->attributes = $attributes;
        return $notification->save();
    }
}
