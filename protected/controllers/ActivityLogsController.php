<?php

class ActivityLogsController extends AdminController
{
    public $pluralTitle = 'ActivityLogss ';
    public $singleTitle = 'ActivityLogs';
    public $cannotDelete = [];
    public function actionDelete($id) {
        try {
            if(Yii::app()->request->isPostRequest) {
                // we only allow deletion via POST request
                if (!in_array($id, $this->cannotDelete))
                {
                    if($model = $this->loadModel($id)){
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
    
    public function actionIndex() {
        try {
            $model=new ActivityLogs('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['ActivityLogs']))
                $model->attributes=$_GET['ActivityLogs'];

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

    public function actionView($id) {
        try {
            $model = $this->loadModel($id);
            $this->render('view', [
                'model'=> $model,
                'actions' => $this->listActionsCanAccess,
                'title_name' => $model->id
            ]);
        } catch (Exception $e) {
            Yii::log($this->singleTitle . "  - Action View - Back end exception " . print_r($e, true), 'error');
            $this->setNotifyMessage(NotificationType::Error, StaticMessage::ExceptionError . $e->getMessage());
        }
    }


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
                $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ip', true);

                foreach ($model as $key => $row) {
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . ($key + 2), $row->ip, true);
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
                $objPHPExcel->getActiveSheet()->getStyle('A1:A1')->getFont()->setSize(13)->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A1:A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objPHPExcel->getActiveSheet()->getStyle('A1:A1')->getFill()->getStartColor()->setRGB('DBEAF9');
                $objPHPExcel->getActiveSheet()->getStyle('A1:A1')->getFont()->getColor()->setRGB('000000');
                $objPHPExcel->getActiveSheet()->getStyle('A1:A1')->applyFromArray($styleArray2);
                //set width
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                //
                $objPHPExcel->getActiveSheet()->getStyle('A1:A' . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                //save file
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                for ($level = ob_get_level(); $level > 0; --$level) {
                @ob_end_clean();
                }
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Content-type: ' . 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . 'ActivityLogs' . '.' . 'xlsx' . '"');

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
                ActivityLogs::model()->deleteAll('id in (' . implode(',', $shouldDelete) . ')');
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
            ActivityLogs::model()->updateAll(['status'=>$status], 'id in (' . implode(',', $updateItems) . ')');
            $this->setNotifyMessage(NotificationType::Success, StaticMessage::UpdateAllSuccessed);
        }
        else
            $this->setNotifyMessage(NotificationType::Error, StaticMessage::UpdateAllError);

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
        }

    
    public function loadModel($id){
        //need this define for inherit model case. Form will render parent model name in control if we don't have this line
        $initMode = new ActivityLogs();
        $model=$initMode->findByPk($id);
        if($model===null)
            throw new CHttpException(404, StaticMessage::InvalidAction);
        return $model;
    }
}