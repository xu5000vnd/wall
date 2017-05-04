<?php
class SiteController extends _BaseController
{

    public function actionIndex() {
        try {
            $this->render('index');
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }

    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionLogin() {
        try {
            $model = new LoginForm();
            $model->login_by = 'username';
            if (isset($_POST['LoginForm'])) {
                $model->attributes = $_POST['LoginForm'];
                if ($model->validate()) {
                    //save Log
                    LogActive::saveLog(LogActive::TYPE_LOGIN, "Logged in");
                    
                    if (strtolower(Yii::app()->user->returnUrl)!==strtolower(Yii::app()->baseUrl.'/'))
                        $this->redirect(Yii::app()->user->returnUrl);

                    $this->redirect(Yii::app()->baseUrl);

                }
            }

            $this->render('login', ['model' => $model]);
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }

    public function actionLogout() {
        try {
            //save Log
            LogActive::saveLog(LogActive::TYPE_LOGIN, 'Logged out');

            Yii::app()->user->logout();
            $this->redirect(url('site/login'));
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }

    public function actionLogActive() {
        $model = new LogActive();
        $model->unsetAttributes();
        if (isset($_GET['LogActive']))
        {
            $model->attributes = $_GET['LogActive'];
        }
        
        $this->render('log_active', ['model' => $model]);
    }

    public function actionTestapi() {
        $this->layout=false;
        $this->render('testapi');
    }
}