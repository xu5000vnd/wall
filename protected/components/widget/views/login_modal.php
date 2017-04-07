<?php 
$form = $this->beginWidget('CActiveForm', array(
    'enableClientValidation'=>false,
    'enableAjaxValidation'=>true,
    'action' => url('site/loginAjax'),
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>false,
        'afterValidate' => 'js: function(form, data, hasError) {
            if (!hasError) {
                $("#modal-login").modal("hide");
            }
        }',
    ),
    'id' => 'form-checklogin',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
));  ?>
    <fieldset>
        <div class="form-group">
            <label for="email" >Username</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                </span>
                <?php echo $form->textField($model, 'username', [
                    'class' => 'form-control input-lg input-transparent',
                    'placeholder' => "Your Username"
                ]); ?>
            </div>
            <div style="color:red">
                <?php echo $form->error($model, 'username'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="password" >Password</label>
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    <i class="fa fa-lock"></i>
                </span>
                <?php echo $form->passwordField($model, 'password', [
                    'class' => 'form-control input-lg input-transparent',
                    'placeholder' => "Your Password"
                ]); ?>
            </div>
            <div style="color:red">
                <?php echo $form->error($model, 'password'); ?>
            </div>
        </div>
        <p style="font-size: 14px"><b>Your login session expired. Please login again.</b></p>
    </fieldset>
    <div class="form-actions" style="padding: 20px 15px 15px 15px;">
        <button class="btn btn-block btn-lg btn-danger" type="submit">
            Sign In
        </button>
    </div>

<?php
    $this->endWidget();
?>