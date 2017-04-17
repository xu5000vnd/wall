<?php
$this->breadcrumbs = [$this->pluralTitle];
$this->menu = [
	['label' => 'Create ' . $this->singleTitle, 'url' => ['create']],
	['label' => Yii::t('translation', 'Export'), 'url' => ['export']],
    ['label' => 'Bulk Delete', 'url' => ['deleteall'],  'htmlOpts' => ['class' => 'btn btn-default deleteall-button', 'type' => 'button']]
];
$this->renderBreadcrumbs($this->pluralTitle);
$this->renderPartial('_search', ['model' => $model]);
?>

<div class="clr"></div>
<?php $this->renderControlNav();?>
<div class="clr"></div>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <i class="fa fa-th-list"></i>
                Listing
            </header>
            <div class="table-responsive">
		<?php			$allowAction = in_array("deleteall", $this->listActionsCanAccess)?'CCheckBoxColumn':'';
			$columnArray = [];
			if (in_array("DeleteAll", $this->listActionsCanAccess))
			{
                $columnArray[] = [
                    'value' => '$data->id',
                    'class' => "CCheckBoxColumn",
                ];
			}
			$columnArray = array_merge($columnArray, [
				[
					'header' => 'S/N',
					'type' => 'raw',
					'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
					'headerHtmlOptions' => ['width' => '30px','style' => 'text-align:center;'],
					'htmlOptions' => ['style' => 'text-align:center;']
				],
								[
                    'header' => 'Actions',
                    'class'=>'CButtonColumn',					
                    'template' => AccessRights::createIndexButtonRoles($actions),
                    'buttons' => $this->gridviewDefaultButton()
				],
				[
					'name' => 'user_id',
					'headerHtmlOptions' => ['style' => 'text-align:left;']
				],
				[
					'name' => 'type',
					'headerHtmlOptions' => ['style' => 'text-align:left;']
				],
				[
					'name' => 'created_date',
					'type' => 'date',
					'headerHtmlOptions' => ['style' => 'text-align:left;']
				],
				'ip',
                ]);
                $form=$this->beginWidget('CActiveForm', [
                'id' => 'index_grid-bulk',
                'enableAjaxValidation' => false,
                'htmlOptions' => ['enctype' => 'multipart/form-data']]);
                ?>
                <div class="btn-group-head">
                <?php
                    $this->renderNotifyMessage(); 
                    $this->renderUpdateStatusAllButton();
                ?>
                </div>
				                <?php
                    $this->renderGridview($model->search(), $columnArray, $id = 'activity-logs-grid');
                    $this->endWidget();
	            ?>
            </div>
        </section>
    </div>
</div>
