<?php

class ActivityLogsController extends AdminController
{
    public $pluralTitle = 'ActivityLog ';
    public $singleTitle = 'ActivityLog';

    public function actionIndex() {
        try {
            $model=new ActivityLogs('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['ActivityLogs']))
                $model->attributes=$_GET['ActivityLogs'];


            $this->render('index',[
                'model'=>$model
            ]);
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }
}