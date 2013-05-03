<?php
/**
 * Node model
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

/**
 * This is the model class for table "node".
 *
 * @property string $id
 * @property string $section_id
 * @property string $name
 * @property string $alias
 * @property string $describe
 * @property string $listorder
 * @property string $created_at
 * @property string $topics_count
 */
class Node extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{node}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('section_id, listorder, created_at, topics_count', 'length', 'max'=>11),
			array('name, alias, describe', 'length', 'max'=>255),

            array('name, alias', 'unique'),

			array('id, section_id, name, alias, describe, listorder, created_at, topics_count', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'section_id' => '所属分区',
			'name' => '名称',
			'alias' => '别名',
			'describe' => '描述',
			'listorder' => '排序',
			'created_at' => '创建时间',
			'topics_count' => '主题总数',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Node the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function defaultScope()
    {
        return array(
            'order' => 'listorder DESC, id DESC',
        );
    }

    public static function findByAlias($value)
    {
        return self::model()->findByAttributes(array(
            'alias' => $value,
        ));
    }

	public function createDataProvider()
	{
		$criteria = new CDbCriteria();

		return new ActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

    public function getIteratorAttributes()
    {
        $attributes = array(
            'id' => $this->id,
            'name' => $this->name,
            'alias' => $this->alias,
        );

        if(Yii::app()->controller->id == 'node' && Yii::app()->controller->action->id == 'read')
        {
            $attributes = array_merge($attributes, array(
                'describe' => $this->describe,
                'topics_count' => $this->topics_count,
            ));
        }

        return $attributes;
    }

}
