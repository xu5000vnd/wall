<section class="panel">
    <div class="panel-body">
        <div class="form">
                <?php echo "<?php \$form=\$this->beginWidget('MyActiveForm', [
                'id' => '" . $this->class2id($this->model_name) . "-form',
                'enableClientValidation' => false,
                'clientOptions' => [
                        'validateOnSubmit' => false,
                    ],
                'htmlOptions' => ['class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'],
                ]); ?>\n"; ?>
             <div class="col-sm-9 col-lg-9 col-xs-12">
                <?php
                if (isset($this->type_option['form'])) {
                    echo "<div class='form-group'>\n";
                    $index_form = 0;
                    foreach ($this->type_option['form'] as $key => $val) {
                        $str_class_two_column = '';
                        if (count($this->type_option['form']) > 6) {
                            $str_class_two_column = 'col-md-6';
                        }
                        echo "<div class='$str_class_two_column'>\n";
                        echo "\t\t\t\t\t<?php echo \$form->labelEx(\$model,'{$key}', ['class' => 'col-sm-3 control-label']); ?>\n";
                        if ($val == 'text') {
                            echo "\t\t\t\t\t<div class=\"col-sm-9\">\n";
                            echo "\t\t\t\t\t\t<?php echo \$form->textField(\$model,'{$key}', ['class' => 'form-control', 'maxlength' => 255]); ?>\n";
                        } elseif ($val == 'date_picker') {
                            if (count($this->type_option['form']) > 6) {
                                echo "\t\t\t\t\t<div class=\"col-sm-9\">\n";
                            } else {
                                echo "\t\t\t\t\t<div class=\"col-sm-3\">\n";
                            }
                            echo "<div class=\"input-group date ver_datepicker\" id=\"{$key}\">\n";
                            echo "\t\t\t\t\t\t<?php echo \$form->textField(\$model,'{$key}', ['class' => 'form-control']); ?>\n";
                            echo "<span class=\"input-group-addon\">\n";
                            echo "<span class=\"glyphicon glyphicon-calendar\"></span>\n";
                            echo "</span>\n";
                            echo "</div>\n";
                            echo "<div class=\"clr\"></div>\n";
                        } elseif ($val == 'date_time_picker') {
                            if (count($this->type_option['form']) > 6) {
                                echo "\t\t\t\t\t<div class=\"col-sm-9\">\n";
                            } else {
                                echo "\t\t\t\t\t<div class=\"col-sm-3\">\n";
                            }
                            echo "<div class=\"input-group date ver_datetimepicker\" id=\"{$key}\">\n";
                            echo "\t\t\t\t\t\t<?php echo \$form->textField(\$model,'{$key}', ['class' => 'form-control']); ?>\n";
                            echo "<span class=\"input-group-addon\">\n";
                            echo "<span class=\"glyphicon glyphicon-calendar\"></span>\n";
                            echo "</span>\n";
                            echo "</div>\n";
                            echo "<div class=\"clr\"></div>\n";
                        } elseif ($val == 'time') {
                            if (count($this->type_option['form']) > 6) {
                                echo "\t\t\t\t\t<div class=\"col-sm-9\">\n";
                            } else {
                                echo "\t\t\t\t\t<div class=\"col-sm-3\">\n";
                            }
                            echo "<div class=\"input-group ver_timepicker\" id=\"{$key}\">\n";
                            echo "\t\t\t\t\t\t<?php echo \$form->textField(\$model,'{$key}', ['class' => 'form-control']); ?>\n";
                            echo "<span class=\"input-group-addon\">\n";
                            echo "<span class=\"glyphicon glyphicon-time\"></span>\n";
                            echo "</span>\n";
                            echo "</div>\n";
                            echo "<div class=\"clr\"></div>\n";
                        } elseif (isset($val[0]) && $val[0] == 'textarea') {
                            echo "\t\t\t\t\t<div class=\"col-sm-9\">\n";
                            echo "\t\t\t\t\t\t<?php echo \$form->textArea(\$model,'{$key}', ['cols' => 63, 'rows' => 5]); ?>\n";
                        } elseif (isset($val[0]) && $val[0] == 'image') {
                            $multi_select = 'false';
                            if ($val[1] == 'multiple') {
                                $multi_select = 'true';
                            }

                            echo '<?php $upload = new FilesUpload(); ?>';
                            echo "\t\t\t\t\t<div class=\"col-sm-9\">\n";
                            echo "\t\t\t\t\t<?php\n";
                            echo "\$this->widget('SmartUpload', [
                                'form_id' => '" . $this->class2id($this->model_name) . "-form',
                                'model' => \$upload,
                                'parent' => \$model,
                                'field_name' => 'images',
                                'view_id' => 'file_view_images',
                                'multi_select' => $multi_select,
                                'attributes' => [
                                    'images' => ['type' => 'file', 'value' => ''],
                                ],
                                'action' => Yii::app()->createAbsoluteUrl('ajax/smartupload')
                            ]);";

                            echo "\t\t\t\t\t?>\n";
                            echo "\t\t\t\t\t<div id=\"file_view_images\"></div>\n";
                            echo "\t\t\t\t\t<div class=\"clearfix\"></div>\n";
                        } elseif (isset($val[0]) && $val[0] == 'file') {
                            $multi_select = 'false';
                            if ($val[1] == 'multiple') {
                                $multi_select = 'true';
                            }

                            echo '<?php $upload = new FilesUpload(); ?>';
                            echo "\t\t\t\t\t<div class=\"col-sm-9\">\n";
                            echo "\t\t\t\t\t<?php\n";
                            echo "\$this->widget('SmartUpload', [
                                'form_id' => '" . $this->class2id($this->model_name) . "-form',
                                'model' => \$upload,
                                'parent' => \$model,
                                'field_name' => 'files',
                                'view_id' => 'file_view_files',
                                'multi_select' => $multi_select,
                                'attributes' => [
                                    'files' => ['type' => 'file', 'value' => ''],
                                ],
                                'action' => Yii::app()->createAbsoluteUrl('ajax/smartupload')
                            ]);";

                            echo "\t\t\t\t\t?>\n";
                            echo "\t\t\t\t\t<div id=\"file_view_files\"></div>\n";
                            echo "\t\t\t\t\t<div class=\"clearfix\"></div>\n";
                        } elseif (isset($val[0]) && $val[0] == 'ckeditor' && $val[1] == 'full') {
                            echo "\t\t\t\t\t<div class=\"col-sm-9\">\n";
                            echo "\t\t\t\t\t\t<?php echo \$form->textArea(\$model,'{$key}', ['class' => 'editor-full', 'cols' => 63, 'rows' => 5, 'height' => '500px', 'width' => '100%']); ?>\n";
                        } elseif (isset($val[0]) && $val[0] == 'ckeditor' && $val[1] == 'basic') {
                            echo "\t\t\t\t\t<div class=\"col-sm-9\">\n";
                            echo "\t\t\t\t\t\t<?php echo \$form->textArea(\$model,'{$key}', ['class' => 'editor-basic', 'cols' => 63, 'rows' => 5, 'height' => '150px', 'width' => '100%']); ?>\n";
                        } elseif ($val == 'status') {
                            echo "\t\t\t\t\t<div class=\"col-sm-9\">\n";
                            echo "\t\t\t\t\t\t<?php echo \$form->checkBox(\$model,'{$key}', ['id' => 'status-switch']); ?>\n";
                        } elseif ($val == 'yesno') {
                            echo "\t\t\t\t\t<div class=\"col-sm-9\">\n";
                            echo "\t\t\t\t\t\t<?php echo \$form->dropDownList(\$model, '{$key}', \$model->optionYesNo, ['class' => 'form-control']); ?>\n";
                        } elseif ($val == 'number') {
                            echo "\t\t\t\t\t<div class=\"col-sm-9\">\n";
                            echo "\t\t\t\t\t\t<?php echo \$form->textField(\$model,'{$key}', ['class' => 'numeric-control form-control ver_number', 'maxlength' => 10]); ?>\n";
                        } elseif ($val == 'password') {
                            echo "\t\t\t\t\t<div class=\"col-sm-9\">\n";
                            echo "\t\t\t\t\t\t<?php echo \$form->passwordField(\$model,'{$key}', ['class' => 'form-control', 'maxlength' => 30]); ?>\n";
                        }
                        echo "\t\t\t\t\t\t<?php echo \$form->error(\$model,'{$key}'); ?>\n";
                        echo "\t\t\t\t\t</div>\n";
                        echo "\t\t\t\t<div class=\"clr\"></div>\n";
                        echo "\t\t\t</div>\n";

                        $index_form++;
                        if (count($this->type_option['form']) > 6) {
                            if ($index_form % 2 == 0) {
                                echo "</div><div class='form-group'>\n";
                            }
                        } else {
                            echo "</div><div class='form-group'>\n";
                        }
                        ?>
                    <?php
                    }
                    echo "</div>\n";
                }
                ?>
                <div class="clr"></div>
             </div>
            <div class="col-sm-3 col-lg-3 col-xs-12">
                <div class="well form-well">
                    <?php echo "<?php echo CHtml::htmlButton(\$model->isNewRecord ? '<span class=\"' . \$this->iconCreate . '\"></span> Create' : '<span class=\"' . \$this->iconSave . '\"></span> Save', ['class' => 'btn btn-primary', 'type' => 'submit']); ?> &nbsp; "; ?>
                    <?php echo "<?php echo CHtml::htmlButton('<span class=\"' . \$this->iconCancel . '\"></span> Cancel', ['class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\'' . \$this->baseControllerIndexUrl() . '\'']); ?>\n"; ?>
                </div>
            </div>
            <?php echo "<?php \$this->endWidget(); ?>\n"; ?>
        </div>
    </div>
</section>