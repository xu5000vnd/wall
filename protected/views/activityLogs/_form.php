<section class="panel">
    <div class="panel-body">
        <div class="form">
                <?php $form=$this->beginWidget('MyActiveForm', [
                'id' => 'activity-logs-form',
                'enableClientValidation' => false,
                'clientOptions' => [
                        'validateOnSubmit' => false,
                    ],
                'htmlOptions' => ['class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'],
                ]); ?>
             <div class="col-sm-9 col-lg-9 col-xs-12">
                <div class='form-group'>
<div class='col-md-6'>
					<?php echo $form->labelEx($model,'action', ['class' => 'col-sm-3 control-label']); ?>
					<div class="col-sm-9">
						<?php echo $form->textField($model,'action', ['class' => 'form-control', 'maxlength' => 255]); ?>
						<?php echo $form->error($model,'action'); ?>
					</div>
				<div class="clr"></div>
			</div>
                    <div class='col-md-6'>
					<?php echo $form->labelEx($model,'controller', ['class' => 'col-sm-3 control-label']); ?>
					<div class="col-sm-9">
						<?php echo $form->textField($model,'controller', ['class' => 'form-control', 'maxlength' => 255]); ?>
						<?php echo $form->error($model,'controller'); ?>
					</div>
				<div class="clr"></div>
			</div>
</div><div class='form-group'>
                    <div class='col-md-6'>
					<?php echo $form->labelEx($model,'module', ['class' => 'col-sm-3 control-label']); ?>
					<div class="col-sm-9">
						<?php echo $form->textField($model,'module', ['class' => 'form-control', 'maxlength' => 255]); ?>
						<?php echo $form->error($model,'module'); ?>
					</div>
				<div class="clr"></div>
			</div>
                    <div class='col-md-6'>
					<?php echo $form->labelEx($model,'user_id', ['class' => 'col-sm-3 control-label']); ?>
					<div class="col-sm-9">
						<?php echo $form->textField($model,'user_id', ['class' => 'form-control', 'maxlength' => 255]); ?>
						<?php echo $form->error($model,'user_id'); ?>
					</div>
				<div class="clr"></div>
			</div>
</div><div class='form-group'>
                    <div class='col-md-6'>
					<?php echo $form->labelEx($model,'type', ['class' => 'col-sm-3 control-label']); ?>
					<div class="col-sm-9">
						<?php echo $form->textField($model,'type', ['class' => 'form-control', 'maxlength' => 255]); ?>
						<?php echo $form->error($model,'type'); ?>
					</div>
				<div class="clr"></div>
			</div>
                    <div class='col-md-6'>
					<?php echo $form->labelEx($model,'record_id', ['class' => 'col-sm-3 control-label']); ?>
					<div class="col-sm-9">
						<?php echo $form->textField($model,'record_id', ['class' => 'form-control', 'maxlength' => 255]); ?>
						<?php echo $form->error($model,'record_id'); ?>
					</div>
				<div class="clr"></div>
			</div>
</div><div class='form-group'>
                    <div class='col-md-6'>
					<?php echo $form->labelEx($model,'ip', ['class' => 'col-sm-3 control-label']); ?>
					<div class="col-sm-9">
						<?php echo $form->textField($model,'ip', ['class' => 'form-control', 'maxlength' => 255]); ?>
						<?php echo $form->error($model,'ip'); ?>
					</div>
				<div class="clr"></div>
			</div>
                    <div class='col-md-6'>
					<?php echo $form->labelEx($model,'data', ['class' => 'col-sm-3 control-label']); ?>
					<div class="col-sm-9">
						<?php echo $form->textArea($model,'data', ['class' => 'editor-full', 'cols' => 63, 'rows' => 5, 'height' => '500px', 'width' => '100%']); ?>
						<?php echo $form->error($model,'data'); ?>
					</div>
				<div class="clr"></div>
			</div>
</div><div class='form-group'>
                    <div class='col-md-6'>
					<?php echo $form->labelEx($model,'model', ['class' => 'col-sm-3 control-label']); ?>
					<div class="col-sm-9">
						<?php echo $form->textField($model,'model', ['class' => 'form-control', 'maxlength' => 255]); ?>
						<?php echo $form->error($model,'model'); ?>
					</div>
				<div class="clr"></div>
			</div>
                    </div>
                <div class="clr"></div>
             </div>
            <div class="col-sm-3 col-lg-3 col-xs-12">
                <div class="well form-well">
                    <?php echo CHtml::htmlButton($model->isNewRecord ? '<span class="' . $this->iconCreate . '"></span> Create' : '<span class="' . $this->iconSave . '"></span> Save', ['class' => 'btn btn-primary', 'type' => 'submit']); ?> &nbsp;                     <?php echo CHtml::htmlButton('<span class="' . $this->iconCancel . '"></span> Cancel', ['class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . $this->baseControllerIndexUrl() . '\'']); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</section>