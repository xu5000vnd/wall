<div class='search-form'>
    <section class="panel">
        <header class="panel-heading">
            <i class="icon_search"></i>
            Advanced Search
            <a href="javascript:voice(0)" class="search-button pull-right">Hide</a>
        </header>
        <div class="panel-body">
            <?php $form = $this->beginWidget('CActiveForm',[
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
        'htmlOptions' => ['class' => 'form-horizontal', 'role' => 'form', 'id' => 'search-form'],
        ]); ?>

        <div class="form-group">
            <div class="col-lg-6">
                <?php echo $form->labelEx($model,'name', ['class' => 'col-lg-4 control-label']); ?>
                <div class="col-lg-8">
                    <?php echo $form->textField($model,'name', ['class' => 'form-control']); ?>
                    <?php echo $form->error($model,'name'); ?>
                </div>
            </div>

            <div class="col-lg-6">
                <?php echo $form->labelEx($model,'parent_id', ['class' => 'col-lg-4 control-label']); ?>
                <div class="col-lg-8">
                    <?php echo $form->dropDownList($model,'parent_id', Category::getParentCategory(), ['class' => 'form-control', 'empty' => 'All']); ?>
                    <?php echo $form->error($model,'parent_id'); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-6">
                <?php echo $form->labelEx($model,'future', ['class' => 'col-lg-4 control-label']); ?>
                <div class="col-lg-8">
                    <?php echo $form->dropDownList($model,'future', $model->arrYesNo, ['class' => 'form-control', 'empty' => 'All']); ?>
                    <?php echo $form->error($model,'future'); ?>
                </div>
            </div>
        </div>


        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <?php echo CHtml::htmlButton('<i class="glyphicon ' . $this->iconSearch . '"></i>  Search', ['class' => 'btn btn-primary', 'type' => 'submit']); ?>                    
                <?php echo CHtml::htmlButton('<i class="glyphicon ' . $this->iconCancel . '"></i> Clear', ['class' => 'btn btn-default', 'type' => 'reset', 'id' => 'clearsearch']); ?>                
            </div>
        </div> 
        <?php $this->endWidget(); ?>

        </div>
    </section>
</div>

