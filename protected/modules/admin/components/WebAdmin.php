<?php

class WebAdmin extends CWebUser {
    
    private $_model;
    // public $id;
 	/**
	 * @param WebUserIdentity
	 * @param int
	 */
    public function login($identity, $duration=0) {
        $this->id = $identity->id;
        parent::login($identity, $duration);
    }
 
 	/**
	 * @param boolean
	 */
    public function logout($destroySession = true) {
    	parent::logout($destroySession);
    }

    /**
     * @author Lien Son
     * @todo: Load user model
     * @param: string 
     * @return
     */
    public function loginRequired() {
        $app = Yii::app();
        $request = $app->getRequest();
        if (!$request->getIsAjaxRequest())
            $this->setReturnUrl($request->hostInfo . Yii::app()->baseUrl . '/' . $request->pathInfo);

        $moduleInUrl = explode('/', $request->pathInfo);
        
        if (($url = $this->loginUrl) !== null) {
            if (is_array($moduleInUrl)){
                if ($moduleInUrl[0] == 'admin'){
                    $url = ['admin/site/login'];
                }
            }

            if (is_array($url)) {
                $route = isset($url[0]) ? $url[0] : $app->defaultController;
                $url = $app->createUrl($route, array_splice($url, 1));
            }
            
            $request->redirect($url);
        } else {
            Yii::log('Login Required');
            throw new CHttpException(403, Yii::t('yii', 'Login Required'));
        }
    }

    /**
     * @author Lien Son
     * @todo: load model
     * @param: 
     * @return: object model users
     */
    protected function loadAdmin($id = null) {
        if($this->_model === null) {
            if($id !== null) {
                return Users::model()->findByPk($id);
            }
        }
    }

    /**
     * @author Lien Son
     * @todo: get Role Id
     * @param:  
     * @return: int role_id
     */
    public function getRoleId() {
        $model = $this->loadAdmin(Yii::app()->admin->id);
        return $model ? $model->role_id : null;
    }

    /**
     * @author Lien Son
     * @todo: get Username
     * @param:  
     * @return: string username
     */
    public function getUsername() {
        $model = $this->loadAdmin(Yii::app()->admin->id);
        return $model ? $model->username : null;
    }

    /**
     * @author Lien Son
     * @todo: get name
     * @param:  
     * @return: string full_name
     */
    public function getName() {
        $model = $this->loadAdmin(Yii::app()->admin->id);
        return $model ? $model->full_name : null;
    }
    
    /**
     * @author Lien Son
     * @todo: get name
     * @param:  
     * @return: string full_name
     */
    public function getIp() {
        $model = $this->loadAdmin(Yii::app()->admin->id);
        return $model ? $model->last_ip_login : null;
    }


}
?>