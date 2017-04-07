<?php 
class AdminController extends _BaseController {
	public $layout = '/layouts/main';

	public $breadcrumbs = [];

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
}

?>