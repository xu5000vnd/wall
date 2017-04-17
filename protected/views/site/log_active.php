<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><i class="icon_document_alt"></i> Log Active</h3>
        <ol class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="<?php echo Yii::app()->request->getBaseUrl(true); ?>">Home</a></li>
            <li><i class="icon_document_alt"></i>Log Active</li>                          
        </ol>
    </div>
</div>


<div class="row search-form">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
               Search
            </header>
            <div class="panel-body">
                <?php 
                $form = $this->beginWidget('CActiveForm', array(
                    'action'=>Yii::app()->createUrl($this->route),
                    'method'=>'get',
                    'htmlOptions' => array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'search-form'),
                )); ?>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                            <?php echo $form->dropDownList($model, 'user_id', User::listData(), ['class'=>'form-control', 'empty' => 'All']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Action</label>
                        <div class="col-sm-10">
                            <?php echo $form->dropDownList($model, 'action', LogActive::$ARR_ACTION, ['class'=>'form-control', 'empty' => 'All']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <button type="button" class="btn btn-primary" id="clearsearch">Clear</button>
                            <button type="submit" class="btn btn-danger">Search</button>
                        </div>
                    </div>

                    <?php $this->endWidget(); ?>

            </div>
        </section>
    </div>
</div>


<?php 
    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'index-grid',
        'dataProvider'=> $model->search(),
        'afterAjaxUpdate'=>'function(id, data){ loadDataTable(); }',
        'itemsCssClass' => 'tb-1 tb-break',
        'htmlOptions' => array('class' => ''),
        'template'=>  '{items}{pager}',
        'pager'=>array(
            'header'         => '',
            'prevPageLabel'  => 'Prev',
            'firstPageLabel' => 'First',
            'lastPageLabel'  => 'Last',
            'nextPageLabel'  => 'Next',
            'htmlOptions' => array(
                'class' => ''
            )
        ),
        'selectableRows'=>2,
        'columns'=> array(
            [
                'name' => 'id',
                'htmlOptions' => [
                    'class' => 'all'
                ]
            ],
            [
                'header' => 'Member',
                'name' => 'user_id',
                'value' => '$data->getNameUser()',
                'htmlOptions' => [
                    'class' => 'all'
                ]
            ],
            [
                'header' => 'Action',
                'name' => 'message',
                'type' => 'raw',
                'htmlOptions' => [
                    'class' => 'all'
                ]
            ],
            'ip',
            'location',
            [
                'name' => 'created_date',
            ],
        ),

    )); 
?>