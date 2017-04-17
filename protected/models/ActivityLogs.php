<?php

/**
 * This is the model class for table "{{_activity_logs}}".
 *
 * The followings are the available columns in table '{{_activity_logs}}':
 * @property integer $id
 * @property string $action
 * @property string $controller
 * @property string $module
 * @property integer $user_id
 * @property integer $type
 * @property integer $record_id
 * @property string $created_date
 */
class ActivityLogs extends _BaseModel {
	

    const MAX_ROWS = 50000; //store max 50k rows
    const TYPE_BE = 1;
    const TYPE_FE = 2;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_activity_logs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, type, record_id', 'numerical', 'integerOnly'=>true),
			array('action, controller, module', 'length', 'max'=>100),
			array('created_date', 'safe'),
			['', 'safe'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			['id, action, controller, module, user_id, type, record_id, created_date', 'safe', 'on'=>'search'],
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			'rUser' => array(self::BELONGS_TO, 'Users', 'user_id', 'condition' => 't.type = ' . self::TYPE_BE),
			'rMember' => array(self::BELONGS_TO, 'Members', 'user_id', 'condition' => 't.type = ' . self::TYPE_FE),
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('translation','ID'),
			'action' => Yii::t('translation','Action'),
			'controller' => Yii::t('translation','Controller'),
			'module' => Yii::t('translation','Module'),
			'user_id' => Yii::t('translation','User'),
			'type' => Yii::t('translation','Type'),
			'record_id' => Yii::t('translation','Record'),
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
		$criteria->compare('action',$this->action,true);
		$criteria->compare('controller',$this->controller,true);
		$criteria->compare('module',$this->module,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('record_id',$this->record_id);
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
		$criteria->compare('action',$this->action,true);
		$criteria->compare('controller',$this->controller,true);
		$criteria->compare('module',$this->module,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('record_id',$this->record_id);
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
	 * @return ActivityLogs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @author Lien Son
	 * @todo: write Log
	 * @param: array $data
	 * @return 
	 */
	public static function writeLog($data) {
		$model = new ActivityLogs();

		$model->type = self::TYPE_FE;
		if(Yii::app()->user->id) {
			$model->user_id = Yii::app()->user->id;
			$model->type = self::TYPE_FE;
		}

		if(Yii::app()->admin->id) {
			$model->user_id = Yii::app()->admin->id;
			$model->type = self::TYPE_BE;
		}

		$model->action = isset($data['action']) ? $data['action'] : '';
        $model->controller = isset($data['controller']) ? $data['controller'] : '';
        $model->ip = Yii::app()->request->getUserHostAddress();
        $model->data = isset($data['data']) ? $data['data'] : '';
        $model->model = isset($data['model']) ? $data['model'] : '';
        $model->record_id = isset($data['record_id']) ? $data['record_id'] : '';
        $model->module = isset(Yii::app()->controller->module->id) ? Yii::app()->controller->module->id : '';
        $model->controller = isset(Yii::app()->controller->id) ? Yii::app()->controller->id : '';
        $model->action = isset(Yii::app()->controller->action->id) ? Yii::app()->controller->action->id : '';
        $model->save();

        //skip 50k rows
        $model->deleteOldData();
	}

	/**
	 * @author Lien Son
	 * @todo: delete records
	 * @param: string 
	 */
	public function deleteOldData() {
        $count = self::model()->count();
        $limit = $count - self::MAX_ROWS; //get row number will delete.
        if ($limit > 0) {
            $c = new CDbCriteria();
            $c->limit = $limit;
            $c->order = 'id asc';
            self::model()->deleteAll($c);
        }
    }

    /**
     * @author Lien Son
     * @todo: get name user
     * @param: 
     * @return: return full_name
     */
    public function getFullName() {
    	$modelUser = $this->modelUser();
    	return $modelUser ? $modelUser->full_name : null ;
    }

    /**
     * @author Lien Son
     * @todo: load model User or Member
     * @param: string 
     * @return object model
     */
    public function modelUser(){
    	if($this->type = self::TYPE_BE) {
    		$user = Users::model()->findByPk($this->user_id);
    	} else {
    		$user = Members::model()->findByPk($this->user_id);
    	}

    	return $user;
    }

    /**
     * @author Lien Son
     * @todo: get username
     * @param: 
     * @return: return username
     */
    public function getUsername() {
    	$modelUser = $this->modelUser();
    	return $modelUser ? $modelUser->username : null ;
    }

    /**
     * @author Lien Son
     * @todo: get type
     * @param: 
     * @return: return type
     */
    public function getType() {
    	return $this->type == self::TYPE_BE ? 'Back End' : 'Front End' ;
    }

}
