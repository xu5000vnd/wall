<div class="panel panel-default">
    
    <div class="panel-body">
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', [
                'id' => 'index-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => ['class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'],
            ]);

            ?>
            <div class="col-sm-9 col-lg-9 col-xs-12">
                
                <div class='form-group'>
                    <?php echo $form->labelEx($model, 'name', ['class' => 'col-sm-3 col-lg-3 col-xs-12 control-label']); ?>
                    <div class="col-sm-9 col-lg-9 col-xs-12">
                        <?php echo $form->textField($model, 'name', ['class' => 'form-control', 'maxlength' => 255]); ?>
                        <?php echo $form->error($model, 'name'); ?>
                    </div>
                </div>

                <div class='form-group'>
                    <?php echo $form->labelEx($model, 'description', ['class' => 'col-sm-3 col-lg-3 col-xs-12 control-label']); ?>
                    <div class="col-sm-9 col-lg-9 col-xs-12">
                        <?php echo $form->textArea($model, 'description', ['class' => 'form-control', 'cols' => 63, 'rows' => 5, 'height' => "150px", 'width' => '100%']); ?>
                        <?php echo $form->error($model, 'description'); ?>
                    </div>
                </div>

                <div class='form-group'>
                    <?php echo $form->labelEx($model, 'parent_id', ['class' => 'col-sm-3 col-lg-3 col-xs-12 control-label']); ?>
                    <div class="col-sm-9 col-lg-9 col-xs-12">
                        <?php echo $form->dropDownList($model, 'parent_id', Category::getParentCategory(), ['class' => 'form-control', 'empty'=>"-- Root --"]); ?>
                        <?php echo $form->error($model, 'parent_id'); ?>
                    </div>
                </div>

                <div class='form-group'>
                    <?php echo $form->labelEx($model, 'future', ['class' => 'col-sm-3 col-lg-3 col-xs-12 control-label']); ?>
                    <div class="col-sm-9 col-lg-9 col-xs-12">
                        <?php echo $form->checkBox($model, 'future'); ?>
                        <?php echo $form->error($model, 'future'); ?>
                    </div>
                </div>

                <div class='form-group'>
                    <?php echo $form->labelEx($model, 'file_name', ['class' => 'col-sm-3 col-lg-3 col-xs-12 control-label']); ?>
                    <div class="col-sm-9 col-lg-9 col-xs-12">
                        <?php echo $form->fileField($model, 'file_name'); ?>
                        <?php echo $form->error($model, 'file_name'); ?>
                    </div>
                </div>

                <div class='form-group'>
                    <label class="col-sm-3  col-lg-3 col-xs-12 control-label">&nbsp</label>
                    <div class="control-image">
                        <?php
                            if(!$model->isNewRecord){
                                echo CHtml::Image($model->getImage('file_name', $model->file_name, ['class' => '']));        
                            }
                        ?>
                        
                    </div>
                </div>
                
                <div class="clr"></div>
            </div>
            <div class="col-sm-3 col-lg-3 col-xs-12">
                <div class='form-group'>
                    <?php echo $form->labelEx($model, 'status', ['class' => 'col-sm-12 control-label']); ?>
                    <div class="col-sm-12">
                        <?php echo $form->checkBox($model, "status", ['id' => 'status-switch']); ?>
                        <?php echo $form->error($model, 'status'); ?>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="well form-well">
                    <?php echo CHtml::htmlButton($model->isNewRecord ? '<span class="' . $this->iconCreate . '"></span> Create' : '<span class="' . $this->iconSave . '"></span> Save', ['class' => 'btn btn-primary', 'type' => 'submit']); ?> &nbsp;  
                    <?php echo CHtml::htmlButton('<span class="' . $this->iconCancel . '"></span> Cancel', ['class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'']); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>