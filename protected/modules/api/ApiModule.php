<?php

class ApiModule extends CWebModule
{
	public $connectionString;
    public $host;
    public $dbName;
    public $username;
    public $password;

    public function init()
    {                       
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(array(
            'api.models.*',
            'api.components.*',
        ));

        Yii::app()->setComponents(array(
            'errorHandler' => array(
                'errorAction' => 'api/default/error',
            ),
        ));
    }
}
