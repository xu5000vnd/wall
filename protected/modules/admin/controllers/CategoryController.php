<?php 
class CategoryController extends AdminController {
    public $pluralTitle = 'Category';
    public $singleTitle = 'Category';
    
	public function actionIndex() {
        try {
            $model = new Category();
            if(isset($_GET['Category'])) {
                $model->attributes = $_GET['Category'];
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
            $model = new Category('create');
            $model->status = TYPE_YES;
            if(isset($_POST['Category'])) {
                $model->attributes = $_POST['Category'];
                if($model->validate()) {
                    if($model->save()) {
                        $model->saveImage('file_name');

                        Yii::app()->user->setFlash('success', $this->singleTitle . ' has been created');

                        $this->redirect(url('admin/category/create'));
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

}
?>