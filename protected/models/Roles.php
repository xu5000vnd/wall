<?php

/**
 * This is the model class for table "{{_roles}}".
 *
 * The followings are the available columns in table '{{_roles}}':
 * @property integer $id
 * @property string $name
 */
class Roles extends _BaseModel {
		
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_roles}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>100),
			['', 'safe'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			['id, name', 'safe', 'on'=>'search'],
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
			'id' => Yii::t('translation','ID'),
			'name' => Yii::t('translation','Name'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
				$sort = new CSort();

        $sort->attributes = [
			'*',
            'name' => [
                'asc' => 't.id',
                'desc' => 't.id desc',
                'default' => 'asc',
            ],
        ];
		$sort->defaultOrder = 't.id asc';
					
		 
		return new CActiveDataProvider($this, [
			'criteria'=>$criteria,
                        'sort' => $sort,
			'pagination'=>[
                'pageSize'=> Yii::app()->params['defaultPageSize'],
            ],
		]);
	}

	public function searchExport()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		
		$criteria=new CDbCriteria;
	
				$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->order = 'id DESC';
		$model = self::model()->findAll($criteria);
	
		if($model){
			return $model;
		}
		return ;
	}

	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Roles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
    /**
    * In case you use displayed order to identify the sequence. Let set this number to create form 
    *
    */
	public function nextOrderNumber()
	{
		return Roles::model()->count() + 1;
	}
}
