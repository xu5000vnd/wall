<?php
/**
 * This is the model class for table "{{_users}}".
 *
 * The followings are the available columns in table '{{_users}}':
 * @property integer id
 * @property string username
 * @property string password
 * @property string email
 * @property string name
 * @property integer role_id
 * @property integer status
 * @property string last_time_login
 * @property string last_ip_login
 * @property string created_date
 */

class Users extends _BaseModel {

    public $password_new;
    public $password_tmp;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{_users}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, role_id, status, email', 'required', 'on' => 'create, update'),
            ['password_new', 'length', 'min' => 6],
            array('password_new, password_tmp', 'required', 'on' => 'create'),
            array('email', 'email', 'on' => 'create, update'),
            array('email, username', 'unique', 'on' => 'create, update'),
            array('password_tmp', 'compare', 'compareAttribute' => 'password_new'),
            array('username, password, status, role_id, email, last_time_login, last_ip_login, created_date, ip', 'safe'),
            array('id, username, password, status, role_id, email, last_time_login, last_ip_login, created_date, ip', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return [
            'password_tmp' => 'Password Confirm',
            'role_id' => 'Role'
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return[
            'rRole' => array(self::BELONGS_TO, 'Roles', 'role_id'),
        ];
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Server the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function search() {
        $criteria = new CDbCriteria();
        $criteria->compare('username', $this->username, true);
        $criteria->compare('id', '<>' . ADMIN_ID);

        $sort = new CSort();
        $sort->attributes = array('*');
        $sort->defaultOrder = 't.id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }

    public function canDelete() {
        return true;
    }

    public function getRole() {
        return $this->rRole ? $this->rRole->name : '';
    }

    public static function listData() {
        return CHtml::listData(self::model()->findAll(), 'id', 'username');
    }

}
