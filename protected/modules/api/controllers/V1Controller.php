<?php 
class V1Controller extends ABaseController {

    public function actionList(){
        $modelName = $this->getModelName('Image');
        $rows = [];
        $offset = $this->request->getParam('offset');
        $limit = $this->request->getParam('limit');
        $page = $this->request->getParam('page', 'all');

        $c = new CDbCriteria();
        $this->setConditions($c, $modelName);
    }

    public function actionView(){
        
    }

    public function actionUpdate(){
        
    }

    public function actionCreate(){
        
    }

    public function actionDelete(){
        
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
            $c->compare('status');
        }
    }


}
?>