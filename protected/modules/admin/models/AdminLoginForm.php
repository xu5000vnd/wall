<?php
/**
 * LoginForm class.
 * LoginForm is the data structure for keeping

 * user login form data. It is used by the 'login' action of 'SiteController'.

 */

class AdminLoginForm extends CFormModel
{
    private $_identity;
    public $username;
    public $password;
    public $rememberMe;

    /**
     * Declares the validation rules.
     * The rules state that nick_name and password are required,
     * and password needs to be authenticated.
     */

    public function rules()
    {
        return array(
            // nick_name and password are required
            array('username, password', 'required'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'rememberMe'=>'Remember me',
        );
    }

    /**
    * Authenticates the password.
    * This is the 'authenticate' validator as declared in rules().
    */
    public function authenticate($attribute,$params)
    {
                    // echo "<pre>";
                    // //print_r($form->errorSummary($model));
                    // print_r($this->attributes);
                    // echo "</pre>";die;
        if(!$this->hasErrors())
        {

            
            $this->_identity = new AdminUserIdentity($this->username,$this->password);
            $this->_identity->authenticate();
            
            switch($this->_identity->errorCode)
            {
                case AdminUserIdentity::ERROR_NONE:
                    $duration = $this->rememberMe ? 3600*24*30 : 0; // 30 days
                    Yii::app()->user->login($this->_identity, $duration);
                    break;

                case AdminUserIdentity::ERROR_USERNAME_INVALID:
                    $this->addError("username","Username is not valid.");
                    break;
                case AdminUserIdentity::ERROR_USERNAME_BLOCKED:
                    $this->addError("username","Account has been blocked.");
                    break;
                case AdminUserIdentity::ERROR_PASSWORD_INVALID:
                    $this->addError("password","Wrong password");
                    break;
            }
        }
    }
}
?>