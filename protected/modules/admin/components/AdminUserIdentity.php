<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminUserIdentity extends UserIdentity
{


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
        $record = Users::model()->findByAttributes(array('username' => $this->username));
            
        if ($record === null)
        {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        else if ($record->password != md5($this->password))
        {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
        else if ($record->status == 0)
        {
            $this->errorCode = self::ERROR_USERNAME_BLOCKED;
        }
        else
        {
            $this->_id = $record->id;
            $this->role_id = $record->role_id;
            $this->_isAdmin = true;
            $this->errorCode = self::ERROR_NONE;
            // Update last IP and time
            $record->last_time_login = date('Y-m-d H:i:s');
            $record->last_ip_login = isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : $_SERVER['REMOTE_ADDR'];
            $record->ip = isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : $_SERVER['REMOTE_ADDR'];
            Yii::app()->session['LOGGED_USER'] = $record;

            if (!$record->update())
                Yii::log(print_r($record->getErrors(), true), 'error', 'AdminUserIdentity.authenticate');


            if (isset($_POST['AdminLoginForm']['rememberMe']))
            {
                if ($_POST['AdminLoginForm']['rememberMe'] == 1)
                {
                    $expire = time() + 7 * 24 * 60 * 60;
                    $array[COOKIE_USERNAME] = $record->username;
                    $array[COOKIE_PASSWORD] = $record->password;
                    setcookie(COOKIE_ADMIN, json_encode($array), $expire);
                }
            }
        }

        return !$this->errorCode;
    }
}
