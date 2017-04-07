<?php 
class SiteController extends AdminController {

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
            $model = new AdminLoginForm();
            if (isset($_POST['AdminLoginForm'])) {
                $model->attributes = $_POST['AdminLoginForm'];

                if ($model->validate()) {
                    //save Log
                    LogActive::saveLog(LogActive::TYPE_LOGIN, "Logged in");
                    
                    if (strtolower(Yii::app()->user->returnUrl)!==strtolower(Yii::app()->baseUrl.'/')){
                        $this->redirect(Yii::app()->user->returnUrl);
                    }

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
            if(isset(Yii::app()->user->id)) {
                //save Log
                LogActive::saveLog(LogActive::TYPE_LOGIN, 'Logged out');
            }

            Yii::app()->user->logout();
            $this->redirect(url('admin/site/login'));
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }
}
?>