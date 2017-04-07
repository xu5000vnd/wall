<?php
$this->breadcrumbs = array(
    'System Configurations',
);
$this->renderBreadcrumbs('<i class="icon_cogs"></i>System Configurations');
?>

<?php if (Yii::app()->user->hasFlash('setting_s')): ?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('setting_s'); ?>
    </div>
<?php elseif (Yii::app()->user->hasFlash('setting_e')): ?>
    <div class="alert alert-danger">
        <?php echo Yii::app()->user->getFlash('setting_e'); ?>
    </div>
<?php endif; ?>
<section class="panel">
	<div class="panel-body">
		<div class="form">


        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'setting-form-admin-form',
            'enableAjaxValidation' => false,
            'method' => 'post',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'class' => "form-horizontal", 'role' => "form"),
        ));
        ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php // echo $form->errorSummary($model);  ?>

        <ul class="nav nav-tabs">
            <?php
            $i = 1;
            if (SettingForm::$settingDefine && is_array(SettingForm::$settingDefine)):
                foreach (SettingForm::$settingDefine as $key => $item):
                    $active = $i == 1 ? ' class="active" ' : '';
                    $itemObject = (object) $item;
                    ?>
            <li <?php echo $active; ?>><a class="link-<?php echo $key; ?>" href="#<?php echo $key; ?>" data-toggle="tab"><?php echo $itemObject->icon ?> &nbsp <?php echo $itemObject->label ?></a></li>
                    <?php
                    $i++;
                endforeach;
            endif;
            ?>
        </ul>
        <br />
        <div class="tab-content">
            <?php
            $i = 1;
            if (SettingForm::$settingDefine && is_array(SettingForm::$settingDefine)):
                foreach (SettingForm::$settingDefine as $key => $item):
                    $active = $i == 1 ? 'class="tab-pane active"' : 'class="tab-pane"';
                    $itemObject = (object) $item;
                    ?>
                    <div <?php echo $active ?> id="<?php echo $key; ?>">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><span class="glyphicon glyphicon-cog"></span> <?php echo $itemObject->label; ?></h3>
                            </div>
                            <div class="panel-body">
                                <div class="column">
                                    <?php
                                    $totalField = count($itemObject->items);
                                    $aHalf = (int) round($totalField / 2, 0);
                                    $i = 0;
                                    if ($itemObject->items && is_array($itemObject->items)):
                                        foreach ($itemObject->items as $data):
                                            $dataObj = (object) $data;
                                            if ($dataObj->name == 'mailDev' && Yii::app()->user->role_id != ROLE_MANAGER) {
                                                continue;
                                            }
                                            if ($totalField >= 8 && $i == 0):
                                            ?>
                                                <div class="col-sm-6">
                                            <?php elseif ($totalField >= 8 && $i % $aHalf == 0): ?>
                                                </div><div class="col-sm-6">
                                            <?php endif; ?>
                                                <div class="form-group form-group-sm">
                                                    <?php echo $form->labelEx($model, $dataObj->name, array('class' => "col-sm-3 control-label")); ?>
                                                    <?php
                                                    $unit = '';
                                                    if (isset($dataObj->unit) && $dataObj->unit != '')
                                                        $unit = ' ' . $dataObj->unit;

                                                    $note = '';
                                                    if (isset($dataObj->notes) && $dataObj->notes != '')
                                                        $note = '<div class="notes">' . $dataObj->notes . '</div>';

                                                    if ($dataObj->controlTyle == 'text'):
                                                        echo '<div class="col-sm-9">' . $form->textField($model, $dataObj->name, array_merge($dataObj->htmlOptions, array('class' => "form-control " . (isset($dataObj->htmlOptions['class']) ? $dataObj->htmlOptions['class'] : '') ))) . $unit . $note . '</div>';
                                                    elseif ($dataObj->controlTyle == 'textarea'):
                                                        echo '<div class="col-sm-9">' . $form->textArea($model, $dataObj->name, $dataObj->htmlOptions) . $note . '</div>';
                                                    elseif ($dataObj->controlTyle == 'dropdown'):
                                                        echo '<div class="col-sm-9">' . $form->dropDownList($model, $dataObj->name, $dataObj->data, array('class' => "form-control " . (isset($dataObj->htmlOptions['class']) ? $dataObj->htmlOptions['class'] : '') )) . $unit . $note . '</div>';
                                                    elseif ($dataObj->controlTyle == 'password'):
                                                        echo '<div class="col-sm-9">' . $form->passwordField($model, $dataObj->name, array_merge($dataObj->htmlOptions, array('class' => "form-control " . (isset($dataObj->htmlOptions['class']) ? $dataObj->htmlOptions['class'] : '') ))) . $unit . $note . '</div>';
                                                    elseif ($dataObj->controlTyle == 'file'):
                                                        echo '<div class="col-sm-9 clearfix">' . $form->fileField($model, $dataObj->name, array_merge($dataObj->htmlOptions, array('class' => ""))) . $unit . $note . '</div>';

                                                        if ($dataObj->name != '') {
                                                            $objName = $dataObj->name;

                                                            $fileExit = ROOT . SettingForm::PATH_UPLOAD_FILE . $model->$objName;
                                                            if (is_file($fileExit)) {
                                                                if ($objName == 'fileAuthorizationLetter') {

                                                                echo "</div>
                                                <div class='form-group form-group-sm'>";
                                                                echo '<label class="col-sm-3 control-label" for="SettingForm_' . $dataObj->name . '"></label>';
                                                                echo "<div  class=\"col-sm-3\">
                                                    <div class=''>
                                                    <a href='".Yii::app()->createAbsoluteUrl(SettingForm::PATH_UPLOAD_FILE . $model->$objName)."' download target='_blank'>{$model->$objName}</a>
                                                    </div>
                                                </div>";

                                                                } else {

                                                                echo "</div>
                                                <div class='form-group form-group-sm'>";
                                                                echo '<label class="col-sm-2 control-label" for="SettingForm_' . $dataObj->name . '"></label>';
                                                                echo "<div  class=\"col-sm-3\">
                                                    <div class='thumbnail'>
                                                    <img  src='" . Yii::app()->createAbsoluteUrl(SettingForm::PATH_UPLOAD_FILE . $model->$objName) . "'>
                                                    </div>
                                                </div>";
                                                                    
                                                                }

                                                            }
                                                        }

                                                    endif;
                                                    ?>
                                                <?php echo $form->error($model, $dataObj->name); ?>
                                                </div>
                                                <?php
                                                $i++;
                                            endforeach;
                                        endif;
                                        ?>
                                        <?php if ($key == 'mailchimp'): ?>
                                            <!-- <div class="form-group form-group-sm">						
                                                <label class="col-sm-2 control-label" for="SettingForm_mailchimpApiKey"></label>
                                                <div class="col-sm-3">
                                                    <a href="javascript:void(0)" id="get-list-mailchimp">
                                                        <button class="btn btn-default btn-sm" type="button" name="yt3">
                                                            <span class="glyphicon glyphicon-transfer"></span> Get All List ID</button>
                                                    </a>
                                                </div>							
                                            </div> 

                                            <div class="form-group form-group-sm">						
                                                <label class="col-sm-2 control-label" for="SettingForm_mailchimpApiKey"></label>
                                                <div class="col-sm-3">
                                                    <a href="<?php echo Yii::app()->createAbsoluteUrl('admin/Mailchimp/synchronize') ?>">
                                                        <button class="btn btn-default btn-sm" type="button" name="yt3" style="font-size:14px !important">
                                                            <span class="glyphicon glyphicon-transfer"></span> Synchronize</button>
                                                    </a>
                                                </div>							
                                            </div>-->
                                        <?php endif; ?>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <?php if ($totalField >= 8) echo '</div>'; ?>
                        <?php
                        $i++;
                    endforeach;
                endif;
                ?>
                <div class='clr'></div>
                <div class="form-well-setting">
                    <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                    <div class='clr'></div>
                </div>
                <div class='clr'></div>
            </div>



    <?php $this->endWidget(); ?>

        </div><!-- form -->
    </div>
</div>

    <style type="text/css">
        #test-mail{
            margin-left: 120px;
        }
        #test-mail div{
            display: none;
        }
        #test-mail .btn_send{
            margin-top: 8px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#test-mail a').click(function (e) {
                e.preventDefault();
                $('#test-mail div').toggle();
            });
            $('#test-mail .btn_send').on('click', function () {
                var email = $('#test-mail .email_test').val();

                if (email != '' && IsEmail(email) == true) {
                    $.ajax({
                        data: {email: email},
                        type: 'POST',
                        url: '<?php echo Yii::app()->createAbsoluteUrl('admin/setting/sendTestMail'); ?>',
                        success: function (response) {
                            var data = JSON.parse(response);
                            console.log(data.mess);
                        }
                    })
                } else if (IsEmail(email) == false) {
                    alert('Email wrong format!');
                } else {
                    alert('Please enter email');
                }
            });

            //button get list mailchimp
            // $('#get-list-mailchimp').click(function(e){
            //     e.preventDefault();
            //     $.ajax({
            //     	method: 'POST',
            //     	url: '<?php echo Yii::app()->createAbsoluteUrl('admin/mailchimp/getlist'); ?>',
            //     }).done(function(response){
            //         var data = JSON.parse(response);
            //     	if(data.status){
            //     		$('#SettingForm_mailchimpAllListId').append(data.html);
            //     	}
            //     });
            // });
            
            //add
            var error_page = $('#pagesetting').find('.error').length;
            if(error_page > 0){
                 $('.link-pagesetting').addClass('error-tab');
            }
            var error_social = $('#socialsetting').find('.error').length;
            if(error_social > 0){
                 $('.link-socialsetting').addClass('error-tab');
            }
            var error_general = $('#generalsetting').find('.error').length;
            if(error_general > 0){
                 $('.link-generalsetting').addClass('error-tab');
            }
            var error_email = $('#emailsetting').find('.error').length;
            if(error_email > 0){
                 $('.link-emailsetting').addClass('error-tab');
            }
            var error_mailchimp = $('#mailchimp').find('.error').length;
            if(error_mailchimp > 0){
                 $('.link-mailchimp').addClass('error-tab');
            }
            var error_gasetting = $('#gasetting').find('.error').length;
            if(error_gasetting > 0){
                 $('.link-gasetting').addClass('error-tab');
            }
            

        });

        function IsEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }
    </script>