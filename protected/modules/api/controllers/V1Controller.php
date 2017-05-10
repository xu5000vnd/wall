<?php 
class V1Controller extends ABaseController {

    public function actionList(){
        // header('Content-type: application/json');
        // header('Access-Control-Allow-Origin: *');
        // header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        // header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, X-Auth-Token, X-CSRF-TOKEN');
        // echo CJSON::encode(['status'=>'error']);
        // die;
        $modelName = $this->getModelName('list');
        $rows = [];
        $limit = AConstants::DEFAULT_PAGING;
        $page = $this->request->getParam('page', 'all');

        $c = new CDbCriteria();
        $this->setConditions($c, $modelName);

        $nextPage = '';
        if($page == 'all') {
            $nextPage = 'noPage';
        } else {
            $total = $modelName::model()->count($c);
            if($page <= 0) {
                $page = 1;
            }

            $c->offset = ($page - 1) * $limit;

            if (($page * $limit) >= $total) {
                $nextPage = 'noPage';
            } else {
                $nextPage = $page + 1;
            }
        }
        
        $models = $modelName::model()->findAll($c);
        $needData = $this->request->getParam('needData', []);;
        $rows['rows'] = [];
        foreach ($models as $key => $model) {
            $rows['rows'][$key] = $this->parseData($model, $needData);
        }

        $rows['nextPage'] = $nextPage;

        $this->response->data = $rows;
        $this->response->send();
    }

    public function actionView(){
        
    }

    public function actionUpdate(){
        
    }

    public function actionCreate(){
        $data = [];
        $data['status'] = AConstants::ERROR;
        $modelName = $this->getModelName('create');
        $model = new $modelName;
        $cField = 0;
        foreach ($this->request->params as $var => $value) {
            if ($model->hasAttribute($var)) {
                $model->$var = $value;
                $cField++;
            }
        }

        if($cField > 0) {
            $model->save();
            $data['status'] = AConstants::SUCCESS;
        }

        $this->response->data = $data;
        $this->response->send();
        
    }

    public function actionDelete(){
        $data = [];
        $data['status'] = AConstants::ERROR;
        $modelName = $this->getModelName('delete');
        $id = $this->request->getParam('id', 0);;
        $model = new $modelName;
        $model = $model->findByPk($id);
        if($model) {
            $model->delete();
            $data['status'] = AConstants::SUCCESS;
        }
        $this->response->data = $data;
        $this->response->send();
    }

    /**
     * @author Lien Son
     * @todo: call handler to process
     * @param: string 
     * @return
     */
    public function getModelName($action) {
        $modelName = '';
        $requestModel = $this->request->getParam('model');
        switch ($requestModel) {
            case 'index':
                $modelName = 'Image';
                break;

            case 'category':
                $modelName = 'Category';
                break;

            case 'image':
                $modelName = 'Image';
                break;

            case 'favorite':
                $modelName = 'Favorite';
                if($action == 'delete') {
                    AFavorite::deleteFav($this);
                }
                break;

            case 'vote':
                $modelName = 'Vote';
                break;
            case 'getListFav':
                AFavorite::getListFav($this);
                break;
        }

        if (empty($modelName)) {
            $this->sendModelNotFound();
        }

        return $modelName;
    }

    /**
     * @author haidt <haidt3004@gmail.com>
     * @copyright 2016 VerzDesign        
     * @param object $c - cdbcriteria    
     * @todo set condition
     */
    public function setConditions(&$c, $modelName) {
        $requestModel = $this->request->getParam('index');
        if ($requestModel == 'index') {
        }

        if($modelName::model()->hasAttribute('t.status')) {
            $c->compare('t.status', STATUS_ACTIVE);
        }
    }


}
?>