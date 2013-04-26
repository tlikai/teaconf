<?php

/**
 * This is the model class for table "topic_watch".
 *
 * The followings are the available columns in table 'topic_watch':
 * @property string $id
 * @property string $topic_id
 * @property string $user_id
 * @property string $created_at
 */
class TopicWatch extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{topic_watch}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('topic_id, user_id, created_at', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, topic_id, user_id, created_at', 'safe', 'on'=>'search'),
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
			'topic_id' => 'Topic',
			'user_id' => 'User',
			'created_at' => 'Created At',
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
		$criteria->compare('topic_id',$this->topic_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TopicWatch the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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

    protected function afterSave()
    {
        if($this->isNewRecord)
        {
            // update related topic watch count
            $topic = Topic::model()->findByPk($this->topic_id);
            $topic->watch_count++;
            $topic->setScore();
            $topic->save();
        }
    }

    /**
     * create topic watch
     *
     * @param integer $user_id
     * @param integer $topic_id
     * @return boolean
     */
    public static function watch($user_id, $topic_id)
    {
        $model = new self();
        $model->user_id = $user_id;
        $model->topic_id = $topic_id;
        return $model->save();
    }

    /**
     * delete topic watch
     *
     * @param integer $user_id
     * @param integer $topic_id
     * @return boolean
     */
    public static function unwatch($user_id, $topic_id)
    {
        $status = self::model()->deleteAllByAttributes(array(
            'user_id' => $user_id,
            'topic_id' => $topic_id,
        ));
        if($status)
        {
            Topic::model()->updateCounters(array('watch_count' => -1), 'id =? ', array($topic_id));
            return $status;
        }
        return false;
    }

    /**
     * has watched 
     *
     * @param integer $user_id
     * @param integer $topic_id
     * @return boolean
     */
    public static function hasWatched($user_id, $topic_id)
    {
        return self::model()->exists(array(
            'condition' => 'user_id = :user_id AND topic_id = :topic_id',
            'params' => array(
                ':user_id' => $user_id,
                ':topic_id' => $topic_id,
            ),
        ));
    }
}
