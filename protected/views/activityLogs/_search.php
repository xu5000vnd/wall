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
					<?php echo $form->labelEx($model,'user_id', ['class' => 'col-lg-4 control-label']); ?>
					<div class="col-lg-8">
						<?php echo $form->textField($model,'user_id', ['class' => 'form-control']); ?>
						<?php echo $form->error($model,'user_id'); ?>
					</div>
				</div>
			<div class="col-lg-6">
					<?php echo $form->labelEx($model,'type', ['class' => 'col-lg-4 control-label']); ?>
					<div class="col-lg-8">
						<?php echo $form->textField($model,'type', ['class' => 'form-control']); ?>
						<?php echo $form->error($model,'type'); ?>
					</div>
				</div>
		</div><div class="form-group">
			<div class="col-lg-6">
					<?php echo $form->labelEx($model,'created_date', ['class' => 'col-lg-4 control-label']); ?>
					<div class="col-lg-8">
						<div class='input-group date ver_datepicker' id="search_created_date">							<?php echo $form->textField($model,'created_date', ['class' => 'form-control', 'maxlength' => 255]); ?>
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>						</div>						<?php echo $form->error($model,'created_date'); ?>
					</div>
				</div>
			<div class="col-lg-6">
					<?php echo $form->labelEx($model,'ip', ['class' => 'col-lg-4 control-label']); ?>
					<div class="col-lg-8">
						<?php echo $form->textField($model,'ip', ['class' => 'form-control']); ?>
						<?php echo $form->error($model,'ip'); ?>
					</div>
				</div>
		</div><div class="form-group">
		</div>

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <?php echo CHtml::htmlButton('<i class="glyphicon ' . $this->iconSearch . '"></i>  Search', ['class' => 'btn btn-primary', 'type' => 'submit']); ?>                    <?php echo CHtml::htmlButton('<i class="glyphicon ' . $this->iconCancel . '"></i> Clear', ['class' => 'btn btn-default', 'type' => 'reset', 'id' => 'clearsearch']); ?>                </div>
            </div> 
            <?php $this->endWidget(); ?>

        </div>
    </section>
</div>

