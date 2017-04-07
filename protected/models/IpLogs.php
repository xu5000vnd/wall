<?php

/**
 * This is the model class for table "{{_ip_logs}}".
 *
 * The followings are the available columns in table '{{_ip_logs}}':
 * @property integer $id
 * @property string $username
 * @property string $ip_address
 * @property string $time_login
 */
class IpLogs extends _BaseModel {
		
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_ip_logs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username', 'length', 'max'=>100),
			array('ip_address', 'length', 'max'=>45),
			array('time_login', 'safe'),
			['', 'safe'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			['id, username, ip_address, time_login', 'safe', 'on'=>'search'],
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
			'username' => Yii::t('translation','Username'),
			'ip_address' => Yii::t('translation','Ip Address'),
			'time_login' => Yii::t('translation','Time Login'),
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('time_login',$this->time_login,true);
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('time_login',$this->time_login,true);
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
	 * @return IpLogs the static model class
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
		return IpLogs::model()->count() + 1;
	}
}
