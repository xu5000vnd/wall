<?php

class WebUser extends CWebUser {
	/**
     * The user is admin when is not guest and have value true of "isAdmin" parameter of "session"
	 * @return bool
	 */
        private $_model;
    
	public function getIsAdmin(){
		return !$this->getIsGuest() && Yii::app()->getSession()->get('isAdmin');
	}

    /**
     * The user is member when is not guest and is not admin
     * @return bool
     */

    public function getRoleId(){
        if(Yii::app()->getSession()->get('roleId'))
            return Yii::app()->getSession()->get('roleId');
        return null;
    }


    public function getUsername(){
        $model = User::model()->findByPk(Yii::app()->user->id); 
        return $model ? $model->username : null;
    }
    
	
 	/**
	 * @param WebUserIdentity
	 * @param int
	 */
    public function login($identity, $duration=0) {
        parent::login($identity, $duration);
        Yii::app()->getSession()->add('isAdmin', $identity->getIsAdmin());
        Yii::app()->getSession()->add('roleId', $identity->getRoleId());
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
    
}
?>