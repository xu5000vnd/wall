<?php
class _BaseController extends CController
{
    public $layout='//layouts/site';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }
    
    // public function accessRules() {
    //     $accessArray = array();
    //     $controller = Yii::app()->controller->id;
    //     $action = Yii::app()->controller->action->id;
    //     $arrIgnore = ['login','logout', 'error'];
    //     if (in_array($action, $arrIgnore)) {
    //         return [
    //                 array(
    //                     'allow',
    //                     'actions'=>[$action],
    //                     'users'=>array('*'),
    //                 )
    //             ];
    //     }

    //     $role_id = isset(Yii::app()->user->id) ? Yii::app()->user->getRoleId() : 0;

    //     $actionsRole = ActionsRole::model()->find("controller like '%$controller%' and role_id = $role_id");
    //     if(!$actionsRole)
    //         return array(array('deny'));

    //     $array_action = array_map('trim',explode(",",trim($actionsRole->action)));

    //     $accessArray[] = array('allow',
    //                            'actions'=>$array_action,
    //                            'users'=>array('*'),
    //                         );          

    //     $accessArray[] = array('deny', 'users'=>array('*'),
    //         'deniedCallback'=>function() { Yii::app()->controller->redirect(array ('site/error')); }
    //         );
        
    //     return $accessArray;
    // }
}
