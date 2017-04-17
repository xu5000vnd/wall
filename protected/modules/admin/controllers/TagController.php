<?php 
class TagController extends AdminController {
    public $pluralTitle = 'Tag';
    public $singleTitle = 'Tag';
    
	public function actionIndex() {
        try {
            $model = new Tag();
            if(isset($_GET['Tag'])) {
                $model->attributes = $_GET['Tag'];
            }

            $this->render('index',['model' => $model]);
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }

    public function actionCreate() {
        try {
            $model = new Tag('create');
            $model->status = TYPE_YES;
            if(isset($_POST['Tag'])) {
                $model->attributes = $_POST['Tag'];
                if($model->validate()) {
                    if($model->save()) {
                        $model->saveTag('file_name');

                        Yii::app()->user->setFlash('success', $this->singleTitle . ' has been created');

                        $this->redirect(url('admin/tag/index'));
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
            $model = $this->loadModel('Tag', $id);
            if(isset($_POST['Tag'])) {
                $model->attributes = $_POST['Tag'];
                if($model->validate()) {
                    if($model->save()) {
                        $model->saveTag('file_name');

                        Yii::app()->user->setFlash('success', $this->singleTitle . ' has been created');

                        $this->redirect(url('admin/tag/index'));
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