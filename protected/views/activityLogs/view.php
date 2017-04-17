<?php
$this->breadcrumbs = [$this->pluralTitle => ['index'], 'View ' . $this->singleTitle . ' : ' . $title_name];

$this->menu = [
    ['label' => $this->pluralTitle, 'url' =>['index'], 'icon' => $this->iconList],  
    ['label' => 'Update '. $this->singleTitle, 'url' => ['update', 'id'=>$model->id]],
    ['label' => 'Create ' . $this->singleTitle, 'url' => ['create']],
];   
$this->renderBreadcrumbs('View ' . $this->singleTitle . ' : ' . $title_name);
?>

<?php
//for notify message
$this->renderNotifyMessage(); 
//for list action button
$this->renderControlNav();
?><div class="panel panel-default">
    <div class="panel-body">
    <?php $this->widget('zii.widgets.CDetailView', [
    'data'=>$model,
    'attributes'=>[ 
        
				'action',

				'controller',

				'module',

				'user_id',

				'type',

				'record_id',
				['name' => 'created_date', 'type' => 'date'],

				'ip',
				['name' => 'data', 'type' => 'html'],

				'model',
        ],
    ]); ?>
    <div class="well">
        <?php echo CHtml::htmlButton('<span class="' . $this->iconBack . '"></span> Back', ['class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\''.  $this->baseControllerIndexUrl() . '\'']); ?>    </div>
    </div>
</div>
