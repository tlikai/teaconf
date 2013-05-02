<?php
/**
 * Notification model
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

/**
 * This is the model class for table "notification".
 *
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
    const READ = 0;
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
		return array(
            'replier' => array(self::BELONGS_TO, 'User', 'replier_id'),
            'topic' => array(self::BELONGS_TO, 'Topic', 'topic_id'),
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

    public function getIteratorAttributes()
    {
        $attributes = parent::getIteratorAttributes();
        return array_merge($attributes, array(
            'replier' => $this->replier,
        ));
    }

	public function createDataProvider()
	{
		$criteria = new CDbCriteria();
        $criteria->compare('owner_id', $this->owner_id);
        $this->unread !== null && $criteria->compare('unread', $this->unread);

		return new ActiveDataProvider($this, array(
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
