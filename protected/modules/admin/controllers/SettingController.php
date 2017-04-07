<?php

class SettingController extends AdminController {

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $model = new SettingForm;
        $model->scenario = "updateSettings";
        $setting = Yii::app()->setting;
        $listAttributes = SettingForm::getAllAttributes();
        if (isset($_POST['SettingForm'])) {
            $model->attributes = $_POST['SettingForm'];

            // $this->saveFile($model, 'logoBE');
            // $this->saveFile($model, 'favicon');
            // $this->saveFile($model, 'logoEmail');
            // $this->saveFile($model, 'fileAuthorizationLetter');

            if ($model->validate()) {
                if ($listAttributes && array($listAttributes)) {
                    foreach ($listAttributes as $attr) {
                        $setting->setDbItem($attr, $model->$attr);
                    }
                }
                Yii::app()->admin->setFlash('setting_s', 'Setting has been successfully updated.');
            } else {
                Yii::app()->admin->setFlash('setting_e', 'Setting have some following errors.');
            }
        } else {
            if ($listAttributes && array($listAttributes)) {
                foreach ($listAttributes as $attr) {
                    $temp = $setting->getItem($attr);
                    if (!empty($temp)) {
                        $model->$attr = $setting->getItem($attr);
                    }
                }
            }
        }
        $this->render('index', array('model' => $model,));
    }

    /**
     * @author Lien Son
     * @todo: Save file upload
     * @param:  
     * @return
     */
    public function saveFile($model, $nameFile) {
        $setting = Yii::app()->setting;
        $file = CUploadedFile::getInstance($model, $nameFile);

        if ($file != '') {
            $old_image = Yii::app()->setting->getItem($nameFile);
            $name = preg_replace('/\.\w+$/', '', $file->name);
            $name = str_replace(' ', '_', $name);

            $newName = $name . '_' . time() . rand(1, 10000) . '.' . $file->extensionName;

            $model->{$nameFile} = $newName;
        } else {

            $model->{$nameFile} = $setting->getItem($nameFile);
        }

        //save file
        if ($file !== null) {

            $baseImagePath = ROOT . SettingForm::PATH_UPLOAD_FILE;

            if ($file->saveAs($baseImagePath . $newName))
                $setting->setDbItem($nameFile, $newName);

            if (is_file($baseImagePath . $old_image)) {
                unlink($baseImagePath . $old_image);
            }
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Setting::model()->findByPk($id);
        if ($model === null) {
            Yii::log('The requested page does not exist.');
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

}
