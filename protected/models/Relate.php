<?php

/**
 * This is the model class for table "{{_relate}}".
 *
 * The followings are the available columns in table '{{_relate}}':
 * @property integer $id
 * @property integer $one_id
 * @property integer $many_id
 * @property string $model_one
 * @property string $model_many
 * @property string $created_date
 */
class Relate extends _BaseModel {
		
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_relate}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('one_id, many_id', 'numerical', 'integerOnly'=>true),
			array('model_one, model_many', 'length', 'max'=>200),
			array('created_date', 'safe'),
			['', 'safe'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			['id, one_id, many_id, model_one, model_many, created_date', 'safe', 'on'=>'search'],
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
			'one_id' => Yii::t('translation','One'),
			'many_id' => Yii::t('translation','Many'),
			'model_one' => Yii::t('translation','Model One'),
			'model_many' => Yii::t('translation','Model Many'),
			'created_date' => Yii::t('translation','Created Date'),
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
		$criteria->compare('one_id',$this->one_id);
		$criteria->compare('many_id',$this->many_id);
		$criteria->compare('model_one',$this->model_one,true);
		$criteria->compare('model_many',$this->model_many,true);
		$criteria->compare('created_date',$this->created_date,true);
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
		$criteria->compare('one_id',$this->one_id);
		$criteria->compare('many_id',$this->many_id);
		$criteria->compare('model_one',$this->model_one,true);
		$criteria->compare('model_many',$this->model_many,true);
		$criteria->compare('created_date',$this->created_date,true);
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
	 * @return Relate the static model class
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
		return Relate::model()->count() + 1;
	}
}
