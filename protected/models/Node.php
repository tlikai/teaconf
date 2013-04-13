<?php

/**
 * This is the model class for table "node".
 *
 * The followings are the available columns in table 'node':
 * @property string $id
 * @property string $section_id
 * @property string $name
 * @property string $alias
 * @property string $describe
 * @property string $listorder
 * @property string $created_at
 * @property string $updated_at
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
			array('section_id, listorder, created_at, updated_at, topics_count', 'length', 'max'=>11),
			array('name, alias, describe', 'length', 'max'=>255),

            array('name, alias', 'unique'),

			array('id, section_id, name, alias, describe, listorder, created_at, updated_at, topics_count', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
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
			'section_id' => '所属分区',
			'name' => '名称',
			'alias' => '别名',
			'describe' => '描述',
			'listorder' => '排序',
			'created_at' => '创建时间',
			'updated_at' => '最后修改时间',
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

    public static function findByAlias($alias)
    {
        return self::model()->findByAttributes(array(
            'alias' => $alias,
        ));
    }

	public function createDataProvider()
	{
		$criteria = new CDbCriteria();

		return new ActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}
