<?php

/**
 * This is the model class for table "{{_log_active}}".
 *
 * The followings are the available columns in table '{{_log_active}}':
 * @property int $id
 * @property int $user_id
 * @property string $action
 * @property string $message
 * @property string $ip
 * @property string $location
 * @property string $create_date
 */

class LogActive extends _BaseModel {
    
    const TYPE_LOGIN = 'login';

    public static $ARR_ACTION = [
        self::TYPE_LOGIN => 'Login',
    ];

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_log_active}}';
	}

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, user_id, action, message, ip, location, create_date', 'safe')
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
            'rUser' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
    }

     /**
     * Returns the static model of the specified AR class.
     * @return Server the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public static function saveLog($type, $msg, $user_id = 0) {
        if (empty($user_id)) {
            $user_id = Yii::app()->user->id;
        }
        $model = new LogActive();
        $model->user_id = $user_id;
        $model->action = $type;
        $model->message = $msg;
        $model->ip = isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : $_SERVER['REMOTE_ADDR'];
        $model->location = Utils::getLocation($model->ip);
        $model->save();
    }

    public function search() {
        $c = new CDbCriteria();
        $c->compare('t.user_id', $this->user_id);
        $c->compare('t.action', $this->action);

        $c->order = 'id DESC';
        return new CActiveDataProvider($this, [
            'criteria' => $c,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
    }

    public function getNameUser() {
        return $this->rUser ? $this->rUser->username : null;
    }

}
