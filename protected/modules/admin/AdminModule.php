<?php

class AdminModule extends CWebModule
{
    public $defaultController = 'site';

    public function init()
    {                       
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(array(
            'admin.models.*',
            'admin.components.*',
        ));

        Yii::app()->setComponents(array(
            'errorHandler' => array(
                'errorAction' => 'admin/error',
            ),
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            Yii::app()->errorHandler->errorAction='admin/site/error';
            $route = $controller->id . '/' . $action->id;
            $publicPages = array(
                'site/login',
                'site/error',
                'site/logout',
            );
            
            if(!isset(Yii::app()->admin->id)){
                 if(isset($_COOKIE[COOKIE_ADMIN])){
                    $data = json_decode($_COOKIE[COOKIE_ADMIN],true);
                    $model=new AdminLoginForm;
                    $_POST['AdminLoginForm']['username'] = $data[COOKIE_USERNAME];
                    $_POST['AdminLoginForm']['password'] = $data[COOKIE_PASSWORD];
                    if(isset($_POST['AdminLoginForm'])) {
                        $model->attributes=$_POST['AdminLoginForm'];
                        if($model->validate()){
                            if (strtolower(Yii::app()->admin->returnUrl)!==strtolower(Yii::app()->baseUrl.'/')) {
                                Yii::app()->controller->redirect(Yii::app()->admin->returnUrl);
                            }

                            switch (Yii::app()->admin->role_id){
                                case ROLE_ADMIN:
                                    Yii::app()->controller->redirect(Yii::app()->createAbsoluteUrl('admin/site/index'));
                                break;

                                default:
                                    Yii::app()->controller->redirect(Yii::app()->createAbsoluteUrl('/'));
                            }

                        }
                    }                   
               }        
            }               

                
           if (!in_array($route, $publicPages))
               if(!isset (Yii::app()->admin->id)) {
                   Yii::app()->admin->loginRequired();             
               }

            return true;
        }

        return false;            
    }
}
