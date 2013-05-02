<?php
/**
 * Section model
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

/**
 * This is the model class for table "section".
 *
 * @property string $id
 * @property string $name
 * @property string $listorder
 */
class Section extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{section}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>255),
			array('listorder', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, listorder', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'nodes' => array(self::HAS_MANY, 'Node', 'section_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => '分区名 ',
			'listorder' => '排序',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Section the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getIteratorAttributes()
    {
        $attributes = parent::getIteratorAttributes();
        return array_merge($attributes, array(
            'nodes' => $this->nodes,
        ));
    }

    public function defaultScope()
    {
        return array(
            'order' => 'listorder DESC, id DESC',
        );
    }

	public function createDataProvider()
	{
		$criteria = new CDbCriteria();

		return new ActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}
