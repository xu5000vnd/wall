<?php

class ABaseController extends CController {

    public $request;
    public $response;

    public function init() {
        $this->response = new AResponse();
        $this->request = new ARequest();

        $GLOBALS['ctrl'] = $this;

        return parent::init();
    }

    public function missingAction($actionID) {
        $this->response->errorCode = AConstants::HTTP_STATUS_400;
        $this->response->description = "Request method is not allowed.";
        $this->response->send();
    }

    public function actionError() {
        $error = Yii::app()->errorHandler->error;
        $this->response->errorCode = AConstants::HTTP_STATUS_400;
        $this->response->description = isset($error['message']) ? $error['message'] : 'Unknow error.';
        $this->response->send();
    }

    /**
     * @author Horison <xu5000vnd@gmail.com>
     * @copyright 2016 VerzDesign 	 	 
     * @param array $attrs - array attribute params
     * @return void
     * @todo check request params
     */
    public function checkGetRequestParams($attrs) {
        foreach ($attrs as $attr) {
            if (!isset($_GET[$attr])) {
                $httpStatus = AConstants::HTTP_STATUS_501;
                $this->response->errorCode = $httpStatus;
                $this->response->description = "Parameter " . $attr . " is required";
                $this->response->send();
            }
        }
    }

    /**
     * @author Horison <xu5000vnd@gmail.com>
     * @copyright 2016 VerzDesign 	 	 
     * @param object $model 
     * @return void
     * @todo check model
     */
    public function checkModel($model, $modelName = '') {
        $modelName = empty($modelName) ? 'Model' : $modelName;
        if ($model === null) {
            $this->response->errorCode = AConstants::HTTP_STATUS_400;
            $this->response->description = Yii::t('translation', $modelName . ' not found.');
            $this->response->send();
        }
    }

    /**
     * @author Horison <xu5000vnd@gmail.com>
     * @copyright 2016 VerzDesign 	 	 
     * @param object $model 
     * @return void
     * @todo send model error
     */
    public function sendModelError($model) {
        $this->response->errorCode = AConstants::HTTP_STATUS_400;
        $this->response->description = $this->getModelError($model);
        $this->response->send();
    }

    /**
     * @author Horison <xu5000vnd@gmail.com>
     * @copyright 2016 VerzDesign 	 	 
     * @param string $msg
     * @return void
     * @todo send bad request
     */
    public function sendBadRequest($msg = 'Bad request.') {
        $this->response->errorCode = AConstants::HTTP_STATUS_400;
        $this->response->description = $msg;
        $this->response->send();
    }

    /**
     * @author Horison <xu5000vnd@gmail.com>
     * @copyright 2016 VerzDesign 	 	 
     * @param object $model 
     * @return void
     * @todo send model error
     */
    public function sendResponseData($model) {
        $this->response->data = $this->parseData($model);
        $this->response->send();
    }

    /**
     * @author Horison <xu5000vnd@gmail.com>
     * @copyright 2016 VerzDesign 	 	 
     * @param object $model 
     * @return void
     * @todo send access denied
     */
    public function sendAccessDenied($msg = "Access denied.") {
        $this->response->errorCode = AConstants::HTTP_STATUS_400;
        $this->response->description = $msg;
        $this->response->send();
    }

    /**
     * @author Horison <xu5000vnd@gmail.com>
     * @copyright 2016 VerzDesign 	 	 
     * @param object $model
     * @return array
     * @todo get all relations of model
     */
    public function loadRelations($model) {
        $data = [];
        $relation = $this->request->getParam('relation', AConstants::TYPE_NO);
        if (strtolower($relation) == AConstants::TYPE_YES) {
            foreach ($model->relations() as $rName => $value) {
                if (!in_array($rName, self::$notLoadRelation)) {
                    if (isset($model->$rName) && count($model->$rName) > 0) {
                        $items = [];
                        if (is_array($model->$rName)) {
                            foreach ($model->$rName as $item) {
                                $items[] = $this->parseData($item);
                            }
                        } else {
                            $items = $this->parseData($model->$rName);
                        }
                        $data[$rName][] = $items;
                    }
                }
            }
        }
        return $data;
    }

    /**
     * @author Horison <xu5000vnd@gmail.com>
     * @copyright 2016 VerzDesign 	 	 
     * @param object $model
     * @todo parse data
     */
    public function parseData($model, $needData = []) {
        $data = [];
        //do something before parse data
        $this->beforeParseData($data, $model);

        if(empty($needData)) {
            //do load main data
            $data = $model->attributes;
        } else {
            if(is_array($needData)) {
                foreach ($needData as $value) {
                    if($model->hasAttribute($value)) {
                        $data[] = $model->$value;
                    }
                }
            }
        }

        //do something parse parse data
        $this->afterParseData($data, $model);
        return $data;
    }

    /**
     * @author Horison <xu5000vnd@gmail.com>
     * @copyright 2016 VerzDesign 	 	 
     * @param object $model
     * @todo handle after save model
     */
    public function handleAfterSaveModel($model) {
        //need override        
    }

    /**
     * @author Horison <xu5000vnd@gmail.com>
     * @copyright 2016 VerzDesign 	 	 
     * @param array $data
     * @param object $model
     */
    public function beforeParseData(&$data, $model) {
        //...
    }

    /**
     * @author Horison <xu5000vnd@gmail.com>
     * @copyright 2016 VerzDesign 	 	 
     * @param array $data
     * @param object $model
     */
    public function afterParseData(&$data, $model) {
        //get files upload if has
        // $this->getFileUpload($data, $model);

        if($model->hasAttribute('file_name')) {
            $data['url_image'] =  ImageHelper::getImageUrlBySize($model, 'file_name', '350x300');
            $data['full_image'] =  ImageHelper::getImageUrlBySize($model, 'file_name','',true);
        }
        //...do more
    }

    /**
     * @author Horison <xu5000vnd@gmail.com>
     * @copyright 2016 VerzDesign 	 	 
     * @param array $data
     * @param object $model
     */
    public function getFileUpload(&$data, $model) {
        $data['images_upload'] = $model->getArrFilesUrl('images');
        $data['files_upload'] = $model->getArrFilesUrl('files');
    }

    /**
     * @author Horison <xu5000vnd@gmail.com>
     * @param object $model 
     * @return void
     * @todo send model error
     */
    public function sendModelNotFound($modelName = '') {
        $modelName = empty($modelName) ? 'Model' : $modelName;
        $this->response->errorCode = AConstants::HTTP_STATUS_400;
        $this->response->description = Yii::t('translation', $modelName . ' not found.');
        $this->response->send();
    }

}
