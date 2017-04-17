<?php
$this->breadcrumbs = [$this->pluralTitle];
$this->menu = [
    ['label' => 'Create ' . $this->singleTitle, 'url' => ['create']],
    ['label' => 'Bulk Delete', 'url' => ['deletebulk'],  'htmlOpts' => ['class' => 'btn btn-default deleteall-button', 'type' => 'button']]
];
$this->renderBreadcrumbs($this->pluralTitle);
$this->renderPartial('_search', ['model' => $model]);
?>

<?php $this->renderControlNav(); ?>
<div class="clr"></div>
<br/>
<br/>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <i class="fa fa-th-list"></i>
                Listing
            </header>
            <div class="table-responsive">
        <?php           
            $columnArray = [];
            $columnArray = array_merge($columnArray, [
                [
                    'value' => '$data->id',
                    'class' => "CCheckBoxColumn",
                ],
                [
                    'header' => 'S/N',
                    'type' => 'raw',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    'headerHtmlOptions' => ['width' => '30px','style' => 'text-align:center;'],
                    'htmlOptions' => ['style' => 'text-align:center;']
                ],
                [
                    'name' => 'name',
                ],
                [
                    'name' => 'parent_id',
                    'value' => '$data->getNameParent()'
                ],
                [
                    'name' => 'future',
                    'type' => 'yesNo'
                ],
                [
                    'name' => 'created_date',
                    'type' => 'date',
                ],
                [
                    'header' => 'Actions',
                    'class'=>'CButtonColumn',                   
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => [
                            'options' => ['class' => 'btn', 'title' => 'Update'],
                            'label' => '<i class="icon_pencil-edit"></i>',
                            'imageUrl' => false,
                        ],

                        'delete' => [
                            'options' => ['title' => 'Delete'],
                            'label' => '<i class="icon_close_alt2"></i>',
                            'imageUrl' => false,
                            'url' => 'url("admin/".Yii::app()->controller->id."/delete",["id"=>$data->id,"model_name"=>get_class($data)])'
                        ],
                    ],
                ],
                ]);

                $form=$this->beginWidget('CActiveForm', [
                'id' => 'index_grid-bulk',
                'enableAjaxValidation' => false,
                'htmlOptions' => ['enctype' => 'multipart/form-data']]);
                ?>

                <input name="model_name" value="<?php echo get_class($model); ?>" type="hidden" />

                <div class="btn-group-head">
                <?php
                    $this->renderNotifyMessage(); 
                ?>
                </div>

                <?php 
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'index_grid',
                    'dataProvider' => $model->search(),
                    'itemsCssClass' => 'tb-1 tb-break',
                    'afterAjaxUpdate'=>'function(id, data){ loadDataTable(); }',
                    'htmlOptions' => array('class' => 'grid-view'),
                    'template'=>  '{summary}{items}{pager}',
                    'pager' => array(
                        'header' => '',
                        'prevPageLabel' => 'Prev',
                        'firstPageLabel' => 'First',
                        'lastPageLabel' => 'Last',
                        'nextPageLabel' => 'Next',
                    ),
                    'selectableRows' => 2,
                    'columns' => $columnArray,
                ));


                $this->endWidget();
                ?>

            </div>
        </section>
    </div>
</div>
