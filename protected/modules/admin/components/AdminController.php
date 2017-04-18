<?php 
class AdminController extends _BaseController {
    public $layout = '/layouts/main';

    public $breadcrumbs = [];

    public $menu = [];

    public $pluralTitle = '';
    public $singleTitle = '';

    /*
     * define for icon
     *
     */
    public $iconList = 'glyphicon glyphicon-th-list';
    public $iconEdit = 'glyphicon glyphicon-pencil';
    public $iconCancel = 'glyphicon glyphicon-remove';
    public $iconSave = 'glyphicon glyphicon-floppy-disk';
    public $iconCreate = 'glyphicon glyphicon-plus';
    public $iconDelete = 'glyphicon glyphicon-trash';
    public $iconSearch = 'glyphicon glyphicon-search';
    public $iconBack = 'glyphicon glyphicon-arrow-left';


    public function renderBreadcrumbs($title) {
        $breadcrumHtml = '';
        $html = '';
        if (isset($this->breadcrumbs)):
            $breadcrumHtml = $this->widget('zii.widgets.CBreadcrumbs', array(
                'links' => $this->breadcrumbs,
                'tagName' => 'ol', // container tag
                'htmlOptions' => array('class' => 'breadcrumb'), // no attributes on container
                'separator' => '', // no separator
                'homeLink' => '<li><i class="fa fa-home"></i><a href="' . Yii::app()->createAbsoluteUrl('admin/site/index') . '">Home</a></li>', // home link template
                'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>', // active link template
                'inactiveLinkTemplate' => '<li class="selected">{label}</li>', // in-active link template
            ), true);

            $html = '<div class="row"><div class="col-lg-12">
                        <h3 class="page-header">' . $title . '</h3>' . $breadcrumHtml .
                        '</div>
                    </div>';
        endif;
        echo $html;
    }

    public function renderNotifyMessage() {
        if(Yii::app()->user->hasFlash('success'))
        {
            echo '<div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'
                . Yii::app()->user->getFlash('success') .
                '</div>';
        }

        if(Yii::app()->user->hasFlash('error'))
        {
            echo '<div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'
                . Yii::app()->user->getFlash('error') .
                '</div>';
        }
    }

    public function renderControlNav() {

        //generate action button
        $htmlNav = '<div class="navbar-right">
                        <div class="btn-group">';
        if (is_array($this->menu) && !empty($this->menu)) {
            foreach ($this->menu as $menuItems) {
                $addIcon = '';
                if (strpos(strtolower($menuItems['label']), 'create') !== false)
                    $addIcon = '<span class="glyphicon glyphicon-plus"></span> ';
                elseif (strpos(strtolower($menuItems['label']), 'update') !== false)
                    $addIcon = '<span class="glyphicon glyphicon-pencil"></span> ';
                elseif (strpos(strtolower($menuItems['label']), 'manage') !== false)
                    $addIcon = '<span class="glyphicon glyphicon-th-list"></span> ';
                elseif (strpos(strtolower($menuItems['label']), 'view') !== false)
                    $addIcon = '<span class="glyphicon glyphicon-list-alt"></span> ';
                elseif (strpos(strtolower($menuItems['label']), 'delete') !== false)
                    $addIcon = '<span class="glyphicon glyphicon-trash"></span> ';
                else
                {
                    //Austin in case we put custom icon for button
                    if (isset($menuItems['icon']))
                        $addIcon = '<span class="' . $menuItems['icon'] . '"></span> ';
                }

                //Austin in case we need add more attributes to button tag
                if (isset($menuItems['htmlOpts']) && is_array($menuItems['htmlOpts'])) //with html options
                {
                    if (isset($menuItems['url']) && $menuItems['url'] != '')//link
                        $htmlNav .= CHtml::link($addIcon . $menuItems['label'], $menuItems['url'], $menuItems['htmlOpts']);

                }
                else//without html options
                {
                    if (isset($menuItems['url']) && $menuItems['url'] != '')//link
                        $htmlNav .= CHtml::link($addIcon . $menuItems['label'], $menuItems['url'], ['class' => 'btn btn-default']);
                }
            }
        }
        $htmlNav .= '</div>'
            . '</div>'
            . '<input type="hidden" value="' . Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id . '/deletebulk') . '" id="deleteAllAction">'
            . '<div class="clr"></div>';
        echo $htmlNav;
    }

    public function baseControllerIndexUrl() {
        return Yii::app()->createAbsoluteUrl('admin/' . Yii::app()->controller->id);
    }

    public function loadModel($modelName, $id) {
        $initModel = new $modelName;
        $model = $initModel::model()->findByPk($id);
        if(empty($model)) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    public function actionDelete($id) {
        try {
            if (Yii::app()->request->isPostRequest) { 
                $modelName = $_GET['model_name'];
                $model = $this->loadModel($modelName, $id);
                if($model) {

                    Yii::log("Delete record ", 'info');

                    //for log
                    $data = [
                        'data' => 'Deleted a ' . $modelName,
                        'record_id' => $model->id
                    ];

                    ActivityLogs::writeLog($data);
                    //

                    $model->delete();
                }

            } else {
                Yii::log("Invalid request. Please do not repeat this request again.");
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            }
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }


    public function actionDeleteBulk() {
        try {

            if (Yii::app()->request->isPostRequest) { 
                $deleteItems = $_POST['index_grid_c0'];
                $modelName = Yii::app()->request->getPost('model_name', null);
                $models = $modelName::model()->findAll('id in (' . implode(',', $deleteItems) . ')');

                foreach ($models as $model) {
                    $model->delete();
                }

                Yii::app()->user->setFlash('success', 'Your selected records have been deleted');

                //for log
                $data = [
                    'data' => 'Deleted ' . $modelName . " id:" . implode(',', $deleteItems),
                ];

                ActivityLogs::writeLog($data);
                //


                $this->redirect('index');

            } else {
                Yii::log("Invalid request. Please do not repeat this request again.");
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            }
            
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }
}

?>