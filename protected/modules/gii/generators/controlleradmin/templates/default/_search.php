<div class='search-form'>
    <section class="panel">
        <header class="panel-heading">
            <i class="icon_search"></i>
            Advanced Search
            <a href="javascript:voice(0)" class="search-button pull-right">Hide</a>
        </header>
        <div class="panel-body">
            <?php echo "<?php \$form = \$this->beginWidget('CActiveForm',[
		'action'=>Yii::app()->createUrl(\$this->route),
		'method'=>'get',
		'htmlOptions' => ['class' => 'form-horizontal', 'role' => 'form', 'id' => 'search-form'],
        ]); ?>\n";
            ?>

            <?php
            if (!empty($this->type_option['search'])):
                echo "\t\t" . '<div class="form-group">' . "\n";
                $index = 0;
                foreach ($this->type_option['search'] as $key => $val) {
                    echo "\t\t\t" . '<div class="col-lg-6">' . "\n";
                    echo "\t\t\t\t\t<?php echo \$form->labelEx(\$model,'{$key}', ['class' => 'col-lg-4 control-label']); ?>\n";
                    echo "\t\t\t\t\t<div class=\"col-lg-8\">\n";
                    if ($val == 'text') {
                        echo "\t\t\t\t\t\t<?php echo \$form->textField(\$model,'{$key}', ['class' => 'form-control']); ?>\n";
                    } elseif ($val == 'date_picker') {
                        echo "\t\t\t\t\t\t<div class='input-group date ver_datepicker' id=\"search_{$key}\">";
                        echo "\t\t\t\t\t\t\t<?php echo \$form->textField(\$model,'{$key}', ['class' => 'form-control', 'maxlength' => 255]); ?>\n";
                        echo "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-calendar\"></span></span>";
                        echo "\t\t\t\t\t\t</div>";
                    } elseif ($val == 'date_time_picker') {
                        echo "\t\t\t\t\t\t<div class='input-group date ver_datetimepicker' id=\"search_{$key}\">";
                        echo "\t\t\t\t\t\t\t<?php echo \$form->textField(\$model,'{$key}', ['class' => 'form-control', 'maxlength' => 255]); ?>\n";
                        echo "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-calendar\"></span></span>";
                        echo "\t\t\t\t\t\t</div>";
                    } elseif ($val == 'time') {
                        echo "\t\t\t\t\t\t<div class='input-group date ver_timepicker' id=\"search_{$key}\">";
                        echo "\t\t\t\t\t\t\t<?php echo \$form->textField(\$model,'{$key}', ['class' => 'form-control', 'maxlength' => 255]); ?>\n";
                        echo "\t\t\t\t\t\t\t<span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-calendar\"></span></span>";
                        echo "\t\t\t\t\t\t</div>";
                    } elseif ($val == 'dropdown') {
                        echo "\t\t\t\t\t\t<?php echo \$form->dropDownList(\$model,'{$key}', \$model->optionActive, ['class' => 'form-control','empty'=>'All']); ?>\n";
                    } elseif ($val == 'yesno') {
                        echo "\t\t\t\t\t\t<?php echo \$form->dropDownList(\$model, '{$key}', MyActiveRecord::getYesNo(), ['class' => 'form-control']); ?>";
                    }
                    echo "\t\t\t\t\t\t<?php echo \$form->error(\$model,'{$key}'); ?>\n";
                    echo "\t\t\t\t\t</div>\n";
                    echo "\t\t\t\t</div>\n";

                    $index++;
                    if ($index % 2 == 0) {
                        echo "\t\t" . '</div><div class="form-group">' . "\n";
                    }
                }
                echo "\t\t" . '</div>' . "\n";
            endif;
            ?>

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <?php echo '<?php echo CHtml::htmlButton(\'<i class="glyphicon \' . $this->iconSearch . \'"></i>  Search\', [\'class\' => \'btn btn-primary\', \'type\' => \'submit\']); ?>'; ?>
                    <?php echo '<?php echo CHtml::htmlButton(\'<i class="glyphicon \' . $this->iconCancel . \'"></i> Clear\', [\'class\' => \'btn btn-default\', \'type\' => \'reset\', \'id\' => \'clearsearch\']); ?>'; ?>
                </div>
            </div> 
            <?php echo "<?php \$this->endWidget(); ?>\n"; ?>

        </div>
    </section>
</div>

