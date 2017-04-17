<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    public $login_by;
    protected $_isAdmin = false;
    public $role_id;
    public $_id;
    const ERROR_USERNAME_BLOCKED = 3;
    /**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        $login_by = $this->login_by;
        $record = User::model()->findByAttributes(array($login_by=>$this->$login_by));

        if($record === null) {
            $this->errorCode =  self::ERROR_USERNAME_INVALID;
        } else if(trim($record->password) != hash("sha256", $this->password)) {
            $this->errorCode =  self::ERROR_PASSWORD_INVALID;
        } else if($record->status == STATUS_INACTIVE) {
            $this->errorCode =  self::ERROR_USERNAME_BLOCKED;
        } else {
            $this->errorCode = self::ERROR_NONE;
            $this->role_id = $record->role_id;
            $this->_id = $record->id;
            $this->_isAdmin = false;

            if ($record->role_id == ROLE_ADMIN) {
                $this->_isAdmin = true;
            }

            // Update last IP and time
            $record->last_ip = isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : $_SERVER['REMOTE_ADDR'];
            $record->last_active = date("Y-m-d H:i:s");
            $record->update();

            if (!Yii::app()->user->id) {
                //save Log
                // LogActive::saveLog(LogActive::TYPE_LOGIN, 'Logged in', $record->member_ID);
            }
        }

        return !$this->errorCode;
	}

    public function getIsAdmin()
    {
        return $this->_isAdmin;
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    public function getId() {
        return $this->_id;
    }
}