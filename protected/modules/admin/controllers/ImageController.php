<?php 
class ImageController extends AdminController {
    public $pluralTitle = 'Image';
    public $singleTitle = 'Image';
    
	public function actionIndex() {
        try {
            $model = new Image();
            if(isset($_GET['Image'])) {
                $model->attributes = $_GET['Image'];
            }

            $this->render('index',['model' => $model]);
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

    public function actionCreate() {
        try {
            $model = new Image('create');
            $model->status = TYPE_YES;
            if(isset($_POST['Image'])) {
                $model->attributes = $_POST['Image'];
                if($model->validate()) {
                    if($model->save()) {
                        $model->saveImage('file_name');

                        Yii::app()->user->setFlash('success', $this->singleTitle . ' has been created');

                        //for log
                        $data = [
                            'data' => 'Created a Image',
                            'record_id' => $model->id
                        ];

                        ActivityLogs::writeLog($data);
                        //

                        $this->redirect(url('admin/image/index'));
                    } else {
                        Yii::app()->user->setFlash('error', $this->singleTitle . ' cannot be created for some reasons');
                    }
                } else {
                    Yii::app()->user->setFlash('error', $this->singleTitle . ' has been created');
                }
            }

            $this->render('create',['model' => $model]);
        } catch( Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }

    public function actionUpdate($id) {
        try {
            $model = $this->loadModel('Image', $id);
            if(isset($_POST['Image'])) {
                $model->attributes = $_POST['Image'];
                if($model->validate()) {
                    if($model->save()) {
                        $model->saveImage('file_name');

                        Yii::app()->user->setFlash('success', $this->singleTitle . ' has been created');

                        //for log
                        $data = [
                            'data' => 'Updated a Image',
                            'record_id' => $model->id
                        ];

                        ActivityLogs::writeLog($data);
                        //

                        $this->redirect(url('admin/image/index'));
                    } else {
                        Yii::app()->user->setFlash('error', $this->singleTitle . ' cannot be created for some reasons');
                    }
                } else {
                    Yii::app()->user->setFlash('error', $this->singleTitle . ' has been created');
                }
            }

            $this->render('update',['model' => $model]);
        } catch( Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }
}
?>