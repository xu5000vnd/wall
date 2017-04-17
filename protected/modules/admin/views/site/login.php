<div class="container">
<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'admin-login-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
        ),
        'htmlOptions' => array('role' => "form", 'class'=>'login-form'),
    ));
?>

    <div class="login-wrap">
        <p class="login-img"><i class="icon_lock_alt"></i></p>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon_profile"></i></span>
            <?php echo $form->textField($model, 'username', array('size' => 40, 'class' => "form-control", 'placeholder'=>"Username", 'autofocus'=>true)); ?>
        </div>
            <?php echo $form->error($model, 'username'); ?>
        <div class="input-group">
            <span class="input-group-addon"><i class="icon_key_alt"></i></span>
            <?php echo $form->passwordField($model, 'password', array('size' => 33,'class' => "form-control", 'placeholder'=>"Password")); ?>
        </div>
            <?php echo $form->error($model, 'password'); ?>
        <label class="checkbox" for="AdminLoginForm_rememberMe">
            <?php echo $form->checkbox($model, 'rememberMe'); ?> Remeber Me
        </label>
            
        <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
    </div>

<?php $this->endWidget(); ?>
</div>