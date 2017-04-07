<?php
/**
 * This is the template for generating a controller class file.
 * The following variables are available in this template:
 * - $this: the ControllerCode object
 */

$hasImage = false;
$imageFieldName = array();
$file_name = '';
if (isset($this->type_option['form'])) {
    foreach ($this->type_option['form'] as $key => $val) {
        if (isset($val[0]) && $val[0] == 'file') {
            $hasImage = true;
            $file_name = $key;
        }
        if (isset($val[0]) && $val[0] == 'image') {
            $hasImage = true;
            $image_name = $key;
        }
    }
}
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseClass."\n"; ?>
{
    public $pluralTitle = '<?php echo $this->model_name; ?>s ';
    public $singleTitle = '<?php echo $this->model_name; ?>';
    public $cannotDelete = [];
<?php
    foreach($this->getActionIDs() as $action):
        if ($action == '_form' || $action == '_search')
            continue;
?>
<?php if ($action == 'index') { ?>
    public function actionIndex() {
        try {
            $model=new <?php echo $this->model_name; ?>('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['<?php echo $this->model_name; ?>']))
                $model->attributes=$_GET['<?php echo $this->model_name; ?>'];

            // export excel
            Yii::app()->session['data_excel'] = $model->searchExport();

            $this->render('index',[
                'model'=>$model, 'actions' => $this->listActionsCanAccess,
            ]);
        } catch (Exception $e) {
            Yii::log($this->singleTitle . " - Action Index - Back end exception " . print_r($e, true), 'error');
            $this->setNotifyMessage(NotificationType::Error, StaticMessage::ExceptionError . $e->getMessage());
        }
    }
<?php } 
elseif ($action == 'create') { ?>
    public function actionCreate(){
        try {
            $model = new <?php echo $this->model_name; ?>('create');
            if (isset($_POST['<?php echo $this->model_name; ?>'])) {
                <?php
                if ($hasImage) {
                ?>
//load working session id /////
                $model->loadWorkSessionId();
                ////////////////////////////////
                <?php } ?>
$model->attributes = $_POST['<?php echo $this->model_name; ?>'];
                if($model->save()) {
                <?php
                if ($hasImage) {
                ?>
    // save file or image //////////////////////
                    $model->saveFileFromSession('parent_id');
                    ////////////////////////////////////////////
                <?php
                }
                ?>
    $this->setNotifyMessage(NotificationType::Success, $this->singleTitle . StaticMessage::CreateSuccess);
                    $this->redirect(['view', 'id'=> $model->id]);
                } else {
                    $model->loadWorkSessionIdString();
                    $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . StaticMessage::CreateError);
                }
            } else {
                <?php
                    if ($hasImage) {
                ?>
                $model->checkSession();
                <?php } ?>
}
            $this->render('create', [
                'model' => $model,
                'actions' => $this->listActionsCanAccess,
            ]);
        }catch (exception $e) {
            Yii::log($this->singleTitle . " - Action Create - Back end exception " . print_r($e, true), 'error');
            $this->setNotifyMessage(NotificationType::Error, StaticMessage::ExceptionError . $e->getMessage());
        }
    }
<?php } 
elseif ($action == 'update') { ?>
    public function actionUpdate($id) {
        try{
            $model=$this->loadModel($id);
            if(isset($_POST['<?php echo $this->model_name; ?>']))
            {
                <?php
                if ($hasImage) {
                ?>
    // load working session id /////
                $model->loadWorkSessionId();
                ///////////////////////////////
                <?php } ?>
$model->attributes=$_POST['<?php echo $this->model_name; ?>'];
                if ($model->save()) {
                    <?php
                        if ($hasImage) {
                    ?>
        // save file or image /////////////////////
                        $model->saveFileFromSession('parent_id');
        //////////////////////////////////////////
                        <?php
                    }?>
$this->setNotifyMessage(NotificationType::Success, $this->singleTitle . StaticMessage::UpdateSuccess);
                    $this->redirect(['view', 'id'=> $model->id]);
                }
                else {
                    $model->loadWorkSessionIdString();
                    $this->setNotifyMessage(NotificationType::Error, $this->singleTitle . StaticMessage::UpdateError);
                }
            } else {
                <?php
                    if ($hasImage) {
                ?>
                // load image or file to session //////////////////////////////////////
                <?php
                    if ($file_name != '') {
                ?>
                $model->loadRelatedFilesToSessionMulti('FilesUpload', get_class($model), 'parent_id','files','file_name');
                <?php
                    }
                    if (isset($image_name) && $image_name != '') {
                ?>
                $model->loadRelatedFilesToSessionMulti('FilesUpload', get_class($model), 'parent_id','images','file_name');
                    <?php } ?>
                //////////////////////////////////////////////////////////////////////
                <?php } ?>
            }
            //$model->beforeRender();
            $this->render('update',[
                'model' => $model,
                'actions' => $this->listActionsCanAccess,
                'title_name' => $model-><?php echo $title_name; ?><?php echo "\n"; ?>
            ]);
        }catch (exception $e) {
            Yii::log($this->singleTitle . "  - Action Update - Back end exception " . print_r($e, true), 'error');
            $this->setNotifyMessage(NotificationType::Error, StaticMessage::ExceptionError . $e->getMessage());
        }
    }
<?php } elseif ($action == 'view') { ?>
    public function actionView($id) {
        try {
            $model = $this->loadModel($id);
            $this->render('view', [
                'model'=> $model,
                'actions' => $this->listActionsCanAccess,
                'title_name' => $model-><?php echo $title_name; ?><?php echo "\n"; ?>
            ]);
        } catch (Exception $e) {
            Yii::log($this->singleTitle . "  - Action View - Back end exception " . print_r($e, true), 'error');
            $this->setNotifyMessage(NotificationType::Error, StaticMessage::ExceptionError . $e->getMessage());
        }
    }
<?php } elseif ($action == 'delete') { ?>
    public function actionDelete($id) {
        try {
            if(Yii::app()->request->isPostRequest) {
                // we only allow deletion via POST request
                if (!in_array($id, $this->cannotDelete))
                {
                    if($model = $this->loadModel($id)){
                        <?php
                        if ($hasImage)
                        {
                            echo "\$model->deleteAllMedias();\n";
                        }
                        ?>
if($model->delete())
                            Yii::log("Delete record ".  print_r($model->attributes, true), 'info');
                    }

                    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                    if(!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
                }
            } else {
                Yii::log(StaticMessage::InvalidAction);
                throw new CHttpException(400, StaticMessage::InvalidAction);
            }
        } catch (Exception $e) {
            Yii::log($this->singleTitle . "  - Action View - Back end exception " . print_r($e, true), 'error');
            $this->setNotifyMessage(NotificationType::Error, StaticMessage::ExceptionError . $e->getMessage());
        }
    }
    <?php } else { ?>
    public function action<?php echo ucfirst($action); ?>()
    {
            $this->render('<?php echo $action; ?>');
    }
        <?php } ?>

<?php endforeach; ?>

    public function actionExport() {
        try {
            Yii::import('application.extensions.phpexcel.Classes.PHPExcel');
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()->setCreator("VerzDesign")
            ->setLastModifiedBy("VerzDesign")
            ->setTitle('Export Current List')
            ->setSubject("Office 2007 XLSX Document")
            ->setDescription("Trackings")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Trackings");
            $objPHPExcel->getActiveSheet()->setTitle('sheet1');
            $objPHPExcel->setActiveSheetIndex(0);

            $model = Yii::app()->session['data_excel'];
            if ($model) {
                //set header threat
                <?php
                $alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q'];
                $indexHeader = 0;
                foreach ($this->type_option['index'] as $index_key => $index_val) {
                    if ($index_val == 'string') {
                        if ($alphabet[$indexHeader] != "A") 
                            echo "\t\t\t\t";
                        echo "\$objPHPExcel->getActiveSheet()->setCellValue('$alphabet[$indexHeader]1', '$index_key', true);\n";

                        $indexHeader++;
                    }
                }
                ?>

                foreach ($model as $key => $row) {
                    <?php
                    $indexExport = 0;
                    foreach ($this->type_option['index'] as $index_key => $index_val) {
                        if ($index_val == 'string') {
                            if ($alphabet[$indexExport] != 'A')
                                echo "\t\t\t\t\t";
                            echo "\$objPHPExcel->getActiveSheet()->setCellValue('$alphabet[$indexExport]' . (\$key + 2), \$row->$index_key, true);\n";

                            $indexExport++;
                        }
                    }
                    ?>
                }
                //bold format
                $styleArray2 = [
                    'borders' => [
                        'allborders' => [
                            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                            'color' => [
                                'rgb' => 'FFFFFF'
                            ]
                        ],
                    ]
                ];
                $objPHPExcel->getActiveSheet()->getStyle('A1:<?php echo $alphabet[$indexHeader - 1] ?>1')->getFont()->setSize(13)->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A1:<?php echo $alphabet[$indexHeader - 1] ?>1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objPHPExcel->getActiveSheet()->getStyle('A1:<?php echo $alphabet[$indexHeader - 1] ?>1')->getFill()->getStartColor()->setRGB('DBEAF9');
                $objPHPExcel->getActiveSheet()->getStyle('A1:<?php echo $alphabet[$indexHeader - 1] ?>1')->getFont()->getColor()->setRGB('000000');
                $objPHPExcel->getActiveSheet()->getStyle('A1:<?php echo $alphabet[$indexHeader - 1] ?>1')->applyFromArray($styleArray2);
                //set width
                <?php
                $indexWidth = 0;
                foreach ($this->type_option['index'] as $index_key => $index_val) {
                    if ($index_val == 'string') {
                        if ($alphabet[$indexWidth] != 'A') 
                            echo "\t\t\t\t";
                        echo "\$objPHPExcel->getActiveSheet()->getColumnDimension('$alphabet[$indexWidth]')->setAutoSize(true);\n";

                        $indexWidth++;
                    }
                }
                ?>
                //
                <?php
                $indexStyle = 0;
                foreach ($this->type_option['index'] as $index_key => $index_val) {
                    if ($index_val == 'string') {
                        if ($alphabet[$indexStyle] != 'A') 
                            echo "\t\t\t\t";
                        echo "\$objPHPExcel->getActiveSheet()->getStyle('$alphabet[$indexStyle]1:$alphabet[$indexStyle]' . (\$key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);\n";

                        $indexStyle++;
                    }
                }
                ?>

                //save file
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                for ($level = ob_get_level(); $level > 0; --$level) {
                @ob_end_clean();
                }
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Content-type: ' . 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . '<?php echo $this->model_name; ?>' . '.' . 'xlsx' . '"');

                header('Cache-Control: max-age=0');
                $objWriter->save('php://output');
                Yii::app()->end();
            }
        } catch (Exception $e) {
            Yii::log($this->singleTitle . "  - Action View - Back end exception " . print_r($e, true), 'error');
            $this->setNotifyMessage(NotificationType::Error, StaticMessage::ExceptionError . $e->getMessage());
        }
    }

    /*
    * Bulk delete
    * If you don't want to delete some specified record please configure it in global $cannotDelete variable
    */
    public function actionDeleteAll()
    {
        try{
            $deleteItems = $_POST['index_grid_c0'];
            $shouldDelete = array_diff($deleteItems, $this->cannotDelete);

            if (!empty($shouldDelete))
            {
                <?php
                if ($hasImage)
                { ?>
                    foreach ($shouldDelete as $id) {
                        $model = $this->loadModel($id);
                        $model->deleteAllMedias();
                    }
                <?php }
                ?>
<?php echo $this->model_name; ?>::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
                $this->setNotifyMessage(NotificationType::Success, StaticMessage::DeleteAllSuccessed);
            }
            else
                $this->setNotifyMessage(NotificationType::Error, StaticMessage::DeleteAllError);

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
        } catch (Exception $e) {
            Yii::log($this->singleTitle . "  - Action DeleteAll - Back end exception " . print_r($e, true), 'error');
            $this->setNotifyMessage(NotificationType::Error, StaticMessage::ExceptionError . $e->getMessage());
        }
    }

    public function actionUpdateStatusAll() {
        $updateItems = $_POST['index_grid_c0'];
        $status = $_POST['status'];
        if (!empty($updateItems) && $status != '') {
            <?php echo $this->model_name; ?>::model()->updateAll(['status'=>$status], 'id in (' . implode(',', $updateItems) . ')');
            $this->setNotifyMessage(NotificationType::Success, StaticMessage::UpdateAllSuccessed);
        }
        else
            $this->setNotifyMessage(NotificationType::Error, StaticMessage::UpdateAllError);

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
        }

    <?php

            if ($hasImage):
    ?>
    /*
    * Remove upload image
    * Only files are deleted not folder. Run in ajax mode. Can modify in custom.js admin theme
    */
    public function actionRemoveImage($fieldName, $id)
    {
        try {
            $model = $this->loadModel((int)$id);
            $model->removeImage([$fieldName]);
            echo 'thumbnail-' . $id;
        } catch (Exception $e) {
            echo '';
        }
    }
    <?php endif;?>

    public function loadModel($id){
        //need this define for inherit model case. Form will render parent model name in control if we don't have this line
        $initMode = new <?php echo $this->model_name; ?>();
        $model=$initMode->findByPk($id);
        if($model===null)
            throw new CHttpException(404, StaticMessage::InvalidAction);
        return $model;
    }
}