<?php

/**
 * This is the model class for table "user_auth".
 *
 * The followings are the available columns in table 'user_auth':
 * @property string $id
 * @property integer $user_id
 * @property string $provider
 * @property integer $provider_id
 * @property string $name
 * @property string $avatar
 * @property string $access_token
 * @property string $refersh_token
 * @property integer $expires
 * @property integer $created_at
 */
class UserAuth extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_auth';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, provider_id, expires, created_at', 'numerical', 'integerOnly'=>true),
			array('provider, name, avatar', 'length', 'max'=>255),
			array('access_token, refersh_token', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, provider, provider_id, name, avatar, access_token, refersh_token, expires, created_at', 'safe', 'on'=>'search'),
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
			'provider' => 'Provider',
			'provider_id' => 'Provider',
			'name' => 'Name',
			'avatar' => 'Avatar',
			'access_token' => 'Access Token',
			'refersh_token' => 'Refersh Token',
			'expires' => 'Expires',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('provider',$this->provider,true);
		$criteria->compare('provider_id',$this->provider_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('access_token',$this->access_token,true);
		$criteria->compare('refersh_token',$this->refersh_token,true);
		$criteria->compare('expires',$this->expires);
		$criteria->compare('created_at',$this->created_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserAuth the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
