<?php
/**
 * PostLike model
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

/**
 * This is the model class for table "post_likes".
 *
 * @property string $id
 * @property string $user_id
 * @property string $post_id
 * @property string $created_at
 */
class PostLike extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'post_likes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, post_id', 'required'),
			array('user_id, post_id, created_at', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, post_id, created_at', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'post_id' => 'Post',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('post_id',$this->post_id,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PostLikes the static model class
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

    /**
     * 标记喜欢
     *
     * @param integer $user_id
     * @param integer $post_id
     * @return boolean
     */
    public static function like($user_id, $post_id)
    {
        $model = new self();
        $model->user_id = $user_id;
        $model->post_id = $post_id;
        $status = $model->save();
        if($status)
            Post::model()->updateCounters(array('likes_count' => 1), 'id =? ', array($post_id));
        return $status;
    }

    /**
     * 取消喜欢
     *
     * @param integer $user_id
     * @param integer $post_id
     * @return boolean
     */
    public static function unlike($user_id, $post_id)
    {
        $status = self::model()->deleteAllByAttributes(array(
            'user_id' => $user_id,
            'post_id' => $post_id,
        ));

        if($status)
        {
            Post::model()->updateCounters(array('likes_count' => -1), 'id =? ', array($post_id));
            return $status;
        }
        return false;
    }

    /**
     * has like
     *
     * @param integer $user_id
     * @param integer $post_id
     * @return boolean
     */
    public static function hasLike($user_id, $post_id)
    {
        return self::model()->exists(array(
            'condition' => 'user_id = :user_id AND post_id = :post_id',
            'params' => array(
                'user_id' => $user_id,
                'post_id' => $post_id,
            ),
        ));
    }
}
