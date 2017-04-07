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

                    //for log
                    $data = [
                        'data' => 'Logged in.'
                    ];

                    ActivityLogs::writeLog($data);
                    //


                    $this->redirect(url('admin/site/index'));
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
            if(Yii::app()->admin->id) {
                //for log
                $data = [
                    'data' => 'Logged in.'
                ];
                
                ActivityLogs::writeLog($data);
                //
            }
            
            Yii::app()->admin->logout();
            $this->redirect(url('admin/site/login'));
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }
}
?>