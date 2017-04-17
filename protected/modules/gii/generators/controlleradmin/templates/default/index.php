<?php echo "<?php\n"; ?>
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
<?php echo "<?php \$this->renderControlNav();?>";?>

<div class="clr"></div>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <i class="fa fa-th-list"></i>
                Listing
            </header>
            <div class="table-responsive">
		<?php echo "<?php"; ?>
			$allowAction = in_array("deleteall", $this->listActionsCanAccess)?'CCheckBoxColumn':'';
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
				<?php
		if (isset($this->type_option['index']))
		{
		foreach ($this->type_option['index'] as $key_index => $val_index)
		{

			$link_img = '$data->getImageByField("'.$key_index.'","small")';
			$link_file = '$data->getFilesByField("'.$key_index.'",)';

			if ($val_index == 'string') {
				echo "\t\t\t\t'".$key_index."',\n";
			} elseif ($val_index == 'date') {
		echo "\t\t\t\t[
					'name' => '{$key_index}',
					'type' => 'date',
					'headerHtmlOptions' => ['style' => 'text-align:left;']
				],\n";
			} elseif ($val_index == 'datetime') {
		echo "\t\t\t\t[
					'name' => '{$key_index}',
					'type' => 'datetime',
					'headerHtmlOptions' => ['style' => 'text-align:left;']
				],\n";
			} elseif ($val_index == 'html') {
		echo "\t\t\t\t[
					'name' => '{$key_index}',
					'type' => 'html',
				],\n";
			} elseif ($val_index == 'number') {
		echo "\t\t\t\t[
					'name' => '{$key_index}',
					'headerHtmlOptions' => ['style' => 'text-align:left;']
				],\n";
			} elseif ($val_index == 'image') {
		echo "\t\t\t\t[
					'name'=>'{$key_index}',
					'type'=>'html',
					'value' => '{$link_img}'
				],\n";
			} elseif ($val_index == 'file') {
				echo "\t\t\t\t[
					'name'=>'{$key_index}',
					'type'=>'html',
					'value' => '{$link_file}'
				],\n";
			} elseif ($val_index == 'status') {
		echo "\t\t\t\t[
					'name'=>'{$key_index}',
					'type'=>'status',
					'value'=>'[".'"id"'."=>\$data->id,".'"status"'."=>\$data->status]',
					'headerHtmlOptions' => ['style' => 'text-align:left;']
			    ],\n";
			} elseif (isset($key_index) && $key_index == 'extend_attributes') {
				foreach ($this->type_option['index']['extend_attributes'] as $ke => $ex) {
					if ($ex["relation_type"] == 'string') {
				echo "\t[
							'name' => '{$ex["attr_name"]}',
							'value' => '\$data->{$ex["relation_name"]}->{$ex["attr_name"]}',
						],\n";
					} elseif ($ex["relation_type"] == 'number') {
				echo "[
							'name' => '{$ex["attr_name"]}',
							'value' => '\$data->{$ex["relation_name"]}->{$ex["attr_name"]}',
							'headerHtmlOptions' => ['style' => 'text-align:left;']    
						],\n";
					}
				}
			}elseif (isset($this->type_option['index']['action']) && count($val_index) > 0 && $key_index == 'action') {
				$item_action = '';
				foreach ($this->type_option['index']['action'] as $ka => $val_a) {
					$item_action .= $val_a;
				}
                echo "\t\t\t\t[
                    'header' => 'Actions',
                    'class'=>'CButtonColumn',					
                    'template' => AccessRights::createIndexButtonRoles(\$actions),
                    'buttons' => \$this->gridviewDefaultButton()
				],\n";
			}
		}
		}
				?>
                ]);
                $form=$this->beginWidget('CActiveForm', [
                'id' => 'index_grid-bulk',
                'enableAjaxValidation' => false,
                'htmlOptions' => ['enctype' => 'multipart/form-data']]);
                ?>
                <div class="btn-group-head">
                <?php echo "<?php
                    \$this->renderNotifyMessage(); 
                    \$this->renderUpdateStatusAllButton();
                ?>\n";?>
                </div>
				<?php
                $id = $this->class2id($this->model_name).'-grid';
                ?>
                <?php echo "<?php
                    \$this->renderGridview(\$model->search(), \$columnArray, \$id = '".$id."');
                    \$this->endWidget();
	            ?>\n"; ?>
            </div>
        </section>
    </div>
</div>
